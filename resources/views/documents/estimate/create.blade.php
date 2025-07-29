@extends('website.layouts')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-calculator me-2"></i>
                        Create Estimate
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- Template Selection -->
                    <div class="mb-4">
                        <h5 class="mb-3">Choose Template</h5>
                        <div class="row">
                            @foreach($templates as $template)
                            <div class="col-md-4 mb-3">
                                <div class="template-card border rounded p-3 text-center cursor-pointer" 
                                     data-template-id="{{ $template['id'] }}">
                                    <img src="{{ asset('public/templates/' . $template['preview']) }}" 
                                         alt="{{ $template['name'] }}" 
                                         class="img-fluid mb-2" 
                                         style="max-height: 150px;">
                                    <h6>{{ $template['name'] }}</h6>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Estimate Form -->
                    <form id="estimateForm" action="{{ route('documents.estimate.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="template_id" id="template_id" value="1">
                        
                        <!-- Customer Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="mb-3">Customer Information</h5>
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Customer Name *</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="customer_email" class="form-label">Customer Email *</label>
                                    <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="customer_phone" class="form-label">Customer Phone</label>
                                    <input type="text" class="form-control" id="customer_phone" name="customer_phone">
                                </div>
                                <div class="mb-3">
                                    <label for="customer_address" class="form-label">Customer Address</label>
                                    <textarea class="form-control" id="customer_address" name="customer_address" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Estimate Details</h5>
                                <div class="mb-3">
                                    <label for="estimate_date" class="form-label">Estimate Date</label>
                                    <input type="date" class="form-control" id="estimate_date" name="estimate_date" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="valid_until" class="form-label">Valid Until</label>
                                    <input type="date" class="form-control" id="valid_until" name="valid_until" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="estimate_number" class="form-label">Estimate Number</label>
                                    <input type="text" class="form-control" id="estimate_number" name="estimate_number" value="EST-{{ date('Ymd') }}-001">
                                </div>
                                <div class="mb-3">
                                    <label for="project_name" class="form-label">Project Name</label>
                                    <input type="text" class="form-control" id="project_name" name="project_name">
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Items -->
                        <div class="mb-4">
                            <h5 class="mb-3">Estimate Items</h5>
                            <div id="items-container">
                                <div class="item-row row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Description *</label>
                                        <input type="text" class="form-control" name="items[0][description]" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Quantity *</label>
                                        <input type="number" class="form-control quantity" name="items[0][quantity]" value="1" min="0" step="0.01" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Unit Price *</label>
                                        <input type="number" class="form-control unit-price" name="items[0][unit_price]" value="0" min="0" step="0.01" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Tax Rate (%)</label>
                                        <input type="number" class="form-control tax-rate" name="items[0][tax_rate]" value="0" min="0" step="0.01">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Total</label>
                                        <input type="text" class="form-control item-total" readonly>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-warning btn-sm" id="add-item">
                                <i class="fas fa-plus me-1"></i>Add Item
                            </button>
                        </div>

                        <!-- Totals -->
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <span id="subtotal">$0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Tax:</span>
                                            <span id="total-tax">$0.00</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total:</span>
                                            <span id="grand-total">$0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-warning btn-lg me-3">
                                    <i class="fas fa-save me-2"></i>Generate Estimate
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let itemCount = 1;

    // Template selection
    $('.template-card').click(function() {
        $('.template-card').removeClass('selected');
        $(this).addClass('selected');
        $('#template_id').val($(this).data('template-id'));
    });

    // Add item
    $('#add-item').click(function() {
        const newItem = `
            <div class="item-row row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Description *</label>
                    <input type="text" class="form-control" name="items[${itemCount}][description]" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Quantity *</label>
                    <input type="number" class="form-control quantity" name="items[${itemCount}][quantity]" value="1" min="0" step="0.01" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Unit Price *</label>
                    <input type="number" class="form-control unit-price" name="items[${itemCount}][unit_price]" value="0" min="0" step="0.01" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tax Rate (%)</label>
                    <input type="number" class="form-control tax-rate" name="items[${itemCount}][tax_rate]" value="0" min="0" step="0.01">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Total</label>
                    <input type="text" class="form-control item-total" readonly>
                    <button type="button" class="btn btn-sm btn-outline-danger mt-1 remove-item">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        $('#items-container').append(newItem);
        itemCount++;
    });

    // Remove item
    $(document).on('click', '.remove-item', function() {
        $(this).closest('.item-row').remove();
        calculateTotals();
    });

    // Calculate item totals
    $(document).on('input', '.quantity, .unit-price, .tax-rate', function() {
        const row = $(this).closest('.item-row');
        const quantity = parseFloat(row.find('.quantity').val()) || 0;
        const unitPrice = parseFloat(row.find('.unit-price').val()) || 0;
        const taxRate = parseFloat(row.find('.tax-rate').val()) || 0;
        
        const subtotal = quantity * unitPrice;
        const tax = subtotal * (taxRate / 100);
        const total = subtotal + tax;
        
        row.find('.item-total').val('$' + total.toFixed(2));
        calculateTotals();
    });

    // Calculate grand totals
    function calculateTotals() {
        let subtotal = 0;
        let totalTax = 0;
        
        $('.item-row').each(function() {
            const quantity = parseFloat($(this).find('.quantity').val()) || 0;
            const unitPrice = parseFloat($(this).find('.unit-price').val()) || 0;
            const taxRate = parseFloat($(this).find('.tax-rate').val()) || 0;
            
            const itemSubtotal = quantity * unitPrice;
            const itemTax = itemSubtotal * (taxRate / 100);
            
            subtotal += itemSubtotal;
            totalTax += itemTax;
        });
        
        const grandTotal = subtotal + totalTax;
        
        $('#subtotal').text('$' + subtotal.toFixed(2));
        $('#total-tax').text('$' + totalTax.toFixed(2));
        $('#grand-total').text('$' + grandTotal.toFixed(2));
    }

    // Form submission
    $('#estimateForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    alert('Estimate generated successfully!');
                    if (response.download_url) {
                        window.open(response.download_url, '_blank');
                    }
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    window.location.href = '{{ route("login") }}';
                } else {
                    alert('Error generating estimate. Please try again.');
                }
            }
        });
    });

    // Initialize first template as selected
    $('.template-card').first().addClass('selected');
});
</script>

<style>
.template-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.template-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.template-card.selected {
    border-color: #ffc107 !important;
    background-color: #f8f9fa;
}

.cursor-pointer {
    cursor: pointer;
}
</style>
@endsection 