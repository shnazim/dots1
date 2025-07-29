@extends('layouts.app')

@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fab fa-quickbooks text-primary me-2"></i>
                        QuickBooks Online Integration Setup
                    </h4>
                    <p class="card-text">Connect your account to sync customers, vendors, and transactions</p>
                </div>
                <div class="card-body">
                    <!-- Setup Instructions -->
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle me-2"></i>Setup Instructions</h5>
                        <ol class="mb-0">
                            <li>Create a QuickBooks app in the <a href="https://developer.intuit.com/" target="_blank">Intuit Developer Portal</a></li>
                            <li>Get your Client ID and Client Secret</li>
                            <li>Set the redirect URI to: <code>{{ route('integrations.quickbooks.callback') }}</code></li>
                            <li>Enter your credentials below and click "Connect"</li>
                        </ol>
                    </div>

                    <!-- Connection Form -->
                    <div class="row">
                        <div class="col-lg-8">
                            <form id="quickbooksSetupForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="client_id" class="form-label">Client ID *</label>
                                            <input type="text" class="form-control" id="client_id" name="client_id" required>
                                            <div class="form-text">Your QuickBooks app Client ID from Intuit Developer Portal</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="client_secret" class="form-label">Client Secret *</label>
                                            <input type="password" class="form-control" id="client_secret" name="client_secret" required>
                                            <div class="form-text">Your QuickBooks app Client Secret</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="redirect_uri" class="form-label">Redirect URI</label>
                                    <input type="url" class="form-control" id="redirect_uri" name="redirect_uri" 
                                           value="{{ route('integrations.quickbooks.callback') }}" readonly>
                                    <div class="form-text">Copy this URL to your QuickBooks app settings</div>
                                </div>

                                <div class="mb-3">
                                    <label for="environment" class="form-label">Environment</label>
                                    <select class="form-select" id="environment" name="environment">
                                        <option value="sandbox">Sandbox (Testing)</option>
                                        <option value="production">Production (Live)</option>
                                    </select>
                                    <div class="form-text">Choose between sandbox for testing or production for live data</div>
                                </div>

                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-link me-2"></i>Connect to QuickBooks
                                    </button>
                                    <a href="{{ route('integrations.index') }}" class="btn btn-secondary btn-lg ms-2">
                                        <i class="fas fa-arrow-left me-2"></i>Back to Integrations
                                    </a>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-question-circle me-2"></i>
                                        Need Help?
                                    </h5>
                                    <p class="card-text">Follow these steps to get your QuickBooks credentials:</p>
                                    <ol class="small">
                                        <li>Go to <a href="https://developer.intuit.com/" target="_blank">Intuit Developer Portal</a></li>
                                        <li>Sign in with your Intuit account</li>
                                        <li>Create a new app or use existing one</li>
                                        <li>Go to "Keys" section</li>
                                        <li>Copy Client ID and Client Secret</li>
                                        <li>Add redirect URI to "OAuth 2.0" section</li>
                                    </ol>
                                    <div class="mt-3">
                                        <a href="https://developer.intuit.com/app/developer/qbo/docs/develop/authentication-and-authorization" 
                                           target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-external-link-alt me-1"></i>QuickBooks API Docs
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Connection Status -->
                    <div id="connectionStatus" class="mt-4" style="display: none;">
                        <div class="alert alert-success">
                            <h6><i class="fas fa-check-circle me-2"></i>Connection Successful!</h6>
                            <p class="mb-2">Your QuickBooks account has been connected successfully.</p>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-success btn-sm" onclick="testConnection()">
                                    <i class="fas fa-test-tube me-1"></i>Test Connection
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="fetchData()">
                                    <i class="fas fa-download me-1"></i>Fetch Sample Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#quickbooksSetupForm').submit(function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Connecting...');
        
        $.ajax({
            url: '{{ route("integrations.quickbooks.connect") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Redirect to QuickBooks OAuth
                    window.location.href = response.auth_url;
                } else {
                    alert('Failed to initiate QuickBooks connection. Please check your credentials.');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'Please fix the following errors:\n';
                    for (let field in errors) {
                        errorMessage += `- ${errors[field][0]}\n`;
                    }
                    alert(errorMessage);
                } else {
                    alert('Error connecting to QuickBooks. Please try again.');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
});

function testConnection() {
    $.ajax({
        url: '{{ route("integrations.quickbooks.customers") }}',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                alert('Connection test successful! Found ' + response.customers.length + ' customers.');
            } else {
                alert('Connection test failed. Please check your settings.');
            }
        },
        error: function() {
            alert('Connection test failed. Please check your settings.');
        }
    });
}

function fetchData() {
    // This would fetch sample data from QuickBooks
    alert('This would fetch sample data from your QuickBooks account.');
}
</script>
@endsection 