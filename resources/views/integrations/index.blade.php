@extends('layouts.app')

@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-plug text-primary me-2"></i>
                        ERP & Accounting Integrations
                    </h4>
                    <p class="card-text">Connect your business systems for seamless data synchronization</p>
                </div>
                <div class="card-body">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Connected Platforms Summary -->
    @php
        $integrationsCollection = collect($integrations);
        $connectedCount = $integrationsCollection->filter()->count();
        $totalCount = $integrationsCollection->count();
    @endphp
    
    @if($connectedCount > 0)
        <div class="connected-platforms-summary mb-4">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <h5 class="mb-1">Connected Platforms ({{ $connectedCount }}/{{ $totalCount }})</h5>
                                <p class="mb-0">You have successfully connected the following ERP/accounting systems:</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-2">
                        @foreach($integrations as $platform => $integration)
                            @if($integration)
                                <div class="col-md-3 col-6">
                                    <div class="connected-platform-badge">
                                        <div class="platform-icon {{ $platform }}">
                                            @if($platform == 'quickbooks')
                                                <svg viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                                </svg>
                                            @elseif($platform == 'xero')
                                                <svg viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
                                                </svg>
                                            @elseif($platform == 'sap')
                                                <svg viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M3.5 18.49l6-6.01 4 4L22 6.92l-1.41-1.41-7.09 7.97-4-4L2 16.99z"/>
                                                </svg>
                                            @elseif($platform == 'dynamics')
                                                <svg viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                </svg>
                                            @elseif($platform == 'netsuite')
                                                <svg viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M20 6h-2.18c.11-.31.18-.65.18-1a2.996 2.996 0 0 0-5.5-1.65l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1z"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="platform-info">
                                            <h6 class="mb-0">{{ ucfirst($platform) }}</h6>
                                            <small class="text-muted">
                                                @if($integration->last_sync_at)
                                                    Last sync: {{ $integration->last_sync_at->diffForHumans() }}
                                                @else
                                                    Never synced
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <!-- QuickBooks Online -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <svg class="w-16 h-16 text-primary" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h5 class="card-title">QuickBooks Online</h5>
                    <p class="card-text text-muted mb-3">Connect to QuickBooks Online for seamless accounting integration</p>
                    
                    @if(isset($integrations['quickbooks']) && $integrations['quickbooks'])
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle me-2"></i>Connected
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary btn-sm" onclick="fetchQuickbooksData('customers')">
                                <i class="fas fa-users me-2"></i>Fetch Customers
                            </button>
                            <button class="btn btn-outline-primary btn-sm" onclick="fetchQuickbooksData('vendors')">
                                <i class="fas fa-building me-2"></i>Fetch Vendors
                            </button>
                            <button class="btn btn-outline-primary btn-sm" onclick="fetchQuickbooksData('items')">
                                <i class="fas fa-box me-2"></i>Fetch Items
                            </button>
                        </div>
                    @else
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>Not Connected
                        </div>
                        <a href="{{ route('integrations.quickbooks.setup') }}" class="btn btn-primary">
                            <i class="fas fa-plug me-2"></i>Connect QuickBooks
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- SAP Business One -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <svg class="w-16 h-16 text-success" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3.5 18.49l6-6.01 4 4L22 6.92l-1.41-1.41-7.09 7.97-4-4L2 16.99z"/>
                        </svg>
                    </div>
                    <h5 class="card-title">SAP Business One</h5>
                    <p class="card-text text-muted mb-3">Integrate with SAP Business One for enterprise resource planning</p>
                    
                    @if(isset($integrations['sap']) && $integrations['sap'])
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle me-2"></i>Connected
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-success btn-sm">
                                <i class="fas fa-sync me-2"></i>Sync Data
                            </button>
                            <button class="btn btn-outline-success btn-sm">
                                <i class="fas fa-cog me-2"></i>Manage Settings
                            </button>
                        </div>
                    @else
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>Not Connected
                        </div>
                        <a href="{{ route('integrations.sap.setup') }}" class="btn btn-success">
                            <i class="fas fa-plug me-2"></i>Connect SAP
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Xero -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <svg class="w-16 h-16 text-info" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
                        </svg>
                    </div>
                    <h5 class="card-title">Xero</h5>
                    <p class="card-text text-muted mb-3">Connect to Xero for cloud-based accounting and invoicing</p>
                    
                    @if(isset($integrations['xero']) && $integrations['xero'])
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle me-2"></i>Connected
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-info btn-sm">
                                <i class="fas fa-sync me-2"></i>Sync Invoices
                            </button>
                            <button class="btn btn-outline-info btn-sm">
                                <i class="fas fa-users me-2"></i>Sync Contacts
                            </button>
                        </div>
                    @else
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>Not Connected
                        </div>
                        <a href="{{ route('integrations.xero.setup') }}" class="btn btn-info">
                            <i class="fas fa-plug me-2"></i>Connect Xero
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Microsoft Dynamics 365 -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <svg class="w-16 h-16 text-primary" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h5 class="card-title">Microsoft Dynamics 365</h5>
                    <p class="card-text text-muted mb-3">Integrate with Microsoft Dynamics 365 Business Central</p>
                    
                    @if(isset($integrations['dynamics']) && $integrations['dynamics'])
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle me-2"></i>Connected
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-sync me-2"></i>Sync Data
                            </button>
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-cog me-2"></i>Manage Settings
                            </button>
                        </div>
                    @else
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>Not Connected
                        </div>
                        <a href="{{ route('integrations.dynamics.setup') }}" class="btn btn-primary">
                            <i class="fas fa-plug me-2"></i>Connect Dynamics
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Oracle NetSuite -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <svg class="w-16 h-16 text-warning" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 6h-2.18c.11-.31.18-.65.18-1a2.996 2.996 0 0 0-5.5-1.65l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1z"/>
                        </svg>
                    </div>
                    <h5 class="card-title">Oracle NetSuite</h5>
                    <p class="card-text text-muted mb-3">Connect to Oracle NetSuite for comprehensive ERP functionality</p>
                    
                    @if(isset($integrations['netsuite']) && $integrations['netsuite'])
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle me-2"></i>Connected
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-sync me-2"></i>Sync Data
                            </button>
                            <button class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-cog me-2"></i>Manage Settings
                            </button>
                        </div>
                    @else
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>Not Connected
                        </div>
                        <a href="{{ route('integrations.netsuite.setup') }}" class="btn btn-warning">
                            <i class="fas fa-plug me-2"></i>Connect NetSuite
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Integration Status -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm bg-light">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <svg class="w-16 h-16 text-secondary" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.8,11.69,4.8,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/>
                        </svg>
                    </div>
                    <h5 class="card-title">Integration Status</h5>
                    <p class="card-text text-muted mb-3">Overview of all your connected platforms</p>
                    
                    @php
                        $connectedCount = collect($integrations)->filter()->count();
                        $totalCount = count($integrations);
                    @endphp
                    
                    <div class="mb-3">
                        <h4 class="text-primary">{{ $connectedCount }}/{{ $totalCount }}</h4>
                        <p class="text-muted">Platforms Connected</p>
                    </div>
                    
                    <div class="progress mb-3">
                        <div class="progress-bar" role="progressbar" style="width: {{ ($connectedCount/$totalCount)*100 }}%"></div>
                    </div>
                    
                    <div class="d-grid">
                        <button class="btn btn-outline-secondary btn-sm" onclick="refreshAllIntegrations()">
                            <i class="fas fa-sync me-2"></i>Refresh All
                        </button>
                    </div>
                </div>
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function fetchQuickbooksData(type) {
    $.ajax({
        url: '{{ route("integrations.quickbooks.fetch", ["type" => ":type"]) }}'.replace(':type', type),
        method: 'GET',
        success: function(response) {
            if (response.success) {
                alert('Successfully fetched ' + type + ' from QuickBooks!');
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function() {
            alert('Error fetching data from QuickBooks');
        }
    });
}

function refreshAllIntegrations() {
    location.reload();
}
</script>

<style>
.w-16 {
    width: 4rem;
    height: 4rem;
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.connected-platform-badge {
    display: flex;
    align-items: center;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 0.75rem;
    transition: all 0.3s ease;
}

.connected-platform-badge:hover {
    background: #e9ecef;
    transform: translateY(-1px);
}

.platform-icon {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
    color: white;
}

.platform-icon.quickbooks { background: #2CA01C; }
.platform-icon.xero { background: #13B5EA; }
.platform-icon.sap { background: #003366; }
.platform-icon.dynamics { background: #0078D4; }
.platform-icon.netsuite { background: #FF6600; }

.platform-info h6 {
    font-weight: 600;
    color: #495057;
    margin: 0;
}

.platform-info small {
    font-size: 0.75rem;
}
</style>
@endsection 