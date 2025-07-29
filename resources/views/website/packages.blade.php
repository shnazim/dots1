@extends('website.layouts')

@section('content')
<!-- Header Section -->
<div class="bg-gradient-to-br from-amber-50 via-orange-50 to-red-50 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Choose Your Perfect Plan</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Select the package that best fits your business needs. All plans include our core document management features with different limits and capabilities.
            </p>
        </div>
    </div>
</div>

<!-- Pricing Toggle Section -->
<div class="bg-white py-8 border-b border-gray-200">
    <div class="container mx-auto px-4">
        <div class="flex justify-center items-center space-x-8">
            <div class="flex items-center">
                <input type="radio" id="monthly-plans" name="plan_type" value="monthly" class="plan_type sr-only" checked>
                <label for="monthly-plans" class="plan_type_label cursor-pointer px-6 py-3 rounded-lg border-2 border-gray-300 text-gray-700 font-medium transition-all duration-300 hover:border-orange-500 hover:text-orange-600">
                    Monthly Plans
                </label>
            </div>
            <div class="flex items-center">
                <input type="radio" id="yearly-plans" name="plan_type" value="yearly" class="plan_type sr-only">
                <label for="yearly-plans" class="plan_type_label cursor-pointer px-6 py-3 rounded-lg border-2 border-gray-300 text-gray-700 font-medium transition-all duration-300 hover:border-orange-500 hover:text-orange-600">
                    Yearly Plans
                </label>
            </div>
            <div class="flex items-center">
                <input type="radio" id="lifetime-plans" name="plan_type" value="lifetime" class="plan_type sr-only">
                <label for="lifetime-plans" class="plan_type_label cursor-pointer px-6 py-3 rounded-lg border-2 border-gray-300 text-gray-700 font-medium transition-all duration-300 hover:border-orange-500 hover:text-orange-600">
                    Lifetime Plans
                </label>
            </div>
        </div>
    </div>
</div>

<!-- Packages Section -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-8">
            @foreach($packages as $package)
            <div class="{{ $package->package_type }}-plan package-card">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 {{ $package->is_popular == 1 ? 'ring-4 ring-orange-500' : '' }}">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-8 text-center relative">
                        @if($package->is_popular == 1)
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <span class="bg-orange-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                Most Popular
                            </span>
                        </div>
                        @endif
                        
                        <h3 class="text-2xl font-bold text-white mb-4">{{ $package->name }}</h3>
                        
                        @if($package->discount > 0)
                        <div class="mb-4">
                            <span class="text-white/80 line-through text-lg">{{ decimalPlace($package->cost, currency_symbol()) }}</span>
                            <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm font-semibold ml-2">
                                {{ $package->discount }}% OFF
                            </span>
                        </div>
                        <div class="text-4xl font-bold text-white">
                            {{ decimalPlace($package->cost - ($package->discount / 100) * $package->cost, currency_symbol()) }}
                            <span class="text-lg font-normal">/ {{ ucwords($package->package_type) }}</span>
                        </div>
                        @else
                        <div class="text-4xl font-bold text-white">
                            {{ decimalPlace($package->cost, currency_symbol()) }}
                            <span class="text-lg font-normal">/ {{ ucwords($package->package_type) }}</span>
                        </div>
                        @endif
                        
                        @if($package->trial_days > 0)
                        <div class="mt-4">
                            <span class="bg-white/20 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                {{ $package->trial_days }} Days Free Trial
                            </span>
                        </div>
                        @else
                        <div class="mt-4">
                            <span class="text-white/80 text-sm">No Trial Available</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Features -->
                    <div class="p-8">
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">{{ str_replace('-1', 'Unlimited', $package->business_limit) }} Business Account</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">{{ str_replace('-1', 'Unlimited', $package->user_limit) }} System User</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">{{ str_replace('-1', 'Unlimited', $package->invoice_limit) }} Invoice</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">{{ str_replace('-1', 'Unlimited', $package->quotation_limit) }} Quotation</span>
                            </li>
                            <li class="flex items-center">
                                @if($package->recurring_invoice == 1)
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                @else
                                <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                @endif
                                <span class="text-gray-700">Recurring Invoice</span>
                            </li>
                            <li class="flex items-center">
                                @if(isset($package->payroll_module) && $package->payroll_module == 1)
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                @else
                                <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                @endif
                                <span class="text-gray-700">HR & Payroll Module</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">{{ str_replace('-1', 'Unlimited', $package->customer_limit) }} Customer Account</span>
                            </li>
                            <li class="flex items-center">
                                @if($package->invoice_builder == 1)
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                @else
                                <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                @endif
                                <span class="text-gray-700">Invoice Template Builder</span>
                            </li>
                            <li class="flex items-center">
                                @if($package->online_invoice_payment == 1)
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                @else
                                <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                @endif
                                <span class="text-gray-700">Accept Online Payment</span>
                            </li>
                        </ul>
                        
                        <!-- CTA Button -->
                        <a href="{{ route('register') }}?package_id={{ $package->id }}" 
                           class="w-full bg-gradient-to-r from-amber-500 to-orange-600 text-white font-semibold py-3 px-6 rounded-xl hover:from-amber-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 inline-block text-center">
                            Select {{ $package->name }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="bg-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Frequently Asked Questions</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Get answers to common questions about our pricing plans and features.</p>
        </div>
        
        <div class="grid lg:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Can I change my plan later?</h3>
                    <p class="text-gray-600">Yes, you can upgrade or downgrade your plan at any time. Changes will be reflected in your next billing cycle.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Is there a free trial?</h3>
                    <p class="text-gray-600">Yes, most of our plans come with a free trial period. Check the plan details above for specific trial durations.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">What payment methods do you accept?</h3>
                    <p class="text-gray-600">We accept all major credit cards, PayPal, and bank transfers for annual and lifetime plans.</p>
                </div>
            </div>
            
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Do you offer refunds?</h3>
                    <p class="text-gray-600">We offer a 30-day money-back guarantee for all plans. If you're not satisfied, contact our support team.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Is my data secure?</h3>
                    <p class="text-gray-600">Absolutely! We use enterprise-grade security measures to protect your data and ensure compliance with industry standards.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Can I cancel anytime?</h3>
                    <p class="text-gray-600">Yes, you can cancel your subscription at any time. Your access will continue until the end of your current billing period.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.plan_type:checked + .plan_type_label {
    @apply border-orange-500 text-orange-600 bg-orange-50;
}

.package-card {
    display: block;
}

.package-card.hidden {
    display: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const planTypeInputs = document.querySelectorAll('.plan_type');
    const packageCards = document.querySelectorAll('.package-card');
    
    function showPackagesByType(type) {
        packageCards.forEach(card => {
            if (card.classList.contains(type + '-plan')) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }
    
    planTypeInputs.forEach(input => {
        input.addEventListener('change', function() {
            showPackagesByType(this.value);
        });
    });
    
    // Show monthly plans by default
    showPackagesByType('monthly');
});
</script>
@endsection 