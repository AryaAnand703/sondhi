import crypto from 'crypto';

function formatE164Phone(raw) {
    let p = String(raw || '').trim();
    if (p.startsWith('+')) {
        return '+' + p.slice(1).replace(/\D/g, '');
    }
    const clean = p.replace(/\D/g, '');
    if (clean.length === 10) return '+91' + clean;
    if (clean.length === 11 && clean.startsWith('0')) return '+91' + clean.slice(1);
    if (clean.length === 12 && clean.startsWith('91')) return '+' + clean;
    return '+' + clean;
}

export default async function handler(req, res) {
    res.setHeader('Access-Control-Allow-Credentials', 'true');
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'GET,OPTIONS,PATCH,DELETE,POST,PUT');
    res.setHeader('Access-Control-Allow-Headers', 'X-CSRF-Token, X-Requested-With, Accept, Accept-Version, Content-Length, Content-MD5, Content-Type, Date, X-Api-Version');

    if (req.method === 'OPTIONS') {
        res.status(200).end();
        return;
    }

    if (req.method !== 'POST') {
        return res.status(405).json({ success: false, message: 'Method not allowed. Use POST.' });
    }

    try {
        const body = typeof req.body === 'string' ? JSON.parse(req.body) : (req.body || {});
        const rawPhone = String(body.phone || body.mobile || body.phoneNumber || '').trim();
        const e164Phone = formatE164Phone(rawPhone);
        const cleanDigits = e164Phone.replace(/\D/g, '');

        if (cleanDigits.length < 10) {
            return res.status(422).json({
                success: false,
                message: 'Please provide a valid 10-digit mobile number.'
            });
        }

        // Generate 6-digit OTP
        const otp = Math.floor(100000 + Math.random() * 900000).toString();
        const timestamp = Date.now();
        const secret = process.env.APP_KEY || process.env.TWILIO_AUTH_TOKEN || 'sondhi-sanctuary-secret-key-2026';
        const signature = crypto.createHmac('sha256', secret).update(`${e164Phone}:${otp}:${timestamp}`).digest('hex');
        const verificationToken = `${timestamp}.${signature}`;

        const twilioSid = process.env.TWILIO_SID || process.env.TWILIO_ACCOUNT_SID;
        const twilioToken = process.env.TWILIO_AUTH_TOKEN || process.env.TWILIO_TOKEN;
        const twilioFrom = process.env.TWILIO_NUMBER || process.env.TWILIO_FROM || process.env.TWILIO_PHONE_NUMBER;
        const twilioVerifySid = process.env.TWILIO_VERIFY_SID;

        const hasTwilio = Boolean(twilioSid && twilioToken && (twilioFrom || twilioVerifySid));

        // If Twilio keys are not on Vercel, forward to Render backend where keys are set
        if (!hasTwilio) {
            const backendUrl = (process.env.BACKEND_URL || 'https://sondhi-1.onrender.com').replace(/\/+$/, '');
            try {
                const renderRes = await fetch(`${backendUrl}/api/auth/send-otp`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ phone: e164Phone })
                });
                const renderData = await renderRes.json();
                if (renderRes.ok && renderData && renderData.success) {
                    return res.status(200).json(renderData);
                }
            } catch (err) {
                console.warn('Render proxy error:', err.message);
            }
        }

        if (hasTwilio) {
            if (twilioVerifySid) {
                // Twilio Verify API v2
                const verifyUrl = `https://verify.twilio.com/v2/Services/${twilioVerifySid}/Verifications`;
                const params = new URLSearchParams();
                params.append('To', e164Phone);
                params.append('Channel', 'sms');

                const twilioRes = await fetch(verifyUrl, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Basic ' + Buffer.from(`${twilioSid}:${twilioToken}`).toString('base64'),
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: params.toString()
                });

                const twilioData = await twilioRes.json();
                if (!twilioRes.ok) {
                    const code = twilioData.code ? ` (Code ${twilioData.code})` : '';
                    const errMsg = twilioData.message || 'Twilio Verify service error';
                    return res.status(422).json({ success: false, message: `Twilio error${code}: ${errMsg}` });
                }

                return res.status(200).json({
                    success: true,
                    is_demo: false,
                    message: `A 6-digit verification code was sent via SMS to ${e164Phone}.`,
                    phone: rawPhone,
                    e164_phone: e164Phone,
                    verification_token: verificationToken,
                    expires_in: 600
                });
            } else {
                // Twilio Programmable SMS API
                const smsUrl = `https://api.twilio.com/2010-04-01/Accounts/${twilioSid}/Messages.json`;
                const params = new URLSearchParams();
                params.append('From', twilioFrom);
                params.append('To', e164Phone);
                params.append('Body', `Your Sondhi Atelier verification code is ${otp}. Valid for 10 minutes.`);

                const twilioRes = await fetch(smsUrl, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Basic ' + Buffer.from(`${twilioSid}:${twilioToken}`).toString('base64'),
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: params.toString()
                });

                const twilioData = await twilioRes.json();
                if (!twilioRes.ok) {
                    const code = twilioData.code ? ` (Code ${twilioData.code})` : '';
                    const errMsg = twilioData.message || 'Twilio SMS failed to dispatch';
                    return res.status(422).json({ success: false, message: `Twilio error${code}: ${errMsg}` });
                }

                return res.status(200).json({
                    success: true,
                    is_demo: false,
                    message: `A 6-digit verification code was sent via SMS to ${e164Phone}.`,
                    phone: rawPhone,
                    e164_phone: e164Phone,
                    verification_token: verificationToken,
                    expires_in: 600
                });
            }
        }

        // Demo fallback when Twilio keys are not set in environment variables
        return res.status(200).json({
            success: true,
            is_demo: true,
            message: 'Demo mode: Twilio API keys are not set in Vercel environment variables. Add TWILIO_SID, TWILIO_AUTH_TOKEN, TWILIO_NUMBER in Vercel settings for live SMS delivery.',
            phone: rawPhone,
            e164_phone: e164Phone,
            otp: otp,
            verification_token: verificationToken,
            expires_in: 600
        });

    } catch (err) {
        console.error('send-otp error:', err);
        return res.status(500).json({
            success: false,
            message: 'Server error while sending verification code: ' + err.message
        });
    }
}
