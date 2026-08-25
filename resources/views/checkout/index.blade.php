@extends('layouts.app')

@section('title', 'Checkout | Sondhi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center max-w-2xl mx-auto mb-8">
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-gray-900">Secure Order Checkout</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Complete your address & payment details to place your artisan order.</p>
    </div>

    <!-- Multi-Step Progress Bar Pipeline -->
    <div class="mb-10 max-w-3xl mx-auto px-4">
        <div class="flex items-center justify-between relative">
            <!-- Step 1: Cart (Passed) -->
            <div class="flex flex-col items-center space-y-1.5 z-10">
                <div class="w-10 h-10 rounded-full bg-emerald-600 text-white font-bold text-sm flex items-center justify-center shadow-md">
                    <i class="fa-solid fa-check"></i>
                </div>
                <span class="text-[11px] font-bold text-gray-800">1. Cart Review</span>
            </div>

            <div id="progress-line-1" class="h-1 flex-1 bg-brand-600 mx-2 rounded transition-all"></div>

            <!-- Step 2: Address Selection & Confirmation -->
            <div class="flex flex-col items-center space-y-1.5 z-10">
                <div id="step-badge-address" class="w-10 h-10 rounded-full bg-brand-600 text-white font-bold text-sm flex items-center justify-center shadow-md ring-4 ring-brand-100 transition-all">
                    2
                </div>
                <span id="step-text-address" class="text-[11px] font-bold text-brand-600 transition-all">2. Address Selection</span>
            </div>

            <div id="progress-line-2" class="h-1 flex-1 bg-gray-200 mx-2 rounded transition-all"></div>

            <!-- Step 3: Payment Section -->
            <div class="flex flex-col items-center space-y-1.5 z-10">
                <div id="step-badge-payment" class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 font-bold text-sm flex items-center justify-center transition-all">
                    3
                </div>
                <span id="step-text-payment" class="text-[11px] font-semibold text-gray-400 transition-all">3. Payment Section</span>
            </div>

            <div id="progress-line-3" class="h-1 flex-1 bg-gray-200 mx-2 rounded transition-all"></div>

            <!-- Step 4: Order Tracking -->
            <div class="flex flex-col items-center space-y-1.5 z-10">
                <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-400 font-bold text-sm flex items-center justify-center">
                    4
                </div>
                <span class="text-[11px] font-semibold text-gray-400">4. Order Tracking</span>
            </div>
        </div>
    </div>

    <!-- Main Checkout Form -->
    <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Main Content Area (Step 1 & Step 2 Containers) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- STEP 1: ADDRESS SELECTION & CONFIRMATION CONTAINER -->
                <div id="checkout-step-address" class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100 space-y-6">
                    <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                        <h3 class="font-serif text-xl font-bold text-gray-900 flex items-center">
                            <span class="w-8 h-8 rounded-full bg-brand-600 text-white text-xs flex items-center justify-center font-bold mr-3">1</span>
                            Select & Confirm Delivery Address
                        </h3>
                        <span class="text-xs font-bold text-brand-600 bg-brand-50 px-3 py-1 rounded-full">Step 1 of 2</span>
                    </div>

                    @if($addresses->count() > 0)
                        <div class="space-y-3">
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-500">Choose from Saved Addresses:</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($addresses as $addr)
                                    <label class="p-4 rounded-2xl border cursor-pointer hover:border-brand-500 transition-all flex items-start space-x-3 bg-gray-50 has-[:checked]:bg-brand-50/50 has-[:checked]:border-brand-600 has-[:checked]:ring-2 has-[:checked]:ring-brand-500">
                                        <input type="radio" name="address_id" value="{{ $addr->id }}" {{ $loop->first ? 'checked' : '' }} 
                                               onchange="toggleNewAddressFields(false)" class="mt-1 text-brand-600 focus:ring-brand-500">
                                        <div class="text-xs space-y-1">
                                            <p class="font-bold text-gray-900">{{ $addr->recipient_name }}</p>
                                            <p class="text-gray-500"><i class="fa-solid fa-phone text-gray-400 mr-1"></i> {{ $addr->phone }}</p>
                                            <p class="text-gray-700 leading-relaxed">{{ $addr->address_line1 }}, {{ $addr->city }}, {{ $addr->state }} - {{ $addr->postal_code }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-2 flex items-center space-x-2">
                            <label class="text-xs font-bold text-gray-700 cursor-pointer flex items-center">
                                <input type="radio" name="address_id" value="" id="radio-new-address" onchange="toggleNewAddressFields(true)" class="mr-2 text-brand-600 focus:ring-brand-500">
                                Enter a New Delivery Address
                            </label>
                        </div>
                    @endif

                    <!-- New Address Input Fields -->
                    <div id="new-address-fields" class="{{ $addresses->count() > 0 ? 'hidden' : '' }} pt-4 border-t border-gray-100 space-y-4">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500">New Address Details:</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Recipient Name *</label>
                                <input type="text" id="input_recipient_name" name="recipient_name" placeholder="Full Name" value="{{ old('recipient_name') }}" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-brand-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Phone Number *</label>
                                <input type="text" id="input_phone" name="phone" placeholder="Phone Number" value="{{ old('phone') }}" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-brand-500">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Address Line 1 *</label>
                                <input type="text" id="input_address_line1" name="address_line1" placeholder="Flat, House no., Building, Street" value="{{ old('address_line1') }}" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-brand-500">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Landmark (Optional)</label>
                                <input type="text" name="address_line2" placeholder="Near hospital, park, etc." value="{{ old('address_line2') }}" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-brand-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">City *</label>
                                <input type="text" id="input_city" name="city" placeholder="City" value="{{ old('city') }}" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-brand-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">State *</label>
                                <input type="text" id="input_state" name="state" placeholder="State" value="{{ old('state') }}" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-brand-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">PIN / Postal Code *</label>
                                <input type="text" id="input_postal_code" name="postal_code" placeholder="Postal Code" value="{{ old('postal_code') }}" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-brand-500">
                            </div>
                            <div class="flex items-center pt-5">
                                <label class="text-xs text-gray-600 font-medium flex items-center cursor-pointer">
                                    <input type="checkbox" name="save_address" value="1" class="rounded text-brand-600 mr-2 focus:ring-brand-500"> Save address for future orders
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Step 1 Next Action -->
                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <button type="button" onclick="goToStepPayment()" class="px-8 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-brand-500/25 transition-all flex items-center space-x-2">
                            <span>Confirm Address & Proceed to Payment</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>


                <!-- STEP 2: PAYMENT SECTION CONTAINER (Hidden initially) -->
                <div id="checkout-step-payment" class="hidden space-y-6">
                    
                    <!-- Confirmed Address Summary Card -->
                    <div class="bg-amber-50/60 p-6 rounded-3xl border border-amber-200/80 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="space-y-1 text-xs">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-800 bg-amber-100 px-2.5 py-0.5 rounded-full">Confirmed Delivery Address</span>
                            <p id="summary-address-name" class="font-bold text-gray-900 text-sm mt-1"></p>
                            <p id="summary-address-details" class="text-gray-700"></p>
                        </div>
                        <button type="button" onclick="goToStepAddress()" class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 font-bold text-xs rounded-xl border border-gray-200 transition-colors shrink-0">
                            <i class="fa-solid fa-pen mr-1"></i> Edit Address
                        </button>
                    </div>

                    <!-- Payment Choices -->
                    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100 space-y-6">
                        <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                            <h3 class="font-serif text-xl font-bold text-gray-900 flex items-center">
                                <span class="w-8 h-8 rounded-full bg-brand-600 text-white text-xs flex items-center justify-center font-bold mr-3">2</span>
                                Select Payment Method
                            </h3>
                            <span class="text-xs font-bold text-brand-600 bg-brand-50 px-3 py-1 rounded-full">Step 2 of 2</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Online Payment / Razorpay -->
                            <label class="p-5 rounded-2xl border cursor-pointer hover:border-brand-500 transition-all flex items-start space-x-3 bg-gray-50 has-[:checked]:bg-brand-50/50 has-[:checked]:border-brand-600 has-[:checked]:ring-2 has-[:checked]:ring-brand-500">
                                <input type="radio" name="payment_method" value="Online Payment" checked class="mt-1 text-brand-600 focus:ring-brand-500">
                                <div>
                                    <p class="font-bold text-sm text-gray-900"><i class="fa-solid fa-credit-card text-brand-600 mr-1.5"></i> Online Payment (Razorpay)</p>
                                    <p class="text-[11px] text-gray-500 mt-1">UPI, Google Pay, PhonePe, Credit/Debit Card & NetBanking.</p>
                                    <span class="inline-block mt-2 text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">Instant Processing</span>
                                </div>
                            </label>

                            <!-- Cash on Delivery -->
                            <label class="p-5 rounded-2xl border cursor-pointer hover:border-brand-500 transition-all flex items-start space-x-3 bg-gray-50 has-[:checked]:bg-brand-50/50 has-[:checked]:border-brand-600 has-[:checked]:ring-2 has-[:checked]:ring-brand-500">
                                <input type="radio" name="payment_method" value="COD" class="mt-1 text-brand-600 focus:ring-brand-500">
                                <div>
                                    <p class="font-bold text-sm text-gray-900"><i class="fa-solid fa-money-bill-wave text-emerald-600 mr-1.5"></i> Cash on Delivery (COD)</p>
                                    <p class="text-[11px] text-gray-500 mt-1">Pay with cash upon package arrival at your doorstep.</p>
                                    <span class="inline-block mt-2 text-[10px] font-bold text-gray-600 bg-gray-200 px-2 py-0.5 rounded">Standard Delivery</span>
                                </div>
                            </label>
                        </div>

                        <!-- Special Instructions / Notes -->
                        <div class="pt-4 border-t border-gray-100">
                            <label for="notes" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">Order Notes & Gift Instructions (Optional)</label>
                            <textarea name="notes" id="notes" rows="2" placeholder="e.g. Include custom birthday gift message, deliver before 5 PM..." 
                                      class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-brand-500"></textarea>
                        </div>

                        <!-- Final Action Buttons -->
                        <div class="pt-4 border-t border-gray-100 flex justify-between items-center">
                            <button type="button" onclick="goToStepAddress()" class="text-xs font-bold text-gray-500 hover:text-gray-800">
                                &larr; Back to Address
                            </button>

                            <button type="submit" class="px-8 py-4 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-xl shadow-xl shadow-brand-500/30 transition-all flex items-center space-x-2">
                                <span>Confirm & Pay Now</span>
                                <i class="fa-solid fa-lock text-xs ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Order Items & Price Summary -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-4 sticky top-6">
                    <h3 class="font-serif text-lg font-bold text-gray-900 pb-3 border-b border-gray-100">Order Items ({{ count($cart) }})</h3>

                    <div class="divide-y divide-gray-100 max-h-64 overflow-y-auto pr-1">
                        @foreach($cart as $item)
                            <div class="py-3 flex items-center justify-between text-xs">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $item['image_path'] }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover rounded-xl bg-gray-100 shrink-0">
                                    <div>
                                        <p class="font-bold text-gray-900 line-clamp-1">{{ $item['name'] }}</p>
                                        <p class="text-gray-500">Qty: {{ $item['quantity'] }} &bull; ₹{{ number_format($item['price'], 2) }}</p>
                                    </div>
                                </div>
                                <span class="font-bold text-gray-900 shrink-0">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-3 border-t border-gray-100 space-y-2 text-xs text-gray-600">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-bold text-gray-900">₹{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span class="font-bold text-emerald-700">{{ $shippingFee == 0 ? 'FREE' : '₹' . number_format($shippingFee, 2) }}</span>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-gray-100 flex justify-between items-baseline">
                        <span class="font-bold text-sm text-gray-900">Total Amount</span>
                        <span class="font-serif text-2xl font-bold text-brand-600">₹{{ number_format($totalAmount, 2) }}</span>
                    </div>

                    <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-200 text-[11px] text-emerald-800 flex items-center space-x-2">
                        <i class="fa-solid fa-shield-halved text-emerald-600 text-sm"></i>
                        <span>Protected by 256-bit SSL encryption.</span>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<!-- Interactive Step Navigation Script -->
<script>
    function toggleNewAddressFields(show) {
        const fields = document.getElementById('new-address-fields');
        if (show) {
            fields.classList.remove('hidden');
        } else {
            fields.classList.add('hidden');
        }
    }

    function goToStepPayment() {
        const addressRadioSelected = document.querySelector('input[name="address_id"]:checked');
        const isNewAddressRadio = document.getElementById('radio-new-address');

        let recipientName = '', addressDetails = '';

        if (addressRadioSelected && addressRadioSelected.value !== '') {
            // Selected a saved address
            const parentLabel = addressRadioSelected.closest('label');
            recipientName = parentLabel.querySelector('p.font-bold').innerText;
            addressDetails = parentLabel.querySelector('p.text-gray-700').innerText;
        } else {
            // Validate new address input fields
            const nameVal = document.getElementById('input_recipient_name').value.trim();
            const phoneVal = document.getElementById('input_phone').value.trim();
            const addrVal = document.getElementById('input_address_line1').value.trim();
            const cityVal = document.getElementById('input_city').value.trim();
            const stateVal = document.getElementById('input_state').value.trim();
            const zipVal = document.getElementById('input_postal_code').value.trim();

            if (!nameVal || !phoneVal || !addrVal || !cityVal || !stateVal || !zipVal) {
                alert('Please fill out all required delivery address fields before proceeding.');
                return;
            }

            recipientName = nameVal + ' (' + phoneVal + ')';
            addressDetails = addrVal + ', ' + cityVal + ', ' + stateVal + ' - ' + zipVal;
        }

        // Set confirmed address summary
        document.getElementById('summary-address-name').innerText = recipientName;
        document.getElementById('summary-address-details').innerText = addressDetails;

        // Hide Step 1, Show Step 2
        document.getElementById('checkout-step-address').classList.add('hidden');
        document.getElementById('checkout-step-payment').classList.remove('hidden');

        // Update progress bar UI
        document.getElementById('progress-line-2').classList.remove('bg-gray-200');
        document.getElementById('progress-line-2').classList.add('bg-brand-600');

        const stepBadgePayment = document.getElementById('step-badge-payment');
        stepBadgePayment.classList.remove('bg-gray-200', 'text-gray-500');
        stepBadgePayment.classList.add('bg-brand-600', 'text-white', 'ring-4', 'ring-brand-100');

        const stepTextPayment = document.getElementById('step-text-payment');
        stepTextPayment.classList.remove('text-gray-400', 'font-semibold');
        stepTextPayment.classList.add('text-brand-600', 'font-bold');

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function goToStepAddress() {
        document.getElementById('checkout-step-payment').classList.add('hidden');
        document.getElementById('checkout-step-address').classList.remove('hidden');

        // Reset progress bar line 2 UI
        document.getElementById('progress-line-2').classList.remove('bg-brand-600');
        document.getElementById('progress-line-2').classList.add('bg-gray-200');

        const stepBadgePayment = document.getElementById('step-badge-payment');
        stepBadgePayment.classList.remove('bg-brand-600', 'text-white', 'ring-4', 'ring-brand-100');
        stepBadgePayment.classList.add('bg-gray-200', 'text-gray-500');

        const stepTextPayment = document.getElementById('step-text-payment');
        stepTextPayment.classList.remove('text-brand-600', 'font-bold');
        stepTextPayment.classList.add('text-gray-400', 'font-semibold');

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endsection
