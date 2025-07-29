@extends('layouts.app')

@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Integration Status Overview
                    </h4>
                    <p class="card-text">Monitor the status of all your connected ERP and accounting systems</p>
                </div>
                <div class="card-body">
                    <!-- Status Summary -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="status-card bg-primary text-white">
                                <div class="status-icon">
                                    <i class="fas fa-plug"></i>
                                </div>
                                <div class="status-content">
                                    <h3>{{ $connectedCount }}</h3>
                                    <p>Connected Platforms</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="status-card bg-success text-white">
                                <div class="status-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="status-content">
                                    <h3>{{ $totalCount - $connectedCount }}</h3>
                                    <p>Available Platforms</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="status-card bg-info text-white">
                                <div class="status-icon">
                                    <i class="fas fa-sync"></i>
                                </div>
                                <div class="status-content">
                                    <h3>{{ $connectedCount > 0 ? 'Active' : 'None' }}</h3>
                                    <p>Sync Status</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="status-card bg-warning text-white">
                                <div class="status-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="status-content">
                                    <h3>{{ $connectedCount > 0 ? '24h' : 'N/A' }}</h3>
                                    <p>Last Sync</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="progress-section mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Integration Progress</h6>
                            <span class="text-muted">{{ $connectedCount }}/{{ $totalCount }} platforms connected</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ ($connectedCount/$totalCount)*100 }}%" 
                                 aria-valuenow="{{ ($connectedCount/$totalCount)*100 }}" 
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Platform Status Cards -->
                    <div class="row">
                        <!-- QuickBooks Status -->
                        <div class="col-lg-6 col-md-12 mb-4">
                            <div class="platform-status-card {{ $integrations['quickbooks'] ? 'connected' : 'disconnected' }}">
                                <div class="platform-header">
                                    <div class="platform-info">
                                        <div class="platform-icon quickbooks">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="platform-name">QuickBooks Online</h5>
                                            <p class="platform-description">Cloud-based accounting software</p>
                                        </div>
                                    </div>
                                    <div class="status-indicator">
                                        @if(isset($integrations['quickbooks']) && $integrations['quickbooks'])
                                            <span class="badge bg-success">Connected</span>
                                        @else
                                            <span class="badge bg-secondary">Not Connected</span>
                                        @endif
                                    </div>
                                </div>
                                
                                @if(isset($integrations['quickbooks']) && $integrations['quickbooks'])
                                    <div class="connection-details">
                                        <div class="detail-item">
                                            <span class="detail-label">Connected Since:</span>
                                            <span class="detail-value">{{ $integrations['quickbooks']->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Last Sync:</span>
                                            <span class="detail-value">
                                                {{ $integrations['quickbooks']->last_sync_at ? $integrations['quickbooks']->last_sync_at->diffForHumans() : 'Never' }}
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Environment:</span>
                                            <span class="detail-value">{{ ucfirst($integrations['quickbooks']->settings['environment'] ?? 'Unknown') }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Status:</span>
                                            <span class="detail-value">
                                                @if($integrations['quickbooks']->isExpired())
                                                    <span class="text-danger">Expired</span>
                                                @elseif($integrations['quickbooks']->needsRefresh())
                                                    <span class="text-warning">Needs Refresh</span>
                                                @else
                                                    <span class="text-success">Active</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="action-buttons">
                                        <button class="btn btn-outline-primary btn-sm" onclick="testConnection('quickbooks')">
                                            <i class="fas fa-wifi me-1"></i>Test Connection
                                        </button>
                                        <button class="btn btn-outline-success btn-sm" onclick="syncData('quickbooks')">
                                            <i class="fas fa-sync me-1"></i>Sync Now
                                        </button>
                                        <button class="btn btn-outline-warning btn-sm" onclick="refreshToken('quickbooks')">
                                            <i class="fas fa-key me-1"></i>Refresh Token
                                        </button>
                                    </div>
                                @else
                                    <div class="connection-prompt">
                                        <p class="text-muted mb-3">Connect your QuickBooks Online account to sync customers, vendors, and transactions.</p>
                                        <a href="{{ route('integrations.quickbooks.setup') }}" class="btn btn-primary">
                                            <i class="fas fa-plug me-2"></i>Connect QuickBooks
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Xero Status -->
                        <div class="col-lg-6 col-md-12 mb-4">
                            <div class="platform-status-card {{ $integrations['xero'] ? 'connected' : 'disconnected' }}">
                                <div class="platform-header">
                                    <div class="platform-info">
                                        <div class="platform-icon xero">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="platform-name">Xero</h5>
                                            <p class="platform-description">Cloud accounting platform</p>
                                        </div>
                                    </div>
                                    <div class="status-indicator">
                                        @if(isset($integrations['xero']) && $integrations['xero'])
                                            <span class="badge bg-success">Connected</span>
                                        @else
                                            <span class="badge bg-secondary">Not Connected</span>
                                        @endif
                                    </div>
                                </div>
                                
                                @if(isset($integrations['xero']) && $integrations['xero'])
                                    <div class="connection-details">
                                        <div class="detail-item">
                                            <span class="detail-label">Connected Since:</span>
                                            <span class="detail-value">{{ $integrations['xero']->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Last Sync:</span>
                                            <span class="detail-value">
                                                {{ $integrations['xero']->last_sync_at ? $integrations['xero']->last_sync_at->diffForHumans() : 'Never' }}
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Status:</span>
                                            <span class="detail-value">
                                                @if($integrations['xero']->isExpired())
                                                    <span class="text-danger">Expired</span>
                                                @elseif($integrations['xero']->needsRefresh())
                                                    <span class="text-warning">Needs Refresh</span>
                                                @else
                                                    <span class="text-success">Active</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="action-buttons">
                                        <button class="btn btn-outline-info btn-sm" onclick="testConnection('xero')">
                                            <i class="fas fa-wifi me-1"></i>Test Connection
                                        </button>
                                        <button class="btn btn-outline-info btn-sm" onclick="syncData('xero')">
                                            <i class="fas fa-sync me-1"></i>Sync Now
                                        </button>
                                    </div>
                                @else
                                    <div class="connection-prompt">
                                        <p class="text-muted mb-3">Connect your Xero account to sync invoices and contacts.</p>
                                        <a href="{{ route('integrations.xero.setup') }}" class="btn btn-info">
                                            <i class="fas fa-plug me-2"></i>Connect Xero
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- SAP Business One Status -->
                        <div class="col-lg-6 col-md-12 mb-4">
                            <div class="platform-status-card {{ $integrations['sap'] ? 'connected' : 'disconnected' }}">
                                <div class="platform-header">
                                    <div class="platform-info">
                                        <div class="platform-icon sap">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M3.5 18.49l6-6.01 4 4L22 6.92l-1.41-1.41-7.09 7.97-4-4L2 16.99z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="platform-name">SAP Business One</h5>
                                            <p class="platform-description">Enterprise resource planning</p>
                                        </div>
                                    </div>
                                    <div class="status-indicator">
                                        @if(isset($integrations['sap']) && $integrations['sap'])
                                            <span class="badge bg-success">Connected</span>
                                        @else
                                            <span class="badge bg-secondary">Not Connected</span>
                                        @endif
                                    </div>
                                </div>
                                
                                @if(isset($integrations['sap']) && $integrations['sap'])
                                    <div class="connection-details">
                                        <div class="detail-item">
                                            <span class="detail-label">Connected Since:</span>
                                            <span class="detail-value">{{ $integrations['sap']->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Last Sync:</span>
                                            <span class="detail-value">
                                                {{ $integrations['sap']->last_sync_at ? $integrations['sap']->last_sync_at->diffForHumans() : 'Never' }}
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Service Layer:</span>
                                            <span class="detail-value">{{ $integrations['sap']->settings['service_layer_url'] ?? 'Not configured' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="action-buttons">
                                        <button class="btn btn-outline-success btn-sm" onclick="testConnection('sap')">
                                            <i class="fas fa-wifi me-1"></i>Test Connection
                                        </button>
                                        <button class="btn btn-outline-success btn-sm" onclick="syncData('sap')">
                                            <i class="fas fa-sync me-1"></i>Sync Now
                                        </button>
                                    </div>
                                @else
                                    <div class="connection-prompt">
                                        <p class="text-muted mb-3">Connect your SAP Business One system for enterprise integration.</p>
                                        <a href="{{ route('integrations.sap.setup') }}" class="btn btn-success">
                                            <i class="fas fa-plug me-2"></i>Connect SAP
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Microsoft Dynamics Status -->
                        <div class="col-lg-6 col-md-12 mb-4">
                            <div class="platform-status-card {{ $integrations['dynamics'] ? 'connected' : 'disconnected' }}">
                                <div class="platform-header">
                                    <div class="platform-info">
                                        <div class="platform-icon dynamics">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="platform-name">Microsoft Dynamics 365</h5>
                                            <p class="platform-description">Business applications platform</p>
                                        </div>
                                    </div>
                                    <div class="status-indicator">
                                        @if(isset($integrations['dynamics']) && $integrations['dynamics'])
                                            <span class="badge bg-success">Connected</span>
                                        @else
                                            <span class="badge bg-secondary">Not Connected</span>
                                        @endif
                                    </div>
                                </div>
                                
                                @if(isset($integrations['dynamics']) && $integrations['dynamics'])
                                    <div class="connection-details">
                                        <div class="detail-item">
                                            <span class="detail-label">Connected Since:</span>
                                            <span class="detail-value">{{ $integrations['dynamics']->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Last Sync:</span>
                                            <span class="detail-value">
                                                {{ $integrations['dynamics']->last_sync_at ? $integrations['dynamics']->last_sync_at->diffForHumans() : 'Never' }}
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Environment:</span>
                                            <span class="detail-value">{{ ucfirst($integrations['dynamics']->settings['environment'] ?? 'Unknown') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="action-buttons">
                                        <button class="btn btn-outline-primary btn-sm" onclick="testConnection('dynamics')">
                                            <i class="fas fa-wifi me-1"></i>Test Connection
                                        </button>
                                        <button class="btn btn-outline-primary btn-sm" onclick="syncData('dynamics')">
                                            <i class="fas fa-sync me-1"></i>Sync Now
                                        </button>
                                    </div>
                                @else
                                    <div class="connection-prompt">
                                        <p class="text-muted mb-3">Connect your Microsoft Dynamics 365 Business Central account.</p>
                                        <a href="{{ route('integrations.dynamics.setup') }}" class="btn btn-primary">
                                            <i class="fas fa-plug me-2"></i>Connect Dynamics
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Oracle NetSuite Status -->
                        <div class="col-lg-6 col-md-12 mb-4">
                            <div class="platform-status-card {{ $integrations['netsuite'] ? 'connected' : 'disconnected' }}">
                                <div class="platform-header">
                                    <div class="platform-info">
                                        <div class="platform-icon netsuite">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20 6h-2.18c.11-.31.18-.65.18-1a2.996 2.996 0 0 0-5.5-1.65l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="platform-name">Oracle NetSuite</h5>
                                            <p class="platform-description">Cloud ERP solution</p>
                                        </div>
                                    </div>
                                    <div class="status-indicator">
                                        @if(isset($integrations['netsuite']) && $integrations['netsuite'])
                                            <span class="badge bg-success">Connected</span>
                                        @else
                                            <span class="badge bg-secondary">Not Connected</span>
                                        @endif
                                    </div>
                                </div>
                                
                                @if(isset($integrations['netsuite']) && $integrations['netsuite'])
                                    <div class="connection-details">
                                        <div class="detail-item">
                                            <span class="detail-label">Connected Since:</span>
                                            <span class="detail-value">{{ $integrations['netsuite']->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Last Sync:</span>
                                            <span class="detail-value">
                                                {{ $integrations['netsuite']->last_sync_at ? $integrations['netsuite']->last_sync_at->diffForHumans() : 'Never' }}
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Account ID:</span>
                                            <span class="detail-value">{{ $integrations['netsuite']->settings['account_id'] ?? 'Not configured' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="action-buttons">
                                        <button class="btn btn-outline-warning btn-sm" onclick="testConnection('netsuite')">
                                            <i class="fas fa-wifi me-1"></i>Test Connection
                                        </button>
                                        <button class="btn btn-outline-warning btn-sm" onclick="syncData('netsuite')">
                                            <i class="fas fa-sync me-1"></i>Sync Now
                                        </button>
                                    </div>
                                @else
                                    <div class="connection-prompt">
                                        <p class="text-muted mb-3">Connect your Oracle NetSuite account for comprehensive ERP integration.</p>
                                        <a href="{{ route('integrations.netsuite.setup') }}" class="btn btn-warning">
                                            <i class="fas fa-plug me-2"></i>Connect NetSuite
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Integration Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-tools me-2"></i>
                                        Bulk Actions
                                    </h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button class="btn btn-outline-primary" onclick="testAllConnections()">
                                            <i class="fas fa-wifi me-2"></i>Test All Connections
                                        </button>
                                        <button class="btn btn-outline-success" onclick="syncAllData()">
                                            <i class="fas fa-sync me-2"></i>Sync All Data
                                        </button>
                                        <button class="btn btn-outline-info" onclick="refreshAllTokens()">
                                            <i class="fas fa-key me-2"></i>Refresh All Tokens
                                        </button>
                                        <button class="btn btn-outline-secondary" onclick="exportIntegrationLogs()">
                                            <i class="fas fa-download me-2"></i>Export Logs
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
</div>

<script>
function testConnection(platform) {
    // Implementation for testing connection
    alert('Testing connection to ' + platform + '...');
}

function syncData(platform) {
    // Implementation for syncing data
    alert('Syncing data from ' + platform + '...');
}

function refreshToken(platform) {
    // Implementation for refreshing token
    alert('Refreshing token for ' + platform + '...');
}

function testAllConnections() {
    // Implementation for testing all connections
    alert('Testing all connections...');
}

function syncAllData() {
    // Implementation for syncing all data
    alert('Syncing all data...');
}

function refreshAllTokens() {
    // Implementation for refreshing all tokens
    alert('Refreshing all tokens...');
}

function exportIntegrationLogs() {
    // Implementation for exporting logs
    alert('Exporting integration logs...');
}
</script>

<style>
.status-card {
    border-radius: 10px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.status-icon {
    font-size: 2rem;
    margin-right: 1rem;
}

.status-content h3 {
    margin: 0;
    font-size: 2rem;
    font-weight: bold;
}

.status-content p {
    margin: 0;
    opacity: 0.9;
}

.platform-status-card {
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 1.5rem;
    background: #fff;
    transition: all 0.3s ease;
}

.platform-status-card.connected {
    border-left: 4px solid #28a745;
}

.platform-status-card.disconnected {
    border-left: 4px solid #6c757d;
}

.platform-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.platform-info {
    display: flex;
    align-items: center;
}

.platform-icon {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: white;
}

.platform-icon.quickbooks { background: #2CA01C; }
.platform-icon.xero { background: #13B5EA; }
.platform-icon.sap { background: #003366; }
.platform-icon.dynamics { background: #0078D4; }
.platform-icon.netsuite { background: #FF6600; }

.platform-name {
    margin: 0;
    font-weight: 600;
    color: #495057;
}

.platform-description {
    margin: 0;
    color: #6c757d;
    font-size: 0.875rem;
}

.connection-details {
    background: #f8f9fa;
    border-radius: 6px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.detail-item:last-child {
    margin-bottom: 0;
}

.detail-label {
    font-weight: 500;
    color: #495057;
}

.detail-value {
    color: #6c757d;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.connection-prompt {
    text-align: center;
    padding: 1rem;
}

.progress {
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn {
    border-radius: 6px;
    font-weight: 500;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}
</style>
@endsection 