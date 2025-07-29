@extends('layouts.app')

@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-cloud text-info me-2"></i>
                        Xero Integration Setup
                    </h4>
                    <p class="card-text">Connect your Xero account to sync accounting data</p>
                </div>
                <div class="card-body">
                    <!-- Setup Instructions -->
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle me-2"></i>Setup Instructions</h5>
                        <ol class="mb-0">
                            <li>Create a Xero app in the <a href="https://developer.xero.com/" target="_blank">Xero Developer Portal</a></li>
                            <li>Get your Client ID and Client Secret</li>
                            <li>Set the redirect URI to: <code>{{ route('integrations.xero.callback') }}</code></li>
                            <li>Enter your credentials below and click "Connect"</li>
                        </ol>
                    </div>

                    <!-- Connection Form -->
                    <div class="row">
                        <div class="col-lg-8">
                            <form id="xeroSetupForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="client_id" class="form-label">Client ID *</label>
                                            <input type="text" class="form-control" id="client_id" name="client_id" required>
                                            <div class="form-text">Your Xero app Client ID from Developer Portal</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="client_secret" class="form-label">Client Secret *</label>
                                            <input type="password" class="form-control" id="client_secret" name="client_secret" required>
                                            <div class="form-text">Your Xero app Client Secret</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="redirect_uri" class="form-label">Redirect URI</label>
                                    <input type="url" class="form-control" id="redirect_uri" name="redirect_uri" 
                                           value="{{ route('integrations.xero.callback') }}" readonly>
                                    <div class="form-text">Copy this URL to your Xero app settings</div>
                                </div>

                                <div class="mb-3">
                                    <label for="scopes" class="form-label">Required Scopes</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="scope_accounting" checked disabled>
                                        <label class="form-check-label" for="scope_accounting">
                                            accounting.transactions (Read/Write)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="scope_contacts" checked disabled>
                                        <label class="form-check-label" for="scope_contacts">
                                            accounting.contacts (Read/Write)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="scope_settings" checked disabled>
                                        <label class="form-check-label" for="scope_settings">
                                            accounting.settings (Read)
                                        </label>
                                    </div>
                                    <div class="form-text">These scopes are required for full integration</div>
                                </div>

                                <div class="mb-4">
                                    <button type="submit" class="btn btn-info btn-lg">
                                        <i class="fas fa-link me-2"></i>Connect to Xero
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
                                    <p class="card-text">Follow these steps to get your Xero credentials:</p>
                                    <ol class="small">
                                        <li>Go to <a href="https://developer.xero.com/" target="_blank">Xero Developer Portal</a></li>
                                        <li>Sign in with your Xero account</li>
                                        <li>Create a new app or use existing one</li>
                                        <li>Go to "App Details" section</li>
                                        <li>Copy Client ID and Client Secret</li>
                                        <li>Add redirect URI to "OAuth 2.0" section</li>
                                    </ol>
                                    <div class="mt-3">
                                        <a href="https://developer.xero.com/app/oauth2" 
                                           target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-external-link-alt me-1"></i>Xero API Docs
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Xero Features -->
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-star me-2"></i>
                                        Xero Features
                                    </h6>
                                    <ul class="list-unstyled small">
                                        <li><i class="fas fa-check text-success me-1"></i>Sync Contacts</li>
                                        <li><i class="fas fa-check text-success me-1"></i>Import Invoices</li>
                                        <li><i class="fas fa-check text-success me-1"></i>Export Bills</li>
                                        <li><i class="fas fa-check text-success me-1"></i>Chart of Accounts</li>
                                        <li><i class="fas fa-check text-success me-1"></i>Bank Transactions</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Connection Status -->
                    <div id="connectionStatus" class="mt-4" style="display: none;">
                        <div class="alert alert-success">
                            <h6><i class="fas fa-check-circle me-2"></i>Connection Successful!</h6>
                            <p class="mb-2">Your Xero account has been connected successfully.</p>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-info btn-sm" onclick="testXeroConnection()">
                                    <i class="fas fa-test-tube me-1"></i>Test Connection
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="fetchXeroData()">
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
    $('#xeroSetupForm').submit(function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Connecting...');
        
        $.ajax({
            url: '{{ route("integrations.xero.connect") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Redirect to Xero OAuth
                    window.location.href = response.auth_url;
                } else {
                    alert('Failed to initiate Xero connection. Please check your credentials.');
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
                    alert('Error connecting to Xero. Please try again.');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
});

function testXeroConnection() {
    $.ajax({
        url: '{{ route("integrations.xero.customers") }}',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                alert('Xero connection test successful!');
            } else {
                alert('Xero connection test failed. Please check your settings.');
            }
        },
        error: function() {
            alert('Xero connection test failed. Please check your settings.');
        }
    });
}

function fetchXeroData() {
    alert('This would fetch sample data from your Xero account.');
}
</script>
@endsection 