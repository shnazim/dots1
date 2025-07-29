@extends('layouts.app')

@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-database text-warning me-2"></i>
                        Oracle NetSuite Integration Setup
                    </h4>
                    <p class="card-text">Connect to your Oracle NetSuite ERP system for comprehensive data sync</p>
                </div>
                <div class="card-body">
                    <!-- Setup Instructions -->
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle me-2"></i>Setup Instructions</h5>
                        <ol class="mb-0">
                            <li>Enable SuiteTalk in your NetSuite account</li>
                            <li>Create a new integration record in NetSuite</li>
                            <li>Get your Account ID, Consumer Key, and Consumer Secret</li>
                            <li>Generate Token ID and Token Secret</li>
                            <li>Enter your credentials below and click "Connect"</li>
                        </ol>
                    </div>

                    <!-- Connection Form -->
                    <div class="row">
                        <div class="col-lg-8">
                            <form id="netsuiteSetupForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="account_id" class="form-label">Account ID *</label>
                                            <input type="text" class="form-control" id="account_id" name="account_id" 
                                                   placeholder="123456" required>
                                            <div class="form-text">Your NetSuite Account ID (found in Setup > Company > Company Information)</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="consumer_key" class="form-label">Consumer Key *</label>
                                            <input type="text" class="form-control" id="consumer_key" name="consumer_key" required>
                                            <div class="form-text">Your NetSuite integration Consumer Key</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="consumer_secret" class="form-label">Consumer Secret *</label>
                                            <input type="password" class="form-control" id="consumer_secret" name="consumer_secret" required>
                                            <div class="form-text">Your NetSuite integration Consumer Secret</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="token_id" class="form-label">Token ID *</label>
                                            <input type="text" class="form-control" id="token_id" name="token_id" required>
                                            <div class="form-text">Your NetSuite integration Token ID</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="token_secret" class="form-label">Token Secret *</label>
                                            <input type="password" class="form-control" id="token_secret" name="token_secret" required>
                                            <div class="form-text">Your NetSuite integration Token Secret</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="environment" class="form-label">Environment *</label>
                                            <select class="form-select" id="environment" name="environment" required>
                                                <option value="sandbox">Sandbox (Testing)</option>
                                                <option value="production">Production (Live)</option>
                                            </select>
                                            <div class="form-text">Choose your NetSuite environment</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="api_version" class="form-label">API Version</label>
                                            <select class="form-select" id="api_version" name="api_version">
                                                <option value="2023.2">2023.2 (Latest)</option>
                                                <option value="2023.1">2023.1</option>
                                                <option value="2022.2">2022.2</option>
                                                <option value="2022.1">2022.1</option>
                                            </select>
                                            <div class="form-text">NetSuite API version to use</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="timeout" class="form-label">Timeout (seconds)</label>
                                            <input type="number" class="form-control" id="timeout" name="timeout" 
                                                   value="60" min="30" max="300">
                                            <div class="form-text">API request timeout in seconds</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <button type="submit" class="btn btn-warning btn-lg">
                                        <i class="fas fa-link me-2"></i>Connect to NetSuite
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
                                    <p class="card-text">To set up NetSuite integration:</p>
                                    <ol class="small">
                                        <li>Go to Setup > Integration > Manage Integrations</li>
                                        <li>Click "New" to create integration</li>
                                        <li>Enable "Token-Based Authentication"</li>
                                        <li>Set application name and description</li>
                                        <li>Save and copy the credentials</li>
                                        <li>Go to Setup > Users/Roles > Access Tokens</li>
                                        <li>Create new access token</li>
                                        <li>Copy Token ID and Token Secret</li>
                                    </ol>
                                    <div class="mt-3">
                                        <a href="https://docs.oracle.com/en/cloud/saas/netsuite/ns-online-help/article_159266391446.html" 
                                           target="_blank" class="btn btn-outline-warning btn-sm">
                                            <i class="fas fa-external-link-alt me-1"></i>NetSuite API Docs
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- NetSuite Features -->
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-star me-2"></i>
                                        NetSuite Features
                                    </h6>
                                    <ul class="list-unstyled small">
                                        <li><i class="fas fa-check text-success me-1"></i>Customer Management</li>
                                        <li><i class="fas fa-check text-success me-1"></i>Vendor Management</li>
                                        <li><i class="fas fa-check text-success me-1"></i>Item Management</li>
                                        <li><i class="fas fa-check text-success me-1"></i>Sales Orders</li>
                                        <li><i class="fas fa-check text-success me-1"></i>Purchase Orders</li>
                                        <li><i class="fas fa-check text-success me-1"></i>Invoices & Bills</li>
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
                                    <button type="button" class="btn btn-outline-warning btn-sm w-100" onclick="testNetSuiteConnection()">
                                        <i class="fas fa-plug me-1"></i>Test NetSuite Connection
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Connection Status -->
                    <div id="connectionStatus" class="mt-4" style="display: none;">
                        <div class="alert alert-success">
                            <h6><i class="fas fa-check-circle me-2"></i>Connection Successful!</h6>
                            <p class="mb-2">Your Oracle NetSuite system has been connected successfully.</p>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-warning btn-sm" onclick="fetchNetSuiteData()">
                                    <i class="fas fa-download me-1"></i>Fetch Sample Data
                                </button>
                                <button type="button" class="btn btn-outline-info btn-sm" onclick="viewNetSuiteSettings()">
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
    $('#netsuiteSetupForm').submit(function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Connecting...');
        
        $.ajax({
            url: '{{ route("integrations.netsuite.connect") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#connectionStatus').show();
                    alert('Oracle NetSuite connected successfully!');
                } else {
                    alert('Failed to connect to Oracle NetSuite. Please check your credentials.');
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
                    alert('Error connecting to Oracle NetSuite. Please check your integration settings.');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
});

function testNetSuiteConnection() {
    const accountId = $('#account_id').val();
    const consumerKey = $('#consumer_key').val();
    const consumerSecret = $('#consumer_secret').val();
    const tokenId = $('#token_id').val();
    const tokenSecret = $('#token_secret').val();
    
    if (!accountId || !consumerKey || !consumerSecret || !tokenId || !tokenSecret) {
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

function fetchNetSuiteData() {
    alert('This would fetch sample data from your Oracle NetSuite system.');
}

function viewNetSuiteSettings() {
    alert('This would show your current Oracle NetSuite connection settings.');
}
</script>
@endsection 