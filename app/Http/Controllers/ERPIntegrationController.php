<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\IntegrationSetting;

class ERPIntegrationController extends Controller
{
    /**
     * Show integrations dashboard
     */
    public function index()
    {
        $integrations = $this->getUserIntegrations();
        
        // Ensure integrations is always an array
        if (!is_array($integrations)) {
            $integrations = [
                'quickbooks' => null,
                'sap' => null,
                'xero' => null,
                'dynamics' => null,
                'netsuite' => null,
            ];
        }
        
        return view('integrations.index', compact('integrations'));
    }

    /**
     * Show integration instructions
     */
    public function instructions()
    {
        return view('integrations.instructions');
    }

    /**
     * Show integration status
     */
    public function status()
    {
        $integrations = $this->getUserIntegrations();
        $integrationsCollection = collect($integrations);
        $connectedCount = $integrationsCollection->filter()->count();
        $totalCount = $integrationsCollection->count();
        
        return view('integrations.status', compact('integrations', 'connectedCount', 'totalCount'));
    }

    /**
     * QuickBooks setup page
     */
    public function quickbooksSetup()
    {
        return view('integrations.quickbooks.setup');
    }

    /**
     * Connect to QuickBooks (initiate OAuth)
     */
    public function connectQuickbooks(Request $request)
    {
        $request->validate([
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'environment' => 'required|in:sandbox,production'
        ]);

        // Store credentials temporarily for OAuth flow
        session([
            'quickbooks_client_id' => $request->client_id,
            'quickbooks_client_secret' => $request->client_secret,
            'quickbooks_environment' => $request->environment
        ]);

        // Build OAuth URL
        $baseUrl = $request->environment === 'sandbox' 
            ? 'https://sandbox-accounts.platform.intuit.com' 
            : 'https://accounts.platform.intuit.com';

        $authUrl = $baseUrl . '/oauth2/v1/authorize?' . http_build_query([
            'client_id' => $request->client_id,
            'response_type' => 'code',
            'scope' => 'com.intuit.quickbooks.accounting',
            'redirect_uri' => route('integrations.quickbooks.callback'),
            'state' => csrf_token()
        ]);

        return response()->json([
            'success' => true,
            'auth_url' => $authUrl
        ]);
    }

    /**
     * QuickBooks OAuth callback
     */
    public function quickbooksCallback(Request $request)
    {
        if ($request->has('error')) {
            return redirect()->route('integrations.quickbooks.setup')
                ->with('error', 'QuickBooks authorization failed: ' . $request->error);
        }

        $code = $request->code;
        $realmId = $request->realmId;

        // Get stored credentials
        $clientId = session('quickbooks_client_id');
        $clientSecret = session('quickbooks_client_secret');
        $environment = session('quickbooks_environment');

        if (!$clientId || !$clientSecret) {
            return redirect()->route('integrations.quickbooks.setup')
                ->with('error', 'QuickBooks credentials not found. Please try again.');
        }

        // Exchange code for tokens
        $baseUrl = $environment === 'sandbox' 
            ? 'https://sandbox-accounts.platform.intuit.com' 
            : 'https://accounts.platform.intuit.com';

        $response = Http::post($baseUrl . '/oauth2/v1/tokens/bearer', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => route('integrations.quickbooks.callback')
        ], [
            'Authorization' => 'Basic ' . base64_encode($clientId . ':' . $clientSecret),
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]);

        if ($response->successful()) {
            $tokens = $response->json();
            $this->saveQuickbooksConnection($tokens, $realmId, $environment);
            
            // Clear session data
            session()->forget(['quickbooks_client_id', 'quickbooks_client_secret', 'quickbooks_environment']);
            
            return redirect()->route('integrations.index')
                ->with('success', 'QuickBooks connected successfully!');
        }

        return redirect()->route('integrations.quickbooks.setup')
            ->with('error', 'Failed to connect to QuickBooks. Please try again.');
    }

    /**
     * Xero setup page
     */
    public function xeroSetup()
    {
        return view('integrations.xero.setup');
    }

    /**
     * Connect to Xero (initiate OAuth)
     */
    public function connectXero(Request $request)
    {
        $request->validate([
            'client_id' => 'required|string',
            'client_secret' => 'required|string'
        ]);

        // Store credentials temporarily
        session([
            'xero_client_id' => $request->client_id,
            'xero_client_secret' => $request->client_secret
        ]);

        // Build OAuth URL
        $authUrl = 'https://login.xero.com/identity/connect/authorize?' . http_build_query([
            'response_type' => 'code',
            'client_id' => $request->client_id,
            'redirect_uri' => route('integrations.xero.callback'),
            'scope' => 'offline_access accounting.transactions accounting.contacts accounting.settings',
            'state' => csrf_token()
        ]);

        return response()->json([
            'success' => true,
            'auth_url' => $authUrl
        ]);
    }

    /**
     * Xero OAuth callback
     */
    public function xeroCallback(Request $request)
    {
        if ($request->has('error')) {
            return redirect()->route('integrations.xero.setup')
                ->with('error', 'Xero authorization failed: ' . $request->error);
        }

        $code = $request->code;

        // Get stored credentials
        $clientId = session('xero_client_id');
        $clientSecret = session('xero_client_secret');

        if (!$clientId || !$clientSecret) {
            return redirect()->route('integrations.xero.setup')
                ->with('error', 'Xero credentials not found. Please try again.');
        }

        // Exchange code for tokens
        $response = Http::post('https://identity.xero.com/connect/token', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => route('integrations.xero.callback')
        ], [
            'Authorization' => 'Basic ' . base64_encode($clientId . ':' . $clientSecret),
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]);

        if ($response->successful()) {
            $tokens = $response->json();
            $this->saveXeroConnection($tokens);
            
            // Clear session data
            session()->forget(['xero_client_id', 'xero_client_secret']);
            
            return redirect()->route('integrations.index')
                ->with('success', 'Xero connected successfully!');
        }

        return redirect()->route('integrations.xero.setup')
            ->with('error', 'Failed to connect to Xero. Please try again.');
    }

    /**
     * SAP Business One setup page
     */
    public function sapSetup()
    {
        return view('integrations.sap.setup');
    }

    /**
     * Connect to SAP Business One
     */
    public function connectSAP(Request $request)
    {
        $request->validate([
            'server_url' => 'required|url',
            'company_db' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'language' => 'required|integer',
            'timeout' => 'required|integer|min:10|max:300'
        ]);

        try {
            // Test connection
            $response = Http::timeout($request->timeout)->post($request->server_url . '/Login', [
                'CompanyDB' => $request->company_db,
                'UserName' => $request->username,
                'Password' => $request->password,
                'Language' => $request->language
            ]);

            if ($response->successful()) {
                $this->saveSAPConnection($request->all());
                return response()->json(['success' => true]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to connect to SAP Business One. Please check your credentials.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Microsoft Dynamics setup page
     */
    public function dynamicsSetup()
    {
        return view('integrations.dynamics.setup');
    }

    /**
     * Connect to Microsoft Dynamics 365
     */
    public function connectDynamics(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|string',
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'environment' => 'required|in:sandbox,production'
        ]);

        // Store for OAuth flow
        session([
            'dynamics_tenant_id' => $request->tenant_id,
            'dynamics_client_id' => $request->client_id,
            'dynamics_client_secret' => $request->client_secret,
            'dynamics_environment' => $request->environment
        ]);

        // Build OAuth URL
        $authUrl = 'https://login.microsoftonline.com/' . $request->tenant_id . '/oauth2/v2.0/authorize?' . http_build_query([
            'client_id' => $request->client_id,
            'response_type' => 'code',
            'redirect_uri' => route('integrations.dynamics.callback'),
            'scope' => 'https://org.crm.dynamics.com/.default offline_access',
            'state' => csrf_token()
        ]);

        return response()->json([
            'success' => true,
            'auth_url' => $authUrl
        ]);
    }

    /**
     * Oracle NetSuite setup page
     */
    public function netsuiteSetup()
    {
        return view('integrations.netsuite.setup');
    }

    /**
     * Connect to Oracle NetSuite
     */
    public function connectNetSuite(Request $request)
    {
        $request->validate([
            'account_id' => 'required|string',
            'consumer_key' => 'required|string',
            'consumer_secret' => 'required|string',
            'token_id' => 'required|string',
            'token_secret' => 'required|string',
            'environment' => 'required|in:sandbox,production',
            'api_version' => 'required|string',
            'timeout' => 'required|integer|min:30|max:300'
        ]);

        try {
            $this->saveNetSuiteConnection($request->all());
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save NetSuite connection: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Fetch QuickBooks customers
     */
    public function fetchQuickbooksCustomers()
    {
        $connection = $this->getQuickbooksConnection();
        if (!$connection) {
            return response()->json(['success' => false, 'message' => 'QuickBooks not connected']);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $connection['access_token'],
                'Accept' => 'application/json'
            ])->get('https://sandbox-accounts.platform.intuit.com/v3/company/' . $connection['realm_id'] . '/query?query=SELECT * FROM Customer MAXRESULTS 10');

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'customers' => $response->json()['QueryResponse']['Customer'] ?? []
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Failed to fetch customers']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Fetch QuickBooks vendors
     */
    public function fetchQuickbooksVendors()
    {
        $connection = $this->getQuickbooksConnection();
        if (!$connection) {
            return response()->json(['success' => false, 'message' => 'QuickBooks not connected']);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $connection['access_token'],
                'Accept' => 'application/json'
            ])->get('https://sandbox-accounts.platform.intuit.com/v3/company/' . $connection['realm_id'] . '/query?query=SELECT * FROM Vendor MAXRESULTS 10');

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'vendors' => $response->json()['QueryResponse']['Vendor'] ?? []
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Failed to fetch vendors']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Fetch QuickBooks items
     */
    public function fetchQuickbooksItems()
    {
        $connection = $this->getQuickbooksConnection();
        if (!$connection) {
            return response()->json(['success' => false, 'message' => 'QuickBooks not connected']);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $connection['access_token'],
                'Accept' => 'application/json'
            ])->get('https://sandbox-accounts.platform.intuit.com/v3/company/' . $connection['realm_id'] . '/query?query=SELECT * FROM Item MAXRESULTS 10');

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'items' => $response->json()['QueryResponse']['Item'] ?? []
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Failed to fetch items']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Post invoice to QuickBooks
     */
    public function postInvoiceToQuickbooks(Request $request)
    {
        $connection = $this->getQuickbooksConnection();
        if (!$connection) {
            return response()->json(['success' => false, 'message' => 'QuickBooks not connected']);
        }

        try {
            $invoiceData = $request->all();
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $connection['access_token'],
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->post('https://sandbox-accounts.platform.intuit.com/v3/company/' . $connection['realm_id'] . '/invoice', $invoiceData);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'invoice' => $response->json()['Invoice']
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Failed to post invoice']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Fetch QuickBooks data by type
     */
    public function fetchQuickbooksData($type)
    {
        try {
            $connection = $this->getQuickbooksConnection();
            if (!$connection) {
                return response()->json(['success' => false, 'message' => 'QuickBooks not connected']);
            }

            switch ($type) {
                case 'customers':
                    return $this->fetchQuickbooksCustomers();
                case 'vendors':
                    return $this->fetchQuickbooksVendors();
                case 'items':
                    return $this->fetchQuickbooksItems();
                default:
                    return response()->json(['success' => false, 'message' => 'Invalid data type']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Get user integrations
     */
    private function getUserIntegrations()
    {
        $userId = Auth::id();
        
        $integrations = IntegrationSetting::where('user_id', $userId)
            ->active()
            ->get();
        
        // Ensure we have a collection, even if empty
        if (!$integrations) {
            $integrations = collect();
        }
        
        $integrations = $integrations->keyBy('platform');
        
        return [
            'quickbooks' => $integrations->get('quickbooks'),
            'sap' => $integrations->get('sap'),
            'xero' => $integrations->get('xero'),
            'dynamics' => $integrations->get('dynamics'),
            'netsuite' => $integrations->get('netsuite'),
        ];
    }

    /**
     * Save QuickBooks connection
     */
    private function saveQuickbooksConnection($tokens, $realmId, $environment)
    {
        $userId = Auth::id();
        
        IntegrationSetting::updateOrCreate(
            [
                'user_id' => $userId,
                'platform' => 'quickbooks'
            ],
            [
                'name' => 'QuickBooks Online',
                'credentials' => [
                    'access_token' => $tokens['access_token'],
                    'refresh_token' => $tokens['refresh_token'],
                    'realm_id' => $realmId,
                ],
                'settings' => [
                    'environment' => $environment,
                ],
                'expires_at' => now()->addSeconds($tokens['expires_in']),
                'is_active' => true,
            ]
        );
    }

    /**
     * Save Xero connection
     */
    private function saveXeroConnection($tokens)
    {
        $userId = Auth::id();
        
        IntegrationSetting::updateOrCreate(
            [
                'user_id' => $userId,
                'platform' => 'xero'
            ],
            [
                'name' => 'Xero',
                'credentials' => [
                    'access_token' => $tokens['access_token'],
                    'refresh_token' => $tokens['refresh_token'],
                ],
                'settings' => [
                    'tenant_id' => $tokens['tenant_id'] ?? null,
                ],
                'expires_at' => now()->addSeconds($tokens['expires_in']),
                'is_active' => true,
            ]
        );
    }

    /**
     * Save SAP connection
     */
    private function saveSAPConnection($data)
    {
        $userId = Auth::id();
        
        IntegrationSetting::updateOrCreate(
            [
                'user_id' => $userId,
                'platform' => 'sap'
            ],
            [
                'name' => 'SAP Business One',
                'credentials' => [
                    'server_url' => $data['server_url'],
                    'company_db' => $data['company_db'],
                    'username' => $data['username'],
                    'password' => $data['password'],
                ],
                'settings' => [
                    'language' => $data['language'],
                    'timeout' => $data['timeout'],
                ],
                'is_active' => true,
            ]
        );
    }

    /**
     * Save NetSuite connection
     */
    private function saveNetSuiteConnection($data)
    {
        $userId = Auth::id();
        
        IntegrationSetting::updateOrCreate(
            [
                'user_id' => $userId,
                'platform' => 'netsuite'
            ],
            [
                'name' => 'Oracle NetSuite',
                'credentials' => [
                    'account_id' => $data['account_id'],
                    'consumer_key' => $data['consumer_key'],
                    'consumer_secret' => $data['consumer_secret'],
                    'token_id' => $data['token_id'],
                    'token_secret' => $data['token_secret'],
                ],
                'settings' => [
                    'environment' => $data['environment'],
                    'api_version' => $data['api_version'],
                    'timeout' => $data['timeout'],
                ],
                'is_active' => true,
            ]
        );
    }

    /**
     * Get QuickBooks connection
     */
    private function getQuickbooksConnection()
    {
        $userId = Auth::id();
        $integration = IntegrationSetting::where('user_id', $userId)
            ->byPlatform('quickbooks')
            ->active()
            ->first();
            
        return $integration ? $integration->credentials : null;
    }

    /**
     * NetSuite OAuth callback
     */
    public function netsuiteCallback(Request $request)
    {
        // Handle NetSuite OAuth callback if needed
        return redirect()->route('integrations.index')
            ->with('success', 'NetSuite connected successfully!');
    }
} 