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
        const rawPhone = String(body.phone || '').trim();
        const inputOtp = String(body.otp || '').trim();
        const token = String(body.verification_token || '').trim();
        const e164Phone = formatE164Phone(rawPhone);

        if (!inputOtp || inputOtp.length < 4) {
            return res.status(422).json({
                success: false,
                message: 'Please enter the 6-digit verification code.'
            });
        }

        const twilioSid = process.env.TWILIO_SID || process.env.TWILIO_ACCOUNT_SID;
        const twilioToken = process.env.TWILIO_AUTH_TOKEN || process.env.TWILIO_TOKEN;
        const twilioVerifySid = process.env.TWILIO_VERIFY_SID;
        const hasTwilio = Boolean(twilioSid && twilioToken);

        let isValid = false;

        if (hasTwilio && twilioVerifySid) {
            // Verify via Twilio Verify API
            const checkUrl = `https://verify.twilio.com/v2/Services/${twilioVerifySid}/VerificationCheck`;
            const params = new URLSearchParams();
            params.append('To', e164Phone);
            params.append('Code', inputOtp);

            const twilioRes = await fetch(checkUrl, {
                method: 'POST',
                headers: {
                    'Authorization': 'Basic ' + Buffer.from(`${twilioSid}:${twilioToken}`).toString('base64'),
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: params.toString()
            });

            const twilioData = await twilioRes.json();
            if (twilioRes.ok && twilioData.status === 'approved') {
                isValid = true;
            }
        } else if (token && token.includes('.')) {
            // Verify HMAC token
            const [tsStr, signature] = token.split('.');
            const ts = parseInt(tsStr, 10);
            const now = Date.now();

            // 10 minutes expiry
            if (!isNaN(ts) && (now - ts) <= 10 * 60 * 1000) {
                const secret = process.env.APP_KEY || process.env.TWILIO_AUTH_TOKEN || 'sondhi-sanctuary-secret-key-2026';
                const expectedSignature = crypto.createHmac('sha256', secret).update(`${e164Phone}:${inputOtp}:${ts}`).digest('hex');
                if (signature === expectedSignature) {
                    isValid = true;
                }
            }
        }

        // Demo fallback only allowed when Twilio is NOT configured
        if (!isValid && !hasTwilio && ['8421', '842100', '123456'].includes(inputOtp)) {
            isValid = true;
        }

        if (!isValid) {
            return res.status(422).json({
                success: false,
                message: 'The entered verification code is incorrect or expired. Please check and try again.'
            });
        }

        return res.status(200).json({
            success: true,
            message: 'Mobile number verified successfully.',
            phone: rawPhone,
            e164_phone: e164Phone,
            verified: true
        });

    } catch (err) {
        console.error('verify-otp error:', err);
        return res.status(500).json({
            success: false,
            message: 'Server error while verifying code: ' + err.message
        });
    }
}
