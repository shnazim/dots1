@extends('website.layouts')

@section('content')
<!-- Header Section -->
<div class="bg-gradient-to-br from-amber-50 via-orange-50 to-red-50 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Frequently Asked Questions</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Find answers to common questions about our document management system, features, and services.
            </p>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- General Questions -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">General Questions</h2>
                
                <div class="space-y-6">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-gray-800">What is this document management system?</h3>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600">Our document management system is a comprehensive platform that helps businesses create, manage, and track various types of documents including invoices, quotations, estimates, and purchase orders. It includes features like batch processing, ERP integrations, and automated workflows.</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-gray-800">How do I get started?</h3>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600">Getting started is easy! Simply sign up for an account, choose a plan that fits your needs, and you can start creating documents immediately. We offer a free trial period so you can explore all features before committing.</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-gray-800">Is there a free trial available?</h3>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600">Yes! We offer free trials on most of our plans. The trial duration varies by plan - Starter plans typically offer 7 days, Standard plans offer 14 days, and Professional plans offer 30 days. You can upgrade or cancel at any time during the trial period.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features & Functionality -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Features & Functionality</h2>
                
                <div class="space-y-6">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-gray-800">What types of documents can I create?</h3>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600">Our system supports multiple document types including:</p>
                            <ul class="list-disc list-inside mt-2 text-gray-600 space-y-1">
                                <li>Invoices with automatic calculations and tax handling</li>
                                <li>Quotations with validity periods and terms</li>
                                <li>Estimates with project breakdowns</li>
                                <li>Purchase Orders with approval workflows</li>
                                <li>Recurring invoices for subscription billing</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-gray-800">Can I customize document templates?</h3>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600">Absolutely! We provide a drag-and-drop template builder that allows you to create custom document templates. You can add your company logo, customize colors, fonts, and layout to match your brand identity. Professional and higher plans include unlimited template customization.</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-gray-800">How does batch processing work?</h3>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600">Batch processing allows you to create multiple documents at once. You can upload a CSV or Excel file with your data, and the system will automatically generate all documents using your chosen template. This is perfect for businesses that need to process large volumes of documents regularly.</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-gray-800">Which ERP systems do you integrate with?</h3>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600">We currently integrate with the following ERP systems:</p>
                            <ul class="list-disc list-inside mt-2 text-gray-600 space-y-1">
                                <li>QuickBooks Online and Desktop</li>
                                <li>SAP Business One</li>
                                <li>Xero</li>
                                <li>Microsoft Dynamics Business Central</li>
                                <li>Oracle NetSuite</li>
                            </ul>
                            <p class="text-gray-600 mt-2">More integrations are being added regularly based on customer demand.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing & Billing -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Pricing & Billing</h2>
                
                <div class="space-y-6">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-gray-800">What payment methods do you accept?</h3>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600">We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers for annual and lifetime plans. All payments are processed securely through our trusted payment partners.</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-gray-800">Can I change my plan later?</h3>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600">Yes, you can upgrade or downgrade your plan at any time. When you upgrade, you'll be charged the prorated difference for the remainder of your billing period. When you downgrade, the new rate will apply at your next billing cycle.</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-gray-800">Do you offer refunds?</h3>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600">We offer a 30-day money-back guarantee for all plans. If you're not satisfied with our service within the first 30 days, contact our support team and we'll process a full refund. After 30 days, refunds are handled on a case-by-case basis.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security & Data -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Security & Data</h2>
                
                <div class="space-y-6">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-gray-800">Is my data secure?</h3>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600">Absolutely! We take data security very seriously. We use enterprise-grade encryption, secure data centers, and follow industry best practices for data protection. We're also compliant with major security standards and regularly conduct security audits.</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-gray-800">Can I export my data?</h3>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600">Yes, you can export your data in various formats including PDF, Excel, and CSV. You have full control over your data and can download it at any time. We also provide data backup services to ensure your information is always safe.</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-gray-800">Do you offer data backup?</h3>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600">Yes, we automatically backup all your data multiple times per day to secure, geographically distributed data centers. This ensures that your data is protected against any potential loss and can be recovered quickly if needed.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Support -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Support & Help</h2>
                
                <div class="space-y-6">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-gray-800">What support options are available?</h3>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600">We offer multiple support channels:</p>
                            <ul class="list-disc list-inside mt-2 text-gray-600 space-y-1">
                                <li>24/7 email support for all plans</li>
                                <li>Live chat support for Standard and Professional plans</li>
                                <li>Phone support for Professional plans</li>
                                <li>Comprehensive knowledge base and video tutorials</li>
                                <li>Community forum for user discussions</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <button class="faq-toggle w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-gray-800">How quickly do you respond to support requests?</h3>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden mt-4">
                            <p class="text-gray-600">Our response times vary by plan and support type:</p>
                            <ul class="list-disc list-inside mt-2 text-gray-600 space-y-1">
                                <li>Email support: Within 24 hours (Starter), 12 hours (Standard), 4 hours (Professional)</li>
                                <li>Live chat: Immediate response during business hours</li>
                                <li>Phone support: Immediate response during business hours</li>
                                <li>Critical issues: Escalated immediately regardless of plan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Still Have Questions -->
        <div class="text-center mt-16">
            <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-2xl p-12 text-white">
                <h2 class="text-3xl font-bold mb-4">Still Have Questions?</h2>
                <p class="text-xl mb-8 opacity-90">Can't find what you're looking for? Our support team is here to help.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ url('/contact') }}" class="bg-white text-orange-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200">
                        Contact Support
                    </a>
                    <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-orange-600 transition-colors duration-200">
                        Start Free Trial
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFAQ(button) {
    const content = button.nextElementSibling;
    const icon = button.querySelector('svg');
    
    // Toggle content visibility
    content.classList.toggle('hidden');
    
    // Rotate icon
    if (content.classList.contains('hidden')) {
        icon.style.transform = 'rotate(0deg)';
    } else {
        icon.style.transform = 'rotate(180deg)';
    }
}

// Close all FAQ items when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.faq-toggle')) {
        const allContents = document.querySelectorAll('.faq-content');
        const allIcons = document.querySelectorAll('.faq-toggle svg');
        
        allContents.forEach(content => {
            content.classList.add('hidden');
        });
        
        allIcons.forEach(icon => {
            icon.style.transform = 'rotate(0deg)';
        });
    }
});
</script>
@endsection
