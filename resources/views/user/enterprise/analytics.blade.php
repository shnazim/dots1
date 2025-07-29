@extends('layouts.app')

@section('title', 'Reports & Analytics')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Enterprise Analytics Dashboard</h4>
                    <p class="card-text">Comprehensive business intelligence and reporting</p>
                </div>
                <div class="card-body">
                    <!-- Quick Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Total Sales</h6>
                                            <h3 class="mb-0">${{ number_format($salesData->sum('total_sales'), 2) }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-chart-line fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Total Orders</h6>
                                            <h3 class="mb-0">{{ $salesData->sum('total_invoices') }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-shopping-cart fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Avg Order Value</h6>
                                            <h3 class="mb-0">${{ number_format($salesData->avg('avg_order_value'), 2) }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-dollar-sign fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Inventory Value</h6>
                                            <h3 class="mb-0">${{ number_format($inventoryData->sum('stock_value'), 2) }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-boxes fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Sales Trend (Current Month)</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="salesChart" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Top Products by Value</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="productsChart" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Tables Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Top Customers</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Customer</th>
                                                    <th>Orders</th>
                                                    <th>Total Spent</th>
                                                    <th>Avg Order</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($customerData as $customer)
                                                <tr>
                                                    <td>{{ $customer->name }}</td>
                                                    <td>{{ $customer->total_orders }}</td>
                                                    <td>${{ number_format($customer->total_spent, 2) }}</td>
                                                    <td>${{ number_format($customer->avg_order_value, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Warehouse Utilization</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Warehouse</th>
                                                    <th>Items</th>
                                                    <th>Value</th>
                                                    <th>Utilization</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($warehouseData as $warehouse)
                                                <tr>
                                                    <td>{{ $warehouse->name }}</td>
                                                    <td>{{ $warehouse->total_items }}</td>
                                                    <td>${{ number_format($warehouse->total_value, 2) }}</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" 
                                                                 style="width: {{ $warehouse->utilization_percentage }}%"
                                                                 aria-valuenow="{{ $warehouse->utilization_percentage }}" 
                                                                 aria-valuemin="0" aria-valuemax="100">
                                                                {{ number_format($warehouse->utilization_percentage, 1) }}%
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Report Generation -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Generate Reports</h5>
                                </div>
                                <div class="card-body">
                                    <form id="reportForm">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="report_type">Report Type</label>
                                                    <select class="form-control" id="report_type" name="report_type" required>
                                                        <option value="">Select Report Type</option>
                                                        <option value="sales">Sales Report</option>
                                                        <option value="inventory">Inventory Report</option>
                                                        <option value="warehouse">Warehouse Report</option>
                                                        <option value="customer">Customer Report</option>
                                                        <option value="shipping">Shipping Report</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="date_from">Date From</label>
                                                    <input type="date" class="form-control" id="date_from" name="date_from" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="date_to">Date To</label>
                                                    <input type="date" class="form-control" id="date_to" name="date_to" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="format">Format</label>
                                                    <select class="form-control" id="format" name="format" required>
                                                        <option value="pdf">PDF</option>
                                                        <option value="excel">Excel</option>
                                                        <option value="csv">CSV</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-download"></i> Generate Report
                                                </button>
                                                <button type="button" class="btn btn-secondary ml-2" onclick="exportDashboard()">
                                                    <i class="fas fa-file-export"></i> Export Dashboard
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: @json($salesData->pluck('date')),
            datasets: [{
                label: 'Sales ($)',
                data: @json($salesData->pluck('total_sales')),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Products Chart
    const productsCtx = document.getElementById('productsChart').getContext('2d');
    const productsChart = new Chart(productsCtx, {
        type: 'doughnut',
        data: {
            labels: @json($inventoryData->pluck('name')),
            datasets: [{
                data: @json($inventoryData->pluck('stock_value')),
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Report Form Handler
    document.getElementById('reportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('/enterprise/reports/generate', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('Report generated successfully!', 'success');
                if (data.download_url) {
                    window.open(data.download_url, '_blank');
                }
            } else {
                showAlert('Error generating report: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error generating report', 'error');
        });
    });
});

function exportDashboard() {
    // Export dashboard as PDF or image
    const element = document.querySelector('.container-fluid');
    html2canvas(element).then(canvas => {
        const link = document.createElement('a');
        link.download = 'dashboard-export.png';
        link.href = canvas.toDataURL();
        link.click();
    });
}

function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    `;
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
</script>
@endpush 