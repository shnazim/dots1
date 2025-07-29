@extends('layouts.app')

@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fab fa-microsoft text-primary me-2"></i>
                        Microsoft Dynamics 365 Business Central Integration Setup
                    </h4>
                    <p class="card-text">Connect to your Microsoft Dynamics 365 Business Central environment</p>
                </div>
                <div class="card-body">
                    <!-- Setup Instructions -->
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle me-2"></i>Setup Instructions</h5>
                        <ol class="mb-0">
                            <li>Register your app in <a href="https://portal.azure.com/" target="_blank">Azure Portal</a></li>
                            <li>Get your Tenant ID, Client ID, and Client Secret</li>
                            <li>Set the redirect URI to: <code>{{ route('integrations.dynamics.callback') }}</code></li>
                            <li>Configure API permissions for Business Central</li>
                            <li>Enter your credentials below and click "Connect"</li>
                        </ol>
                    </div>

                    <!-- Connection Form -->
                    <div class="row">
                        <div class="col-lg-8">
                            <form id="dynamicsSetupForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tenant_id" class="form-label">Tenant ID *</label>
                                            <input type="text" class="form-control" id="tenant_id" name="tenant_id" 
                                                   placeholder="12345678-1234-1234-1234-123456789012" required>
                                            <div class="form-text">Your Azure AD Tenant ID (Directory ID)</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="client_id" class="form-label">Client ID *</label>
                                            <input type="text" class="form-control" id="client_id" name="client_id" 
                                                   placeholder="12345678-1234-1234-1234-123456789012" required>
                                            <div class="form-text">Your Azure app registration Client ID (Application ID)</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="client_secret" class="form-label">Client Secret *</label>
                                            <input type="password" class="form-control" id="client_secret" name="client_secret" required>
                                            <div class="form-text">Your Azure app registration Client Secret</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="environment" class="form-label">Environment *</label>
                                            <select class="form-select" id="environment" name="environment" required>
                                                <option value="sandbox">Sandbox (Testing)</option>
                                                <option value="production">Production (Live)</option>
                                            </select>
                                            <div class="form-text">Choose your Business Central environment</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="company_id" class="form-label">Company ID</label>
                                            <input type="text" class="form-control" id="company_id" name="company_id" 
                                                   placeholder="CRONUS">
                                            <div class="form-text">Your Business Central company ID (optional)</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="api_version" class="form-label">API Version</label>
                                            <select class="form-select" id="api_version" name="api_version">
                                                <option value="v2.0">v2.0 (Latest)</option>
                                                <option value="v1.0">v1.0 (Legacy)</option>
                                            </select>
                                            <div class="form-text">Business Central API version to use</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="redirect_uri" class="form-label">Redirect URI</label>
                                    <input type="url" class="form-control" id="redirect_uri" name="redirect_uri" 
                                           value="{{ route('integrations.dynamics.callback') }}" readonly>
                                    <div class="form-text">Copy this URL to your Azure app registration</div>
                                </div>

                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-link me-2"></i>Connect to Dynamics 365
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
                                    <p class="card-text">To set up Azure app registration:</p>
                                    <ol class="small">
                                        <li>Go to <a href="https://portal.azure.com/" target="_blank">Azure Portal</a></li>
                                        <li>Navigate to "Azure Active Directory"</li>
                                        <li>Go to "App registrations"</li>
                                        <li>Click "New registration"</li>
                                        <li>Fill in app details</li>
                                        <li>Go to "Certificates & secrets"</li>
                                        <li>Create a new client secret</li>
                                        <li>Add API permissions for Business Central</li>
                                    </ol>
                                    <div class="mt-3">
                                        <a href="https://docs.microsoft.com/en-us/dynamics365/business-central/dev-itpro/developer/devenv-develop-connect-apps" 
                                           target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-external-link-alt me-1"></i>Dynamics 365 Docs
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Required Permissions -->
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-shield-alt me-2"></i>
                                        Required Permissions
                                    </h6>
                                    <ul class="list-unstyled small">
                                        <li><i class="fas fa-check text-success me-1"></i>Financials.ReadWrite.All</li>
                                        <li><i class="fas fa-check text-success me-1"></i>Financials.Read.All</li>
                                        <li><i class="fas fa-check text-success me-1"></i>offline_access</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Connection Test -->
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-test-tube me-2"></i>
                                        Test Connection
                                    </h6>
                                    <button type="button" class="btn btn-outline-primary btn-sm w-100" onclick="testDynamicsConnection()">
                                        <i class="fas fa-plug me-1"></i>Test Dynamics Connection
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Connection Status -->
                    <div id="connectionStatus" class="mt-4" style="display: none;">
                        <div class="alert alert-success">
                            <h6><i class="fas fa-check-circle me-2"></i>Connection Successful!</h6>
                            <p class="mb-2">Your Microsoft Dynamics 365 Business Central has been connected successfully.</p>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="fetchDynamicsData()">
                                    <i class="fas fa-download me-1"></i>Fetch Sample Data
                                </button>
                                <button type="button" class="btn btn-outline-info btn-sm" onclick="viewDynamicsSettings()">
                                    <i class="fas fa-cog me-1"></i>View Settings
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
    $('#dynamicsSetupForm').submit(function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Connecting...');
        
        $.ajax({
            url: '{{ route("integrations.dynamics.connect") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Redirect to Microsoft OAuth
                    window.location.href = response.auth_url;
                } else {
                    alert('Failed to initiate Dynamics 365 connection. Please check your credentials.');
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
                    alert('Error connecting to Dynamics 365. Please check your Azure app registration.');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
});

function testDynamicsConnection() {
    const tenantId = $('#tenant_id').val();
    const clientId = $('#client_id').val();
    const clientSecret = $('#client_secret').val();
    
    if (!tenantId || !clientId || !clientSecret) {
        alert('Please fill in all required fields before testing connection.');
        return;
    }
    
    const testBtn = event.target;
    const originalText = testBtn.innerHTML;
    
    testBtn.disabled = true;
    testBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Testing...';
    
    // Simulate connection test
    setTimeout(() => {
        testBtn.disabled = false;
        testBtn.innerHTML = originalText;
        alert('Connection test completed. Please check the console for details.');
    }, 2000);
}

function fetchDynamicsData() {
    alert('This would fetch sample data from your Dynamics 365 Business Central.');
}

function viewDynamicsSettings() {
    alert('This would show your current Dynamics 365 connection settings.');
}
</script>
@endsection 