@extends('website.layouts')

@section('content')
<!-- Main Dashboard Section -->
<div class="bg-gradient-to-br from-amber-200 via-orange-100 to-red-100 py-16">
    <div class="container mx-auto px-4">
        <!-- Flex Container for Sidebar and Form -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar - 1/4 width -->
            <div class="lg:w-1/4">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">
                        Quick Document Creation
                    </h2>
                    <p class="text-gray-600 text-sm">
                        Create professional documents in minutes
                    </p>
                </div>

            <!-- Single Documents - Compact -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                        </svg>
                        Single Documents
                    </h3>
                </div>
                <div class="p-4">
                    <div class="space-y-3">
                        <a href="{{ route('documents.invoice.create') }}" class="group flex items-center p-3 bg-gray-100/80 rounded-lg hover:bg-gray-200/80 transition-all duration-300">
                            <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">Create Invoice</span>
                        </a>
                        <a href="{{ route('documents.quotation.create') }}" class="group flex items-center p-3 bg-gray-100/80 rounded-lg hover:bg-gray-200/80 transition-all duration-300">
                            <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9,7V15A1,1 0 0,0 10,16H14A1,1 0 0,0 15,15V7H9M10,8H14V15H10V8Z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">Create Quotation</span>
                        </a>
                        <a href="{{ route('documents.estimate.create') }}" class="group flex items-center p-3 bg-gray-100/80 rounded-lg hover:bg-gray-200/80 transition-all duration-300">
                            <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M7,2H17A2,2 0 0,1 19,4V20A2,2 0 0,1 17,22H7A2,2 0 0,1 5,20V4A2,2 0 0,1 7,2M7,4V8H17V4H7M7,10V12H9V10H7M11,10V12H13V10H11M15,10V12H17V10H15M7,14V16H9V14H7M11,14V16H13V14H11M15,14V16H17V14H15M7,18V20H9V18H7M11,18V20H13V18H11M15,18V20H17V18H15Z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">Create Estimate</span>
                        </a>
                        <a href="{{ route('documents.po.create') }}" class="group flex items-center p-3 bg-gray-100/80 rounded-lg hover:bg-gray-200/80 transition-all duration-300">
                            <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5H5.21L4.27,2H1M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18Z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">Create PO</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Batch Documents - Compact -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M19,5V19H5V5H19Z"/>
                        </svg>
                        Batch Generation
                    </h3>
                </div>
                <div class="p-4">
                    <div class="space-y-3">
                        <a href="{{ route('documents.invoice.batch') }}" class="group flex items-center p-3 bg-gray-100/80 rounded-lg hover:bg-gray-200/80 transition-all duration-300">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">Batch Invoices</span>
                        </a>
                        <a href="{{ route('documents.quotation.batch') }}" class="group flex items-center p-3 bg-gray-100/80 rounded-lg hover:bg-gray-200/80 transition-all duration-300">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9,7V15A1,1 0 0,0 10,16H14A1,1 0 0,0 15,15V7H9M10,8H14V15H10V8Z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">Batch Quotations</span>
                        </a>
                        <a href="{{ route('documents.estimate.batch') }}" class="group flex items-center p-3 bg-gray-100/80 rounded-lg hover:bg-gray-200/80 transition-all duration-300">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M7,2H17A2,2 0 0,1 19,4V20A2,2 0 0,1 17,22H7A2,2 0 0,1 5,20V4A2,2 0 0,1 7,2M7,4V8H17V4H7M7,10V12H9V10H7M11,10V12H13V10H11M15,10V12H17V10H15M7,14V16H9V14H7M11,14V16H13V14H11M15,14V16H17V14H15M7,18V20H9V18H7M11,18V20H13V18H11M15,18V20H17V18H15Z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">Batch Estimates</span>
                        </a>
                        <a href="{{ route('documents.po.batch') }}" class="group flex items-center p-3 bg-gray-100/80 rounded-lg hover:bg-gray-200/80 transition-all duration-300">
                            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-pink-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5H5.21L4.27,2H1M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18Z"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">Batch POs</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- ERP Integrations - Compact -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M12,6A6,6 0 0,0 6,12A6,6 0 0,0 12,18A6,6 0 0,0 18,12A6,6 0 0,0 12,6M12,8A4,4 0 0,1 16,12A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8Z"/>
                        </svg>
                        ERP Integrations
                    </h3>
                </div>
                <div class="p-4">
                    <div class="space-y-3">
                        <a href="{{ route('integrations.quickbooks.setup') }}" class="group flex items-center p-3 bg-gray-100/80 rounded-lg hover:bg-gray-200/80 transition-all duration-300">
                            <div class="w-10 h-10 bg-white/80 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <img src="{{ asset('public/backend/images/quickbooks.svg') }}" alt="QuickBooks" class="w-6 h-6 object-contain">
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">QuickBooks</span>
                        </a>
                        <a href="{{ route('integrations.sap.setup') }}" class="group flex items-center p-3 bg-gray-100/80 rounded-lg hover:bg-gray-200/80 transition-all duration-300">
                            <div class="w-10 h-10 bg-white/80 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <img src="{{ asset('public/backend/images/sap.svg') }}" alt="SAP" class="w-6 h-6 object-contain">
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">SAP B1</span>
                        </a>
                        <a href="{{ route('integrations.xero.setup') }}" class="group flex items-center p-3 bg-gray-100/80 rounded-lg hover:bg-gray-200/80 transition-all duration-300">
                            <div class="w-10 h-10 bg-white/80 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <img src="{{ asset('public/backend/images/xero.svg') }}" alt="Xero" class="w-6 h-6 object-contain">
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">Xero</span>
                        </a>
                        <a href="{{ route('integrations.dynamics.setup') }}" class="group flex items-center p-3 bg-gray-100/80 rounded-lg hover:bg-gray-200/80 transition-all duration-300">
                            <div class="w-10 h-10 bg-white/80 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                <img src="{{ asset('public/backend/images/business-central.svg') }}" alt="Business Central" class="w-6 h-6 object-contain">
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">Business Central</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quotation Form Section - 3/4 width -->
        <div class="lg:w-3/4">
            <!-- Action Buttons Row -->
            <div class="bg-white rounded-2xl shadow-2xl p-6 mb-8 border border-gray-200">
                                    <div class="flex flex-wrap gap-4 justify-center">
                        <button type="button" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-400 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-500 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1" onclick="downloadPDF()">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8.5 7.5c0 .83-.67 1.5-1.5 1.5H9v2H7.5V7H10c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V7H15c.83 0 1.5.67 1.5 1.5v3zm4-3H19v1h1.5V11H19v2h-1.5V7h3v1.5zM9 9.5h1v-1H9v1zM4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm10 5.5h1v-3h-1v3z"/>
                            </svg>
                            PDF
                        </button>
                        <button type="button" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-400 to-amber-500 text-white font-semibold rounded-xl hover:from-orange-500 hover:to-amber-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1" onclick="printDocument()">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
                            </svg>
                            Print
                        </button>
                        <button type="button" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-orange-400 text-white font-semibold rounded-xl hover:from-yellow-500 hover:to-orange-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1" onclick="downloadDocument()">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                            </svg>
                            Download
                        </button>
                        <button type="button" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-300 to-amber-400 text-white font-semibold rounded-xl hover:from-orange-400 hover:to-amber-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1" onclick="emailDocument()">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            Email
                        </button>
                        <button type="button" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-300 to-orange-400 text-white font-semibold rounded-xl hover:from-amber-400 hover:to-orange-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1" onclick="saveDocument()">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17,3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V7L17,3M19,19H5V5H16.17L19,7.83V19M12,12C10.34,12 9,13.34 9,15C9,16.66 10.34,18 12,18C13.66,18 15,16.66 15,15C15,13.34 13.66,12 12,12M6,6H15V10H6V6Z"/>
                            </svg>
                            Save (Login Required)
                        </button>
                        <button type="button" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-300 to-red-400 text-white font-semibold rounded-xl hover:from-orange-400 hover:to-red-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1" onclick="resetForm()">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12,18A6,6 0 0,1 6,12A6,6 0 0,1 12,6A6,6 0 0,1 18,12A6,6 0 0,1 12,18M20,8.69V4H15.31L12,0.69L8.69,4H4V8.69L0.69,12L4,15.31V20H8.69L12,23.31L15.31,20H20V15.31L23.31,12L20,8.69Z"/>
                            </svg>
                            Reset
                        </button>
                    </div>
            </div>

            <!-- Quotation Form -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200">
                <div class="p-8">
                    <form id="comprehensiveQuotationForm" method="POST" action="{{ route('website.quotation.store') }}" class="space-y-8">
                        @csrf
                        
                        <!-- Header Section -->
                        <div class="grid lg:grid-cols-3 gap-8">
                            <div class="lg:col-span-1">
                                <div class="text-center">
                                    <div class="w-20 h-20 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-bold text-gray-800">Document Management System</h4>
                                </div>
                            </div>
                            <div class="lg:col-span-2">
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Quotation Title *</label>
                                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="title" value="Quotation" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Quotation Number</label>
                                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" name="quotation_number" value="QT-{{ date('Y') }}-{{ str_pad(1, 4, '0', STR_PAD_LEFT) }}" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">PO/SO Number</label>
                                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="po_so_number" placeholder="Purchase/Sales Order Number">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Template</label>
                                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="template">
                                            <option value="default">Default Template</option>
                                            <option value="modern">Modern Template</option>
                                            <option value="classic">Classic Template</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <!-- Customer & Date Information -->
                        <div class="grid lg:grid-cols-2 gap-8">
                            <div>
                                <h5 class="text-lg font-bold text-amber-600 mb-6 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"/>
                                    </svg>
                                    Customer Information
                                </h5>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="customer_name" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                                        <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="customer_email" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="customer_phone">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Company Name</label>
                                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="company_name">
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Address</label>
                                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="customer_address" rows="3" placeholder="Enter complete address"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h5 class="text-lg font-bold text-amber-600 mb-6 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"/>
                                    </svg>
                                    Quotation Details
                                </h5>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Quotation Date *</label>
                                        <input type="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="quotation_date" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Valid Until *</label>
                                        <input type="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="expired_date" value="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Project Description</label>
                                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="project_description" rows="3" placeholder="Describe your project requirements"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Items Section -->
                        <div>
                            <h5 class="text-lg font-bold text-amber-600 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9,7V15A1,1 0 0,0 10,16H14A1,1 0 0,0 15,15V7H9M10,8H14V15H10V8Z"/>
                                </svg>
                                Items & Services
                            </h5>
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse border border-gray-300 rounded-lg overflow-hidden" id="quotation-items-table">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700" style="width: 35%;">Item/Service Name *</th>
                                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700" style="width: 15%;">Description</th>
                                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700" style="width: 10%;">Quantity *</th>
                                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700" style="width: 15%;">Unit Price *</th>
                                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700" style="width: 10%;">Tax</th>
                                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700" style="width: 10%;">Total</th>
                                            <th class="border border-gray-300 px-4 py-3 text-center font-semibold text-gray-700" style="width: 5%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="item-row bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                            <td class="border border-gray-300 px-4 py-3">
                                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent item-name" name="items[0][name]" required>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3">
                                                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent item-description" name="items[0][description]" rows="2" placeholder="Description"></textarea>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3">
                                                <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent quantity-input" name="items[0][quantity]" value="1" min="0.1" step="0.1" required>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3">
                                                <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent price-input" name="items[0][unit_price]" step="0.01" min="0" required>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3">
                                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent tax-select" name="items[0][tax]">
                                                    <option value="0">No Tax</option>
                                                    <option value="10">10% Tax</option>
                                                    <option value="15">15% Tax</option>
                                                    <option value="20">20% Tax</option>
                                                </select>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3">
                                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 item-total" readonly>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3 text-center">
                                                <button type="button" class="w-8 h-8 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors duration-200 remove-item hidden">
                                                    <svg class="w-4 h-4 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="mt-4 inline-flex items-center px-6 py-3 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition-all duration-300 shadow-lg hover:shadow-xl" id="addItem">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z"/>
                                </svg>
                                Add Another Item
                            </button>
                        </div>

                        <!-- Summary Section -->
                        <div class="grid lg:grid-cols-3 gap-8">
                            <div class="lg:col-span-2">
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes</label>
                                        <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="notes" rows="4" placeholder="Additional notes or terms"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Footer</label>
                                        <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="footer" rows="4" placeholder="Footer text or terms"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="lg:col-span-1">
                                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                    <h6 class="text-lg font-bold text-gray-800 mb-4">Summary</h6>
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Subtotal:</span>
                                            <span class="font-semibold" id="subtotal">$0.00</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Tax:</span>
                                            <span class="font-semibold" id="tax-total">$0.00</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Discount:</span>
                                            <span class="font-semibold" id="discount-total">$0.00</span>
                                        </div>
                                        <hr class="border-gray-300">
                                        <div class="flex justify-between text-lg">
                                            <span class="font-bold text-gray-800">Total:</span>
                                            <span class="font-bold text-amber-600" id="grandTotal">$0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        
                        <!-- Export Action Buttons (Hidden initially, shown after generation) -->
                        <div id="exportButtons" class="text-center pt-6 hidden">
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4">Export Options</h4>
                                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                    <button type="button" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1" onclick="downloadPDF()">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8.5 7.5c0 .83-.67 1.5-1.5 1.5H9v2H7.5V7H10c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V7H15c.83 0 1.5.67 1.5 1.5v3zm4-3H19v1h1.5V11H19v2h-1.5V7h3v1.5zM9 9.5h1v-1H9v1zM4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm10 5.5h1v-3h-1v3z"/>
                                        </svg>
                                        PDF
                                    </button>
                                    <button type="button" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1" onclick="printDocument()">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
                                        </svg>
                                        Print
                                    </button>
                                    <button type="button" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-xl hover:from-amber-600 hover:to-amber-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1" onclick="downloadDocument()">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                                        </svg>
                                        Download
                                    </button>
                                    <button type="button" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1" onclick="emailDocument()">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                        </svg>
                                        Email
                                    </button>
                                    <button type="button" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1" onclick="saveDocument()">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17,3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V7L17,3M19,19H5V5H16.17L19,7.83V19M12,12C10.34,12 9,13.34 9,15C9,16.66 10.34,18 12,18C13.66,18 15,16.66 15,15C15,13.34 13.66,12 12,12M6,6H15V10H6V6Z"/>
                                        </svg>
                                        Save (Login Required)
                                    </button>
                                    <button type="button" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-400 to-red-500 text-white font-semibold rounded-xl hover:from-red-500 hover:to-red-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1" onclick="resetForm()">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12,18A6,6 0 0,1 6,12A6,6 0 0,1 12,6A6,6 0 0,1 18,12A6,6 0 0,1 12,18M20,8.69V4H15.31L12,0.69L8.69,4H4V8.69L0.69,12L4,15.31V20H8.69L12,23.31L15.31,20H20V15.31L23.31,12L20,8.69Z"/>
                                        </svg>
                                        Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
/* Custom animations and transitions */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

/* Custom hover effects */
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Form focus states */
.form-focus-ring:focus {
    outline: none;
    ring: 2px;
    ring-color: #5034FC;
    ring-offset: 2px;
}

/* Loading animation */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>

<script>
// PDF Export using html2pdf.js
function downloadPDF() {
    const element = document.getElementById('comprehensiveQuotationForm');
    if (!element) {
        Swal.fire('Error', 'Form not found for PDF export.', 'error');
        return;
    }
    html2pdf()
        .set({
            margin: 0.5,
            filename: 'quotation-' + new Date().getTime() + '.pdf',
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        })
        .from(element)
        .save();
}

// Print the form area
function printDocument() {
    const printContents = document.getElementById('comprehensiveQuotationForm').outerHTML;
    const printWindow = window.open('', '', 'height=800,width=900');
    printWindow.document.write('<html><head><title>Print Quotation</title>');
    printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">');
    printWindow.document.write('</head><body >');
    printWindow.document.write(printContents);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 500);
}

// Download as JSON or CSV
function downloadDocument() {
    Swal.fire({
        title: 'Download Format',
        html: `<div class='flex flex-col gap-2'>
            <button onclick='downloadAsJSON()' class='px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600'>JSON</button>
            <button onclick='downloadAsCSV()' class='px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600'>CSV</button>
        </div>`,
        showConfirmButton: false,
        showCloseButton: true
    });
}

function downloadAsJSON() {
    const data = collectFormData();
    const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'quotation-data.json';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    Swal.close();
}

function downloadAsCSV() {
    const data = collectFormData();
    let csv = 'Field,Value\n';
    Object.keys(data).forEach(key => {
        if (Array.isArray(data[key])) {
            data[key].forEach((item, idx) => {
                Object.keys(item).forEach(subkey => {
                    csv += `${key}[${idx}].${subkey},"${item[subkey]}"\n`;
                });
            });
        } else {
            csv += `${key},"${data[key]}"\n`;
        }
    });
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'quotation-data.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    Swal.close();
}

// Email modal and simulate sending
function emailDocument() {
    Swal.fire({
        title: 'Send Quotation',
        html: `<input id='emailTo' type='email' class='swal2-input' placeholder='Recipient Email'>`,
        showCancelButton: true,
        confirmButtonText: 'Send',
        preConfirm: () => {
            const email = document.getElementById('emailTo').value;
            if (!email || !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)) {
                Swal.showValidationMessage('Please enter a valid email address');
                return false;
            }
            return email;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Sending...',
                html: 'Simulating email send...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
            setTimeout(() => {
                Swal.fire('Sent!', 'Quotation sent to ' + result.value, 'success');
            }, 1500);
        }
    });
}

// Save: Prompt login
function saveDocument() {
    Swal.fire({
        icon: 'info',
        title: 'Login Required',
        text: 'You need to be logged in to save documents. Please login to continue.',
        confirmButtonText: 'Login',
        showCancelButton: true,
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/login';
        }
    });
}

// Reset: Clear all form fields
function resetForm() {
    Swal.fire({
        icon: 'warning',
        title: 'Reset Form',
        text: 'Are you sure you want to reset the entire form? All data will be lost.',
        confirmButtonText: 'Yes, Reset',
        showCancelButton: true,
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('comprehensiveQuotationForm').reset();
            // Optionally reset dynamic items table if needed
            Swal.fire('Reset!', 'The form has been reset.', 'success');
        }
    });
}

function collectFormData() {
    const form = document.getElementById('comprehensiveQuotationForm');
    const formData = new FormData(form);
    const data = {};
    
    // Collect basic form data
    for (let [key, value] of formData.entries()) {
        if (key.includes('[')) {
            // Handle array data (items)
            const match = key.match(/(\w+)\[(\d+)\]\[(\w+)\]/);
            if (match) {
                const [, arrayName, index, field] = match;
                if (!data[arrayName]) data[arrayName] = [];
                if (!data[arrayName][index]) data[arrayName][index] = {};
                data[arrayName][index][field] = value;
            }
        } else {
            data[key] = value;
        }
    }
    
    // Add calculated totals
    data.total = document.getElementById('grandTotal').textContent;
    data.subtotal = document.getElementById('subtotal').textContent;
    data.tax_total = document.getElementById('taxTotal').textContent;
    
    return data;
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
@endsection