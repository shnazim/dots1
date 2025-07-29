@extends('layouts.app')

@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-book text-primary me-2"></i>
                        Integration Setup Instructions
                    </h4>
                    <p class="card-text">Step-by-step guides to connect your ERP and accounting systems</p>
                </div>
                <div class="card-body">
                    <!-- QuickBooks Instructions -->
                    <div class="integration-guide mb-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="integration-icon me-3">
                                <svg class="w-8 h-8 text-primary" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <h3 class="mb-0">QuickBooks Online</h3>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="setup-steps">
                                    <h5 class="text-primary mb-3">Setup Steps:</h5>
                                    <ol class="step-list">
                                        <li class="step-item">
                                            <div class="step-number">1</div>
                                            <div class="step-content">
                                                <h6>Create QuickBooks App</h6>
                                                <p>Go to <a href="https://developer.intuit.com/" target="_blank">Intuit Developer Portal</a> and sign in with your Intuit account.</p>
                                                <ul>
                                                    <li>Click "Create App" or use an existing app</li>
                                                    <li>Select "QuickBooks Online" as the product</li>
                                                    <li>Choose "OAuth 2.0" as the authentication method</li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                        <li class="step-item">
                                            <div class="step-number">2</div>
                                            <div class="step-content">
                                                <h6>Configure OAuth Settings</h6>
                                                <p>In your app settings, add the following redirect URI:</p>
                                                <div class="alert alert-info">
                                                    <code>{{ route('integrations.quickbooks.callback') }}</code>
                                                </div>
                                            </div>
                                        </li>
                                        
                                        <li class="step-item">
                                            <div class="step-number">3</div>
                                            <div class="step-content">
                                                <h6>Get Your Credentials</h6>
                                                <p>From the "Keys" section, copy your:</p>
                                                <ul>
                                                    <li><strong>Client ID</strong> - Your app's unique identifier</li>
                                                    <li><strong>Client Secret</strong> - Your app's secret key</li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                        <li class="step-item">
                                            <div class="step-number">4</div>
                                            <div class="step-content">
                                                <h6>Connect Your Account</h6>
                                                <p>Go to <a href="{{ route('integrations.quickbooks.setup') }}">QuickBooks Setup</a> and enter your credentials.</p>
                                                <ul>
                                                    <li>Choose between Sandbox (testing) or Production (live)</li>
                                                    <li>Click "Connect to QuickBooks"</li>
                                                    <li>Authorize the connection in QuickBooks</li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                            
                            <div class="col-lg-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-lightbulb me-2"></i>
                                            Pro Tips
                                        </h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                Use Sandbox for testing first
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                Keep your Client Secret secure
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                Test with sample data before going live
                                            </li>
                                        </ul>
                                        
                                        <div class="mt-3">
                                            <a href="{{ route('integrations.quickbooks.setup') }}" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-plug me-2"></i>Setup QuickBooks
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Xero Instructions -->
                    <div class="integration-guide mb-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="integration-icon me-3">
                                <svg class="w-8 h-8 text-info" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
                                </svg>
                            </div>
                            <h3 class="mb-0">Xero</h3>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="setup-steps">
                                    <h5 class="text-info mb-3">Setup Steps:</h5>
                                    <ol class="step-list">
                                        <li class="step-item">
                                            <div class="step-number">1</div>
                                            <div class="step-content">
                                                <h6>Create Xero App</h6>
                                                <p>Visit the <a href="https://developer.xero.com/" target="_blank">Xero Developer Portal</a> and create a new app.</p>
                                                <ul>
                                                    <li>Sign in with your Xero account</li>
                                                    <li>Click "New App"</li>
                                                    <li>Select "Web app" as the app type</li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                        <li class="step-item">
                                            <div class="step-number">2</div>
                                            <div class="step-content">
                                                <h6>Configure App Settings</h6>
                                                <p>Set up your app with the following details:</p>
                                                <ul>
                                                    <li>App name: Your business name</li>
                                                    <li>Redirect URI: <code>{{ route('integrations.xero.callback') }}</code></li>
                                                    <li>Scopes: Select required permissions</li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                        <li class="step-item">
                                            <div class="step-number">3</div>
                                            <div class="step-content">
                                                <h6>Get API Credentials</h6>
                                                <p>From your app dashboard, note down:</p>
                                                <ul>
                                                    <li><strong>Client ID</strong> - Your app's identifier</li>
                                                    <li><strong>Client Secret</strong> - Your app's secret</li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                        <li class="step-item">
                                            <div class="step-number">4</div>
                                            <div class="step-content">
                                                <h6>Connect Your Xero Account</h6>
                                                <p>Go to <a href="{{ route('integrations.xero.setup') }}">Xero Setup</a> and complete the connection.</p>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                            
                            <div class="col-lg-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-lightbulb me-2"></i>
                                            Pro Tips
                                        </h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                Use demo organization for testing
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                Request minimal required scopes
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                Test API calls in Xero's API explorer
                                            </li>
                                        </ul>
                                        
                                        <div class="mt-3">
                                            <a href="{{ route('integrations.xero.setup') }}" class="btn btn-info btn-sm w-100">
                                                <i class="fas fa-plug me-2"></i>Setup Xero
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SAP Business One Instructions -->
                    <div class="integration-guide mb-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="integration-icon me-3">
                                <svg class="w-8 h-8 text-success" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3.5 18.49l6-6.01 4 4L22 6.92l-1.41-1.41-7.09 7.97-4-4L2 16.99z"/>
                                </svg>
                            </div>
                            <h3 class="mb-0">SAP Business One</h3>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="setup-steps">
                                    <h5 class="text-success mb-3">Setup Steps:</h5>
                                    <ol class="step-list">
                                        <li class="step-item">
                                            <div class="step-number">1</div>
                                            <div class="step-content">
                                                <h6>Enable SAP B1 Service Layer</h6>
                                                <p>Ensure your SAP Business One installation has the Service Layer enabled.</p>
                                                <ul>
                                                    <li>Check with your SAP administrator</li>
                                                    <li>Verify Service Layer is running</li>
                                                    <li>Note the Service Layer URL</li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                        <li class="step-item">
                                            <div class="step-number">2</div>
                                            <div class="step-content">
                                                <h6>Create API User</h6>
                                                <p>In SAP Business One, create a dedicated user for API access:</p>
                                                <ul>
                                                    <li>Go to Administration → Users</li>
                                                    <li>Create new user with API permissions</li>
                                                    <li>Assign appropriate authorizations</li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                        <li class="step-item">
                                            <div class="step-number">3</div>
                                            <div class="step-content">
                                                <h6>Configure Connection</h6>
                                                <p>Go to <a href="{{ route('integrations.sap.setup') }}">SAP Setup</a> and enter:</p>
                                                <ul>
                                                    <li><strong>Service Layer URL</strong> - Your SAP B1 service endpoint</li>
                                                    <li><strong>Company Database</strong> - Your SAP company database</li>
                                                    <li><strong>Username</strong> - API user credentials</li>
                                                    <li><strong>Password</strong> - API user password</li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                            
                            <div class="col-lg-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-lightbulb me-2"></i>
                                            Pro Tips
                                        </h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                Use dedicated API user account
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                Test connection in development first
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                Monitor API usage and performance
                                            </li>
                                        </ul>
                                        
                                        <div class="mt-3">
                                            <a href="{{ route('integrations.sap.setup') }}" class="btn btn-success btn-sm w-100">
                                                <i class="fas fa-plug me-2"></i>Setup SAP
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Microsoft Dynamics Instructions -->
                    <div class="integration-guide mb-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="integration-icon me-3">
                                <svg class="w-8 h-8 text-primary" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <h3 class="mb-0">Microsoft Dynamics 365</h3>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="setup-steps">
                                    <h5 class="text-primary mb-3">Setup Steps:</h5>
                                    <ol class="step-list">
                                        <li class="step-item">
                                            <div class="step-number">1</div>
                                            <div class="step-content">
                                                <h6>Register Azure App</h6>
                                                <p>Go to <a href="https://portal.azure.com/" target="_blank">Azure Portal</a> and register a new application.</p>
                                                <ul>
                                                    <li>Navigate to Azure Active Directory</li>
                                                    <li>Go to App registrations</li>
                                                    <li>Click "New registration"</li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                        <li class="step-item">
                                            <div class="step-number">2</div>
                                            <div class="step-content">
                                                <h6>Configure App Permissions</h6>
                                                <p>Set up the required permissions for Dynamics 365:</p>
                                                <ul>
                                                    <li>Add Dynamics CRM permissions</li>
                                                    <li>Grant admin consent</li>
                                                    <li>Note the Application ID and Tenant ID</li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                        <li class="step-item">
                                            <div class="step-number">3</div>
                                            <div class="step-content">
                                                <h6>Create Client Secret</h6>
                                                <p>Generate a client secret for your app:</p>
                                                <ul>
                                                    <li>Go to Certificates & secrets</li>
                                                    <li>Create new client secret</li>
                                                    <li>Copy the secret value immediately</li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                        <li class="step-item">
                                            <div class="step-number">4</div>
                                            <div class="step-content">
                                                <h6>Connect to Dynamics</h6>
                                                <p>Go to <a href="{{ route('integrations.dynamics.setup') }}">Dynamics Setup</a> and enter your credentials.</p>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                            
                            <div class="col-lg-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-lightbulb me-2"></i>
                                            Pro Tips
                                        </h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                Use service account for API access
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                Store client secret securely
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                Test in sandbox environment first
                                            </li>
                                        </ul>
                                        
                                        <div class="mt-3">
                                            <a href="{{ route('integrations.dynamics.setup') }}" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-plug me-2"></i>Setup Dynamics
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Oracle NetSuite Instructions -->
                    <div class="integration-guide mb-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="integration-icon me-3">
                                <svg class="w-8 h-8 text-warning" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20 6h-2.18c.11-.31.18-.65.18-1a2.996 2.996 0 0 0-5.5-1.65l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1z"/>
                                </svg>
                            </div>
                            <h3 class="mb-0">Oracle NetSuite</h3>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="setup-steps">
                                    <h5 class="text-warning mb-3">Setup Steps:</h5>
                                    <ol class="step-list">
                                        <li class="step-item">
                                            <div class="step-number">1</div>
                                            <div class="step-content">
                                                <h6>Enable SuiteTalk Integration</h6>
                                                <p>In your NetSuite account, enable SuiteTalk integration features.</p>
                                                <ul>
                                                    <li>Go to Setup → Integration → Manage Integrations</li>
                                                    <li>Enable SuiteTalk (REST Web Services)</li>
                                                    <li>Note your Account ID</li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                        <li class="step-item">
                                            <div class="step-number">2</div>
                                            <div class="step-content">
                                                <h6>Create Integration Record</h6>
                                                <p>Set up an integration record in NetSuite:</p>
                                                <ul>
                                                    <li>Go to Setup → Integration → Manage Integrations</li>
                                                    <li>Create new integration record</li>
                                                    <li>Configure required permissions</li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                        <li class="step-item">
                                            <div class="step-number">3</div>
                                            <div class="step-content">
                                                <h6>Generate Tokens</h6>
                                                <p>Create authentication tokens:</p>
                                                <ul>
                                                    <li>Generate Consumer Key and Secret</li>
                                                    <li>Create Token ID and Token Secret</li>
                                                    <li>Note all credentials securely</li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                        <li class="step-item">
                                            <div class="step-number">4</div>
                                            <div class="step-content">
                                                <h6>Connect NetSuite</h6>
                                                <p>Go to <a href="{{ route('integrations.netsuite.setup') }}">NetSuite Setup</a> and enter your credentials.</p>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                            
                            <div class="col-lg-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-lightbulb me-2"></i>
                                            Pro Tips
                                        </h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                Use sandbox for testing
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                Store tokens securely
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                                Monitor API usage limits
                                            </li>
                                        </ul>
                                        
                                        <div class="mt-3">
                                            <a href="{{ route('integrations.netsuite.setup') }}" class="btn btn-warning btn-sm w-100">
                                                <i class="fas fa-plug me-2"></i>Setup NetSuite
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- General Tips -->
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-star me-2"></i>
                                General Integration Tips
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Security Best Practices:</h6>
                                    <ul>
                                        <li>Always use dedicated API accounts</li>
                                        <li>Store credentials securely</li>
                                        <li>Use HTTPS for all connections</li>
                                        <li>Regularly rotate access tokens</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Testing Recommendations:</h6>
                                    <ul>
                                        <li>Test in sandbox/demo environments first</li>
                                        <li>Verify data synchronization</li>
                                        <li>Check error handling</li>
                                        <li>Monitor integration logs</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.integration-guide {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 2rem;
    background: #fff;
}

.integration-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: #f8f9fa;
}

.step-list {
    list-style: none;
    padding: 0;
}

.step-item {
    display: flex;
    margin-bottom: 2rem;
    align-items: flex-start;
}

.step-number {
    width: 32px;
    height: 32px;
    background: #007bff;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-right: 1rem;
    flex-shrink: 0;
}

.step-content h6 {
    margin-bottom: 0.5rem;
    color: #495057;
}

.step-content p {
    margin-bottom: 0.5rem;
    color: #6c757d;
}

.step-content ul {
    margin-bottom: 0;
    padding-left: 1.5rem;
}

.step-content li {
    margin-bottom: 0.25rem;
    color: #6c757d;
}

.w-8 {
    width: 2rem;
    height: 2rem;
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.alert {
    border-radius: 6px;
}

code {
    background: #f8f9fa;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.875rem;
}
</style>
@endsection 