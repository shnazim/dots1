@extends('website.layouts')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Batch Estimate Generation</h1>
                        <p class="text-gray-600 mt-2">Generate multiple estimates from Excel data</p>
                    </div>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Home
                    </a>
                </div>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7,2H17A2,2 0 0,1 19,4V20A2,2 0 0,1 17,22H7A2,2 0 0,1 5,20V4A2,2 0 0,1 7,2M7,4V8H17V4H7M7,10V12H9V10H7M11,10V12H13V10H11M15,10V12H17V10H15M7,14V16H9V14H7M11,14V16H13V14H11M15,14V16H17V14H15M7,18V20H9V18H7M11,18V20H13V18H11M15,18V20H17V18H15Z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-white">Batch Estimate Generation</h2>
                            <p class="text-amber-100 text-sm">Upload Excel file to generate multiple estimates</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Instructions -->
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-8">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center mr-4 mt-1">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M13,9H18.5L13,3.5V9M6,2H14L20,8V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V4A2,2 0 0,1 6,2M11,15V12H9V15H6L12,21L18,15H15V12H13V15H11Z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-amber-900 mb-2">How to use Batch Estimate Generation</h3>
                                <ol class="text-amber-800 space-y-1">
                                    <li class="flex items-center"><span class="w-6 h-6 bg-amber-500 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-3">1</span>Download the Excel template below</li>
                                    <li class="flex items-center"><span class="w-6 h-6 bg-amber-500 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-3">2</span>Fill in the customer and estimate data</li>
                                    <li class="flex items-center"><span class="w-6 h-6 bg-amber-500 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-3">3</span>Upload the completed Excel file</li>
                                    <li class="flex items-center"><span class="w-6 h-6 bg-amber-500 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-3">4</span>Review and generate all estimates</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Step 1: Template Download -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <span class="w-8 h-8 bg-amber-500 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-3">1</span>
                            Download Template
                        </h3>
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold text-amber-900 mb-2">Estimate Template (Excel)</h4>
                                    <p class="text-amber-700 text-sm mb-4">The template includes all required fields: Customer Name, Email, Phone, Address, Estimate Date, Valid Until, Item Description, Quantity, Unit Price, Tax Rate, and Notes.</p>
                                    <div class="text-xs text-amber-600">
                                        <p><strong>Required fields:</strong> Customer Name*, Customer Email*, Estimate Date*, Valid Until*, Item Description*, Quantity*, Unit Price*</p>
                                    </div>
                                </div>
                                <a href="{{ route('documents.template.download', 'estimate') }}" class="inline-flex items-center px-6 py-3 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition-colors shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download Template
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: File Upload -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <span class="w-8 h-8 bg-amber-500 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-3">2</span>
                            Upload Excel File
                        </h3>
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
                            <form id="batchUploadForm" enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label for="excel_file" class="block text-sm font-medium text-gray-700 mb-2">Select Excel File</label>
                                        <div class="flex items-center justify-center w-full">
                                            <label for="excel_file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-amber-300 border-dashed rounded-lg cursor-pointer bg-amber-50 hover:bg-amber-100 transition-colors">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <svg class="w-8 h-8 mb-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                    </svg>
                                                    <p class="mb-2 text-sm text-amber-600"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                    <p class="text-xs text-amber-500">Excel files only (XLSX, XLS)</p>
                                                </div>
                                                <input id="excel_file" name="excel_file" type="file" class="hidden" accept=".xlsx,.xls" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" id="uploadBtn" class="inline-flex items-center px-6 py-3 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition-colors shadow-lg hover:shadow-xl">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            Upload and Process
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Step 3: Preview Section -->
                    <div id="preview-section" class="mb-8" style="display: none;">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <span class="w-8 h-8 bg-amber-500 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-3">3</span>
                            Review Data
                        </h3>
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
                            <div class="mb-4">
                                <h4 class="font-semibold text-amber-900 mb-2">Preview of Uploaded Data</h4>
                                <p class="text-amber-700 text-sm">Review the data below before generating estimates. You can edit any fields if needed.</p>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estimate Date</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valid Until</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="preview-tbody" class="bg-white divide-y divide-gray-200">
                                        <!-- Data will be populated here -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button type="button" id="generateAllBtn" class="inline-flex items-center px-6 py-3 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition-colors shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Generate All Estimates
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Progress Section -->
                    <div id="progress-section" class="mb-8" style="display: none;">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <span class="w-8 h-8 bg-purple-500 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-3">4</span>
                            Generating Estimates
                        </h3>
                        <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
                            <div class="mb-4">
                                <h4 class="font-semibold text-purple-900 mb-2">Processing...</h4>
                                <p class="text-purple-700 text-sm">Please wait while we generate your estimates.</p>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 mb-4">
                                <div class="bg-purple-600 h-3 rounded-full transition-all duration-300" id="progress-bar" style="width: 0%"></div>
                            </div>
                            <div id="progress-text" class="text-purple-700 text-sm font-medium">Initializing...</div>
                        </div>
                    </div>

                    <!-- Step 5: Results Section -->
                    <div id="results-section" class="mb-8" style="display: none;">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <span class="w-8 h-8 bg-amber-500 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-3">5</span>
                            Generation Complete
                        </h3>
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
                            <div class="mb-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-amber-900">Successfully Generated Estimates</h4>
                                        <p class="text-amber-700 text-sm">All estimates have been created successfully!</p>
                                    </div>
                                </div>
                                <div id="results-summary" class="text-amber-800"></div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <button type="button" id="downloadAllBtn" class="inline-flex items-center px-6 py-3 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition-colors shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download All Estimates
                                </button>
                                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    Back to Home
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Error Section -->
                    <div id="error-section" class="mb-8" style="display: none;">
                        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-red-900">Error Processing File</h4>
                                    <p class="text-red-700 text-sm">There was an error processing your file. Please try again.</p>
                                </div>
                            </div>
                            <div id="error-message" class="text-red-800 bg-red-100 p-4 rounded-lg"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let processedData = [];
    let generatedEstimates = [];

    // File upload and processing
    $('#batchUploadForm').submit(function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const fileInput = $('#excel_file')[0];
        
        if (!fileInput.files[0]) {
            showError('Please select a file to upload.');
            return;
        }

        // Show progress
        $('#uploadBtn').prop('disabled', true).html('<svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Processing...');
        $('#preview-section, #progress-section, #results-section, #error-section').hide();

        $.ajax({
            url: '{{ route("documents.batch.upload", "estimate") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    processedData = response.documents || [];
                    displayPreview(processedData);
                    $('#preview-section').show();
                } else {
                    showError(response.message || 'Failed to process file. Please check the file format.');
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    window.location.href = '{{ route("login") }}';
                } else {
                    showError('Error uploading file. Please try again.');
                }
            },
            complete: function() {
                $('#uploadBtn').prop('disabled', false).html('<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>Upload and Process');
            }
        });
    });

    // Display preview of processed data
    function displayPreview(data) {
        const tbody = $('#preview-tbody');
        tbody.empty();

        data.forEach((item, index) => {
            const row = `
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-900">${item.customer_name || 'N/A'}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">${item.customer_email || 'N/A'}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">${item.customer_phone || 'N/A'}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">${item.estimate_date || 'N/A'}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">${item.valid_until || 'N/A'}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">${item.item_description || 'N/A'}</td>
                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">$${calculateItemTotal(item).toFixed(2)}</td>
                </tr>
            `;
            tbody.append(row);
        });
    }

    // Calculate item total
    function calculateItemTotal(item) {
        const quantity = parseFloat(item.quantity) || 0;
        const unitPrice = parseFloat(item.unit_price) || 0;
        const taxRate = parseFloat(item.tax_rate) || 0;
        
        const subtotal = quantity * unitPrice;
        const tax = subtotal * (taxRate / 100);
        return subtotal + tax;
    }

    // Generate all estimates
    $('#generateAllBtn').click(function() {
        if (processedData.length === 0) {
            showError('No data to process.');
            return;
        }

        $('#preview-section').hide();
        $('#progress-section').show();
        
        const totalItems = processedData.length;
        let processed = 0;

        // Process each estimate
        processedData.forEach((item, index) => {
            setTimeout(() => {
                generateEstimate(item, index, totalItems, () => {
                    processed++;
                    updateProgress(processed, totalItems);
                    
                    if (processed === totalItems) {
                        showResults();
                    }
                });
            }, index * 500); // Stagger requests
        });
    });

    // Generate individual estimate
    function generateEstimate(data, index, total, callback) {
        // Send to server for actual generation
        $.ajax({
            url: '{{ route("documents.batch.generate", "estimate") }}',
            method: 'POST',
            data: {
                documents: [data],
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success && response.documents.length > 0) {
                    generatedEstimates.push(response.documents[0]);
                }
                callback();
            },
            error: function() {
                callback(); // Continue even if one fails
            }
        });
    }

    // Update progress bar
    function updateProgress(processed, total) {
        const percentage = Math.round((processed / total) * 100);
        $('#progress-bar').css('width', percentage + '%');
        $('#progress-text').text(`Processing ${processed} of ${total} estimates...`);
    }

    // Show results
    function showResults() {
        $('#progress-section').hide();
        $('#results-section').show();
        
        const summary = `
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-white p-4 rounded-lg border border-amber-200">
                    <div class="text-2xl font-bold text-amber-600">${generatedEstimates.length}</div>
                    <div class="text-sm text-amber-700">Estimates Generated</div>
                </div>
                <div class="bg-white p-4 rounded-lg border border-amber-200">
                    <div class="text-2xl font-bold text-amber-600">$${calculateTotalAmount().toFixed(2)}</div>
                    <div class="text-sm text-amber-700">Total Amount</div>
                </div>
                <div class="bg-white p-4 rounded-lg border border-amber-200">
                    <div class="text-2xl font-bold text-amber-600">${new Date().toLocaleDateString()}</div>
                    <div class="text-sm text-amber-700">Generated Date</div>
                </div>
            </div>
        `;
        
        $('#results-summary').html(summary);
    }

    // Calculate total amount
    function calculateTotalAmount() {
        return generatedEstimates.reduce((total, estimate) => {
            return total + (parseFloat(estimate.total) || 0);
        }, 0);
    }

    // Download all estimates
    $('#downloadAllBtn').click(function() {
        if (generatedEstimates.length === 1) {
            // Single estimate - direct download
            window.open(generatedEstimates[0].download_url, '_blank');
        } else if (generatedEstimates.length > 1) {
            // Multiple estimates - download ZIP
            window.open('{{ route("documents.batch.generate", "estimate") }}', '_blank');
        }
    });

    // Show error
    function showError(message) {
        $('#error-message').text(message);
        $('#error-section').show();
        $('#preview-section, #progress-section, #results-section').hide();
    }

    // File input change handler
    $('#excel_file').change(function() {
        const fileName = this.files[0]?.name;
        if (fileName) {
            $(this).closest('label').find('p').first().html(`<span class="font-semibold">Selected:</span> ${fileName}`);
        }
    });
});
</script>
@endsection 