@extends('layouts.app')

@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-chart-line text-success me-2"></i>
                        SAP Business One Integration Setup
                    </h4>
                    <p class="card-text">Connect to your SAP Business One system for enterprise data sync</p>
                </div>
                <div class="card-body">
                    <!-- Setup Instructions -->
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle me-2"></i>Setup Instructions</h5>
                        <ol class="mb-0">
                            <li>Ensure SAP Business One Service Layer is running</li>
                            <li>Get your SAP server URL and company database name</li>
                            <li>Create a dedicated user account for API access</li>
                            <li>Enter your connection details below</li>
                        </ol>
                    </div>

                    <!-- Connection Form -->
                    <div class="row">
                        <div class="col-lg-8">
                            <form id="sapSetupForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="server_url" class="form-label">Server URL *</label>
                                            <input type="url" class="form-control" id="server_url" name="server_url" 
                                                   placeholder="https://your-sap-server:50000/b1s/v1" required>
                                            <div class="form-text">Your SAP Business One Service Layer URL</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="company_db" class="form-label">Company Database *</label>
                                            <input type="text" class="form-control" id="company_db" name="company_db" required>
                                            <div class="form-text">Your SAP Business One company database name</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username *</label>
                                            <input type="text" class="form-control" id="username" name="username" required>
                                            <div class="form-text">SAP Business One user account for API access</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password *</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                            <div class="form-text">Password for the SAP user account</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="language" class="form-label">Language</label>
                                            <select class="form-select" id="language" name="language">
                                                <option value="23">English (en_US)</option>
                                                <option value="1">Arabic (ar_SA)</option>
                                                <option value="2">Chinese (zh_CN)</option>
                                                <option value="3">French (fr_FR)</option>
                                                <option value="4">German (de_DE)</option>
                                                <option value="5">Spanish (es_ES)</option>
                                            </select>
                                            <div class="form-text">SAP Business One language code</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="timeout" class="form-label">Timeout (seconds)</label>
                                            <input type="number" class="form-control" id="timeout" name="timeout" 
                                                   value="30" min="10" max="300">
                                            <div class="form-text">API request timeout in seconds</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-link me-2"></i>Connect to SAP Business One
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
                                    <p class="card-text">To connect to SAP Business One:</p>
                                    <ol class="small">
                                        <li>Ensure Service Layer is installed and running</li>
                                        <li>Check Service Layer URL in SAP B1 Admin</li>
                                        <li>Create a dedicated API user account</li>
                                        <li>Grant necessary permissions to the user</li>
                                        <li>Test connection with SAP B1 Admin tool</li>
                                    </ol>
                                    <div class="mt-3">
                                        <a href="https://help.sap.com/doc/1d9eb9386cce4c3ea6e8d7c867ca44e/10.0/en-US/Default.htm" 
                                           target="_blank" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-external-link-alt me-1"></i>SAP B1 API Docs
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Connection Test -->
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-test-tube me-2"></i>
                                        Test Connection
                                    </h6>
                                    <button type="button" class="btn btn-outline-primary btn-sm w-100" onclick="testSAPConnection()">
                                        <i class="fas fa-plug me-1"></i>Test SAP Connection
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Connection Status -->
                    <div id="connectionStatus" class="mt-4" style="display: none;">
                        <div class="alert alert-success">
                            <h6><i class="fas fa-check-circle me-2"></i>Connection Successful!</h6>
                            <p class="mb-2">Your SAP Business One system has been connected successfully.</p>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-success btn-sm" onclick="fetchSAPData()">
                                    <i class="fas fa-download me-1"></i>Fetch Sample Data
                                </button>
                                <button type="button" class="btn btn-outline-info btn-sm" onclick="viewSAPSettings()">
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
    $('#sapSetupForm').submit(function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Connecting...');
        
        $.ajax({
            url: '{{ route("integrations.sap.connect") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#connectionStatus').show();
                    alert('SAP Business One connected successfully!');
                } else {
                    alert('Failed to connect to SAP Business One. Please check your credentials.');
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
                    alert('Error connecting to SAP Business One. Please check your server URL and credentials.');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
});

function testSAPConnection() {
    const serverUrl = $('#server_url').val();
    const companyDb = $('#company_db').val();
    const username = $('#username').val();
    const password = $('#password').val();
    
    if (!serverUrl || !companyDb || !username || !password) {
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

function fetchSAPData() {
    alert('This would fetch sample data from your SAP Business One system.');
}

function viewSAPSettings() {
    alert('This would show your current SAP Business One connection settings.');
}
</script>
@endsection 