<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Warehouse;
use App\Models\Shipment;
use App\Models\Analytics;

class EnterpriseController extends Controller
{
    public function inventoryManagement()
    {
        $inventory = Inventory::with(['product', 'warehouse'])
            ->where('business_id', Auth::user()->activeBusiness->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $lowStock = Inventory::with(['product', 'warehouse'])
            ->where('business_id', Auth::user()->activeBusiness->id)
            ->where('quantity', '<=', DB::raw('reorder_level'))
            ->get();

        $totalValue = Inventory::where('business_id', Auth::user()->activeBusiness->id)
            ->join('products', 'inventory.product_id', '=', 'products.id')
            ->selectRaw('SUM(inventory.quantity * products.price) as total_value')
            ->first();

        return view('user.enterprise.inventory', compact('inventory', 'lowStock', 'totalValue'));
    }

    public function warehouseManagement()
    {
        $warehouses = Warehouse::where('business_id', Auth::user()->activeBusiness->id)
            ->withCount(['inventory as total_items', 'inventory as total_value' => function($query) {
                $query->join('products', 'inventory.product_id', '=', 'products.id')
                      ->selectRaw('SUM(inventory.quantity * products.price)');
            }])
            ->get();

        $warehouseUtilization = Warehouse::where('business_id', Auth::user()->activeBusiness->id)
            ->with(['inventory' => function($query) {
                $query->join('products', 'inventory.product_id', '=', 'products.id')
                      ->select('inventory.*', DB::raw('inventory.quantity * products.price as item_value'));
            }])
            ->get();

        return view('user.enterprise.warehouse', compact('warehouses', 'warehouseUtilization'));
    }

    public function shippingTracking()
    {
        $shipments = Shipment::where('business_id', Auth::user()->activeBusiness->id)
            ->with(['order', 'carrier'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $trackingStats = Shipment::where('business_id', Auth::user()->activeBusiness->id)
            ->selectRaw('
                status,
                COUNT(*) as count,
                AVG(DATEDIFF(updated_at, created_at)) as avg_days
            ')
            ->groupBy('status')
            ->get();

        return view('user.enterprise.shipping', compact('shipments', 'trackingStats'));
    }

    public function reportsAnalytics()
    {
        $businessId = Auth::user()->activeBusiness->id;
        
        // Sales Analytics
        $salesData = DB::table('invoices')
            ->where('business_id', $businessId)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->selectRaw('
                DATE(created_at) as date,
                COUNT(*) as total_invoices,
                SUM(total_amount) as total_sales,
                AVG(total_amount) as avg_order_value
            ')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Inventory Analytics
        $inventoryData = Inventory::where('business_id', $businessId)
            ->join('products', 'inventory.product_id', '=', 'products.id')
            ->selectRaw('
                products.name,
                inventory.quantity,
                inventory.reorder_level,
                (inventory.quantity * products.price) as stock_value
            ')
            ->orderBy('stock_value', 'desc')
            ->limit(10)
            ->get();

        // Warehouse Analytics
        $warehouseData = Warehouse::where('business_id', $businessId)
            ->withCount(['inventory as total_items'])
            ->withSum(['inventory as total_value' => function($query) {
                $query->join('products', 'inventory.product_id', '=', 'products.id')
                      ->selectRaw('inventory.quantity * products.price');
            }])
            ->get();

        // Customer Analytics
        $customerData = DB::table('invoices')
            ->where('business_id', $businessId)
            ->whereBetween('created_at', [now()->subMonths(6), now()])
            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->selectRaw('
                customers.name,
                COUNT(*) as total_orders,
                SUM(invoices.total_amount) as total_spent,
                AVG(invoices.total_amount) as avg_order_value
            ')
            ->groupBy('customers.id', 'customers.name')
            ->orderBy('total_spent', 'desc')
            ->limit(10)
            ->get();

        return view('user.enterprise.analytics', compact(
            'salesData', 
            'inventoryData', 
            'warehouseData', 
            'customerData'
        ));
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:sales,inventory,warehouse,customer,shipping',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after:date_from',
            'format' => 'required|in:pdf,excel,csv',
        ]);

        $businessId = Auth::user()->activeBusiness->id;
        $reportType = $request->input('report_type');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $format = $request->input('format');

        $data = $this->getReportData($reportType, $businessId, $dateFrom, $dateTo);

        // Store report generation in analytics
        Analytics::create([
            'business_id' => $businessId,
            'report_type' => $reportType,
            'generated_at' => now(),
            'parameters' => json_encode([
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'format' => $format
            ])
        ]);

        return response()->json([
            'success' => true,
            'data' => $data,
            'download_url' => route('reports.download', [
                'type' => $reportType,
                'from' => $dateFrom,
                'to' => $dateTo,
                'format' => $format
            ])
        ]);
    }

    private function getReportData($type, $businessId, $dateFrom, $dateTo)
    {
        switch ($type) {
            case 'sales':
                return DB::table('invoices')
                    ->where('business_id', $businessId)
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->selectRaw('
                        DATE(created_at) as date,
                        COUNT(*) as total_invoices,
                        SUM(total_amount) as total_sales,
                        AVG(total_amount) as avg_order_value,
                        SUM(tax_amount) as total_tax,
                        SUM(discount_amount) as total_discount
                    ')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();

            case 'inventory':
                return Inventory::where('business_id', $businessId)
                    ->join('products', 'inventory.product_id', '=', 'products.id')
                    ->selectRaw('
                        products.name,
                        products.sku,
                        inventory.quantity,
                        inventory.reorder_level,
                        products.price,
                        (inventory.quantity * products.price) as stock_value,
                        CASE 
                            WHEN inventory.quantity <= inventory.reorder_level THEN "Low Stock"
                            WHEN inventory.quantity = 0 THEN "Out of Stock"
                            ELSE "In Stock"
                        END as status
                    ')
                    ->orderBy('stock_value', 'desc')
                    ->get();

            case 'warehouse':
                return Warehouse::where('business_id', $businessId)
                    ->with(['inventory' => function($query) {
                        $query->join('products', 'inventory.product_id', '=', 'products.id')
                              ->select('inventory.*', 'products.name', 'products.price');
                    }])
                    ->get();

            case 'customer':
                return DB::table('invoices')
                    ->where('business_id', $businessId)
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->join('customers', 'invoices.customer_id', '=', 'customers.id')
                    ->selectRaw('
                        customers.name,
                        customers.email,
                        customers.phone,
                        COUNT(*) as total_orders,
                        SUM(invoices.total_amount) as total_spent,
                        AVG(invoices.total_amount) as avg_order_value,
                        MAX(invoices.created_at) as last_order_date
                    ')
                    ->groupBy('customers.id', 'customers.name', 'customers.email', 'customers.phone')
                    ->orderBy('total_spent', 'desc')
                    ->get();

            case 'shipping':
                return Shipment::where('business_id', $businessId)
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->with(['order', 'carrier'])
                    ->selectRaw('
                        tracking_number,
                        status,
                        carrier_id,
                        created_at,
                        updated_at,
                        DATEDIFF(updated_at, created_at) as delivery_days
                    ')
                    ->orderBy('created_at', 'desc')
                    ->get();

            default:
                return collect();
        }
    }

    public function downloadReport(Request $request)
    {
        $request->validate([
            'type' => 'required|in:sales,inventory,warehouse,customer,shipping',
            'from' => 'required|date',
            'to' => 'required|date',
            'format' => 'required|in:pdf,excel,csv',
        ]);

        $businessId = Auth::user()->activeBusiness->id;
        $data = $this->getReportData(
            $request->input('type'),
            $businessId,
            $request->input('from'),
            $request->input('to')
        );

        $filename = $request->input('type') . '_report_' . 
                   $request->input('from') . '_to_' . 
                   $request->input('to') . '.' . 
                   $request->input('format');

        // Generate file based on format
        switch ($request->input('format')) {
            case 'pdf':
                return $this->generatePDF($data, $filename);
            case 'excel':
                return $this->generateExcel($data, $filename);
            case 'csv':
                return $this->generateCSV($data, $filename);
            default:
                abort(400, 'Unsupported format');
        }
    }

    private function generatePDF($data, $filename)
    {
        // Implementation for PDF generation
        // You would use a library like DomPDF or Snappy
        return response()->json(['message' => 'PDF generation not implemented yet']);
    }

    private function generateExcel($data, $filename)
    {
        // Implementation for Excel generation
        // You would use a library like PhpSpreadsheet
        return response()->json(['message' => 'Excel generation not implemented yet']);
    }

    private function generateCSV($data, $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            if ($data->count() > 0) {
                // Write headers
                fputcsv($file, array_keys((array) $data->first()));
                
                // Write data
                foreach ($data as $row) {
                    fputcsv($file, (array) $row);
                }
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 