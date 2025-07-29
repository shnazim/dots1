<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DocumentTemplateExport;
use App\Models\Invoice;
use App\Models\Quotation;
use App\Models\Estimate;
use App\Models\PurchaseOrder;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Item;
use App\Models\DocumentTemplate;
use Carbon\Carbon;
use ZipArchive;

class DocumentController extends Controller
{
    /**
     * Show invoice creation form
     */
    public function createInvoice()
    {
        $templates = $this->getTemplates();
        return view('documents.invoice.create', compact('templates'));
    }

    /**
     * Show quotation creation form
     */
    public function createQuotation()
    {
        $templates = $this->getTemplates();
        return view('documents.quotation.create', compact('templates'));
    }

    /**
     * Show estimate creation form
     */
    public function createEstimate()
    {
        $templates = $this->getTemplates();
        return view('documents.estimate.create', compact('templates'));
    }

    /**
     * Show purchase order creation form
     */
    public function createPO()
    {
        $templates = $this->getTemplates();
        return view('documents.po.create', compact('templates'));
    }

    /**
     * Show batch invoice generation
     */
    public function batchInvoices()
    {
        try {
            return view('documents.invoice.batch');
        } catch (\Exception $e) {
            Log::error('Error loading batch invoice view: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load batch invoice page. Please try again.');
        }
    }

    /**
     * Show batch quotation generation
     */
    public function batchQuotations()
    {
        try {
            return view('documents.quotation.batch');
        } catch (\Exception $e) {
            Log::error('Error loading batch quotation view: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load batch quotation page. Please try again.');
        }
    }

    /**
     * Show batch estimate generation
     */
    public function batchEstimates()
    {
        try {
            return view('documents.estimate.batch');
        } catch (\Exception $e) {
            Log::error('Error loading batch estimate view: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load batch estimate page. Please try again.');
        }
    }

    /**
     * Show batch purchase order generation
     */
    public function batchPOs()
    {
        try {
            return view('documents.po.batch');
        } catch (\Exception $e) {
            Log::error('Error loading batch PO view: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load batch PO page. Please try again.');
        }
    }

    /**
     * Store invoice (redirects to login if not authenticated)
     */
    public function storeInvoice(Request $request)
    {
        if (!Auth::check()) {
            // Store form data in session for after login
            $request->session()->put('pending_document', [
                'type' => 'invoice',
                'data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'redirect' => route('login'),
                'message' => 'Please login to save your invoice'
            ]);
        }

        try {
            // User is authenticated, process the invoice
            $invoice = $this->processInvoice($request);
            
            return response()->json([
                'success' => true,
                'message' => 'Invoice created successfully!',
                'download_url' => route('documents.download', $invoice->id)
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating invoice: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating invoice. Please try again.'
            ]);
        }
    }

    /**
     * Store quotation (redirects to login if not authenticated)
     */
    public function storeQuotation(Request $request)
    {
        if (!Auth::check()) {
            $request->session()->put('pending_document', [
                'type' => 'quotation',
                'data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'redirect' => route('login'),
                'message' => 'Please login to save your quotation'
            ]);
        }

        try {
            $quotation = $this->processQuotation($request);
            
            return response()->json([
                'success' => true,
                'message' => 'Quotation created successfully!',
                'download_url' => route('documents.download', $quotation->id)
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating quotation: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating quotation. Please try again.'
            ]);
        }
    }

    /**
     * Store estimate (redirects to login if not authenticated)
     */
    public function storeEstimate(Request $request)
    {
        if (!Auth::check()) {
            $request->session()->put('pending_document', [
                'type' => 'estimate',
                'data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'redirect' => route('login'),
                'message' => 'Please login to save your estimate'
            ]);
        }

        try {
            $estimate = $this->processEstimate($request);
            
            return response()->json([
                'success' => true,
                'message' => 'Estimate created successfully!',
                'download_url' => route('documents.download', $estimate->id)
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating estimate: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating estimate. Please try again.'
            ]);
        }
    }

    /**
     * Store purchase order (redirects to login if not authenticated)
     */
    public function storePO(Request $request)
    {
        if (!Auth::check()) {
            $request->session()->put('pending_document', [
                'type' => 'po',
                'data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'redirect' => route('login'),
                'message' => 'Please login to save your purchase order'
            ]);
        }

        try {
            $po = $this->processPO($request);
            
            return response()->json([
                'success' => true,
                'message' => 'Purchase Order created successfully!',
                'download_url' => route('documents.download', $po->id)
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating PO: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating purchase order. Please try again.'
            ]);
        }
    }

    /**
     * Download template for batch upload
     */
    public function downloadTemplate($type)
    {
        try {
            $filename = $type . '_template.xlsx';
            
            // Create template data based on type
            $data = $this->getTemplateData($type);
            
            return Excel::download(new DocumentTemplateExport($data), $filename);
        } catch (\Exception $e) {
            Log::error('Error downloading template: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to download template. Please try again.');
        }
    }

    /**
     * Process batch upload
     */
    public function processBatchUpload(Request $request, $type)
    {
        // Temporarily remove authentication check for testing
        // if (!Auth::check()) {
        //     return response()->json([
        //         'success' => false,
        //         'redirect' => route('login'),
        //         'message' => 'Please login to process batch upload'
        //     ]);
        // }

        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:10240'
        ]);

        try {
            Log::info('Starting batch upload processing for type: ' . $type);
            
            if (!$request->hasFile('excel_file')) {
                Log::error('No file uploaded');
                return response()->json([
                    'success' => false,
                    'message' => 'No file uploaded'
                ]);
            }
            
            $file = $request->file('excel_file');
            Log::info('File uploaded: ' . $file->getClientOriginalName());
            
            $data = Excel::toArray([], $file)[0];
            Log::info('Excel data loaded, rows: ' . count($data));
            
            // Process data without database operations for now
            $documents = $this->processExcelDataSimple($data, $type);
            Log::info('Documents processed: ' . count($documents));
            
            return response()->json([
                'success' => true,
                'documents' => $documents,
                'count' => count($documents)
            ]);
        } catch (\Exception $e) {
            Log::error('Error processing batch upload: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error processing file: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Generate batch documents
     */
    public function generateBatchDocuments(Request $request, $type)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'redirect' => route('login'),
                'message' => 'Please login to generate documents'
            ]);
        }

        try {
            $data = $request->input('documents', []);
            $generatedDocuments = [];
            $errors = [];

            foreach ($data as $index => $documentData) {
                try {
                    $document = $this->generateDocument($documentData, $type);
                    $generatedDocuments[] = $document;
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 1) . ": " . $e->getMessage();
                }
            }

            // Create ZIP file if multiple documents
            $zipUrl = null;
            if (count($generatedDocuments) > 1) {
                $zipUrl = $this->createZipFile($generatedDocuments, $type);
            }

            return response()->json([
                'success' => true,
                'documents' => $generatedDocuments,
                'zip_url' => $zipUrl,
                'errors' => $errors,
                'total' => count($data),
                'successful' => count($generatedDocuments)
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating batch documents: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error generating documents: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Download document
     */
    public function downloadDocument($id)
    {
        try {
            // Find document by ID (implement based on your models)
            $document = $this->findDocument($id);
            
            if (!$document) {
                return response()->json([
                    'success' => false,
                    'message' => 'Document not found'
                ]);
            }

            // Generate PDF and return download
            $pdfPath = $this->generatePDF($document);
            
            return response()->download($pdfPath);
        } catch (\Exception $e) {
            Log::error('Error downloading document: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error downloading document'
            ]);
        }
    }

    /**
     * Get available templates
     */
    private function getTemplates()
    {
        return [
            [
                'id' => 1,
                'name' => 'Professional Template',
                'preview' => 'template1.png'
            ],
            [
                'id' => 2,
                'name' => 'Modern Template',
                'preview' => 'template2.png'
            ],
            [
                'id' => 3,
                'name' => 'Classic Template',
                'preview' => 'template3.png'
            ]
        ];
    }

    /**
     * Get template data for Excel export
     */
    private function getTemplateData($type)
    {
        $headers = [];
        $sampleData = [];

        switch ($type) {
            case 'invoice':
                $headers = [
                    'Customer Name*', 'Customer Email*', 'Customer Phone', 'Customer Address',
                    'Invoice Date*', 'Due Date*', 'Invoice Number', 'PO/SO Number',
                    'Item Description*', 'Quantity*', 'Unit Price*', 'Tax Rate (%)', 'Notes'
                ];
                $sampleData = [
                    [
                        'John Doe', 'john@example.com', '+1234567890', '123 Main St, City, State',
                        date('Y-m-d'), date('Y-m-d', strtotime('+30 days')), 'INV-001', 'PO-001',
                        'Web Development Services', '1', '5000.00', '10', 'Professional web development'
                    ]
                ];
                break;

            case 'quotation':
                $headers = [
                    'Customer Name*', 'Customer Email*', 'Customer Phone', 'Customer Address',
                    'Quotation Date*', 'Valid Until*', 'Quotation Number', 'PO/SO Number',
                    'Item Description*', 'Quantity*', 'Unit Price*', 'Tax Rate (%)', 'Notes'
                ];
                $sampleData = [
                    [
                        'Jane Smith', 'jane@example.com', '+1234567890', '456 Oak St, City, State',
                        date('Y-m-d'), date('Y-m-d', strtotime('+30 days')), 'QT-001', 'SO-001',
                        'Consulting Services', '1', '3000.00', '10', 'Business consulting'
                    ]
                ];
                break;

            case 'estimate':
                $headers = [
                    'Customer Name*', 'Customer Email*', 'Customer Phone', 'Customer Address',
                    'Estimate Date*', 'Valid Until*', 'Project Name*', 'Estimate Number',
                    'Item Description*', 'Quantity*', 'Unit Price*', 'Tax Rate (%)', 'Notes'
                ];
                $sampleData = [
                    [
                        'Bob Johnson', 'bob@example.com', '+1234567890', '789 Pine St, City, State',
                        date('Y-m-d'), date('Y-m-d', strtotime('+30 days')), 'Website Redesign', 'EST-001',
                        'Design Services', '1', '2500.00', '10', 'Website redesign project'
                    ]
                ];
                break;

            case 'po':
                $headers = [
                    'Vendor Name*', 'Vendor Email*', 'Vendor Phone', 'Vendor Address',
                    'PO Date*', 'Expected Delivery*', 'PO Number*', 'Delivery Address',
                    'Item Description*', 'Quantity*', 'Unit Price*', 'Tax Rate (%)', 'Notes'
                ];
                $sampleData = [
                    [
                        'ABC Supplies', 'contact@abcsupplies.com', '+1234567890', '321 Supply St, City, State',
                        date('Y-m-d'), date('Y-m-d', strtotime('+7 days')), 'PO-001', '123 Main St, City, State',
                        'Office Supplies', '100', '5.00', '10', 'Monthly office supplies'
                    ]
                ];
                break;
        }

        return array_merge([$headers], $sampleData);
    }

    /**
     * Process Excel data (simple version without database)
     */
    private function processExcelDataSimple($data, $type)
    {
        $documents = [];
        $headers = array_shift($data); // Remove header row

        foreach ($data as $row) {
            if (empty(array_filter($row))) continue; // Skip empty rows

            $document = [];
            foreach ($headers as $index => $header) {
                $document[strtolower(str_replace([' ', '*'], ['_', ''], $header))] = $row[$index] ?? '';
            }

            // Add type-specific processing
            switch ($type) {
                case 'invoice':
                    $document['type'] = 'invoice';
                    $document['invoice_number'] = $document['invoice_number'] ?: 'INV-' . date('Y') . '-' . str_pad(count($documents) + 1, 4, '0', STR_PAD_LEFT);
                    break;
                case 'quotation':
                    $document['type'] = 'quotation';
                    $document['quotation_number'] = $document['quotation_number'] ?: 'QT-' . date('Y') . '-' . str_pad(count($documents) + 1, 4, '0', STR_PAD_LEFT);
                    break;
                case 'estimate':
                    $document['type'] = 'estimate';
                    $document['estimate_number'] = $document['estimate_number'] ?: 'EST-' . date('Y') . '-' . str_pad(count($documents) + 1, 4, '0', STR_PAD_LEFT);
                    break;
                case 'po':
                    $document['type'] = 'po';
                    $document['po_number'] = $document['po_number'] ?: 'PO-' . date('Y') . '-' . str_pad(count($documents) + 1, 4, '0', STR_PAD_LEFT);
                    break;
            }

            $documents[] = $document;
        }

        return $documents;
    }

    /**
     * Process Excel data
     */
    private function processExcelData($data, $type)
    {
        $documents = [];
        $headers = array_shift($data); // Remove header row

        foreach ($data as $row) {
            if (empty(array_filter($row))) continue; // Skip empty rows

            $document = [];
            foreach ($headers as $index => $header) {
                $document[strtolower(str_replace([' ', '*'], ['_', ''], $header))] = $row[$index] ?? '';
            }

            // Add type-specific processing
            switch ($type) {
                case 'invoice':
                    $document['type'] = 'invoice';
                    $document['invoice_number'] = $document['invoice_number'] ?: 'INV-' . date('Y') . '-' . str_pad(count($documents) + 1, 4, '0', STR_PAD_LEFT);
                    break;
                case 'quotation':
                    $document['type'] = 'quotation';
                    $document['quotation_number'] = $document['quotation_number'] ?: 'QT-' . date('Y') . '-' . str_pad(count($documents) + 1, 4, '0', STR_PAD_LEFT);
                    break;
                case 'estimate':
                    $document['type'] = 'estimate';
                    $document['estimate_number'] = $document['estimate_number'] ?: 'EST-' . date('Y') . '-' . str_pad(count($documents) + 1, 4, '0', STR_PAD_LEFT);
                    break;
                case 'po':
                    $document['type'] = 'po';
                    $document['po_number'] = $document['po_number'] ?: 'PO-' . date('Y') . '-' . str_pad(count($documents) + 1, 4, '0', STR_PAD_LEFT);
                    break;
            }

            $documents[] = $document;
        }

        return $documents;
    }

    /**
     * Generate individual document
     */
    private function generateDocument($data, $type)
    {
        try {
            switch ($type) {
                case 'invoice':
                    return $this->createInvoiceFromData($data);
                case 'quotation':
                    return $this->createQuotationFromData($data);
                case 'estimate':
                    return $this->createEstimateFromData($data);
                case 'po':
                    return $this->createPOFromData($data);
                default:
                    throw new \Exception('Invalid document type');
            }
        } catch (\Exception $e) {
            Log::error("Error generating {$type} document: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create invoice from data
     */
    private function createInvoiceFromData($data)
    {
        // Create or find customer
        $customer = $this->findOrCreateCustomer($data);

        // Create invoice
        $invoice = new Invoice();
        $invoice->customer_id = $customer->id;
        $invoice->invoice_number = $data['invoice_number'];
        $invoice->invoice_date = $data['invoice_date'];
        $invoice->due_date = $data['due_date'];
        $invoice->po_so_number = $data['po_so_number'] ?? null;
        $invoice->notes = $data['notes'] ?? '';
        $invoice->status = 'draft';
        $invoice->user_id = Auth::id();
        $invoice->save();

        // Add items
        $this->addItemsToDocument($invoice, $data);

        return [
            'id' => $invoice->id,
            'number' => $invoice->invoice_number,
            'customer_name' => $customer->name,
            'total' => $invoice->total,
            'download_url' => route('documents.download', $invoice->id)
        ];
    }

    /**
     * Create quotation from data
     */
    private function createQuotationFromData($data)
    {
        $customer = $this->findOrCreateCustomer($data);

        $quotation = new Quotation();
        $quotation->customer_id = $customer->id;
        $quotation->quotation_number = $data['quotation_number'];
        $quotation->quotation_date = $data['quotation_date'];
        $quotation->valid_until = $data['valid_until'];
        $quotation->po_so_number = $data['po_so_number'] ?? null;
        $quotation->notes = $data['notes'] ?? '';
        $quotation->status = 'draft';
        $quotation->user_id = Auth::id();
        $quotation->save();

        $this->addItemsToDocument($quotation, $data);

        return [
            'id' => $quotation->id,
            'number' => $quotation->quotation_number,
            'customer_name' => $customer->name,
            'total' => $quotation->total,
            'download_url' => route('documents.download', $quotation->id)
        ];
    }

    /**
     * Create estimate from data
     */
    private function createEstimateFromData($data)
    {
        $customer = $this->findOrCreateCustomer($data);

        $estimate = new Estimate();
        $estimate->customer_id = $customer->id;
        $estimate->estimate_number = $data['estimate_number'];
        $estimate->estimate_date = $data['estimate_date'];
        $estimate->valid_until = $data['valid_until'];
        $estimate->project_name = $data['project_name'];
        $estimate->notes = $data['notes'] ?? '';
        $estimate->status = 'draft';
        $estimate->user_id = Auth::id();
        $estimate->save();

        $this->addItemsToDocument($estimate, $data);

        return [
            'id' => $estimate->id,
            'number' => $estimate->estimate_number,
            'customer_name' => $customer->name,
            'total' => $estimate->total,
            'download_url' => route('documents.download', $estimate->id)
        ];
    }

    /**
     * Create PO from data
     */
    private function createPOFromData($data)
    {
        $vendor = $this->findOrCreateVendor($data);

        $po = new PurchaseOrder();
        $po->vendor_id = $vendor->id;
        $po->po_number = $data['po_number'];
        $po->po_date = $data['po_date'];
        $po->expected_delivery = $data['expected_delivery'];
        $po->delivery_address = $data['delivery_address'] ?? $vendor->address;
        $po->notes = $data['notes'] ?? '';
        $po->status = 'draft';
        $po->user_id = Auth::id();
        $po->save();

        $this->addItemsToDocument($po, $data);

        return [
            'id' => $po->id,
            'number' => $po->po_number,
            'vendor_name' => $vendor->name,
            'total' => $po->total,
            'download_url' => route('documents.download', $po->id)
        ];
    }

    /**
     * Find or create customer
     */
    private function findOrCreateCustomer($data)
    {
        $customer = Customer::where('email', $data['customer_email'])->first();
        
        if (!$customer) {
            $customer = new Customer();
            $customer->name = $data['customer_name'];
            $customer->email = $data['customer_email'];
            $customer->phone = $data['customer_phone'] ?? '';
            $customer->address = $data['customer_address'] ?? '';
            $customer->user_id = Auth::id();
            $customer->save();
        }

        return $customer;
    }

    /**
     * Find or create vendor
     */
    private function findOrCreateVendor($data)
    {
        $vendor = Vendor::where('email', $data['vendor_email'])->first();
        
        if (!$vendor) {
            $vendor = new Vendor();
            $vendor->name = $data['vendor_name'];
            $vendor->email = $data['vendor_email'];
            $vendor->phone = $data['vendor_phone'] ?? '';
            $vendor->address = $data['vendor_address'] ?? '';
            $vendor->user_id = Auth::id();
            $vendor->save();
        }

        return $vendor;
    }

    /**
     * Add items to document
     */
    private function addItemsToDocument($document, $data)
    {
        $item = new Item();
        $item->description = $data['item_description'] ?? '';
        $item->quantity = $data['quantity'] ?? 1;
        $item->unit_price = $data['unit_price'] ?? 0;
        $item->tax_rate = $data['tax_rate'] ?? 0;
        $item->document_id = $document->id;
        $item->document_type = get_class($document);
        $item->save();
        
        // Calculate and update document total
        $this->updateDocumentTotal($document);
    }
    
    private function updateDocumentTotal($document)
    {
        $total = 0;
        $items = Item::where('document_id', $document->id)
                    ->where('document_type', get_class($document))
                    ->get();
        
        foreach ($items as $item) {
            $subtotal = $item->quantity * $item->unit_price;
            $tax = $subtotal * ($item->tax_rate / 100);
            $total += $subtotal + $tax;
        }
        
        $document->total = $total;
        $document->save();
    }

    /**
     * Create ZIP file for multiple documents
     */
    private function createZipFile($documents, $type)
    {
        $zipName = $type . '_batch_' . date('Y-m-d_H-i-s') . '.zip';
        $zipPath = storage_path('app/public/batch_documents/' . $zipName);

        // Ensure directory exists
        Storage::disk('public')->makeDirectory('batch_documents');

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($documents as $document) {
                // Generate PDF for each document
                $pdfPath = $this->generatePDF($document);
                $zip->addFile($pdfPath, $document['number'] . '.pdf');
            }
            $zip->close();
        }

        return Storage::disk('public')->url('batch_documents/' . $zipName);
    }

    /**
     * Generate PDF for document
     */
    private function generatePDF($document)
    {
        // This is a placeholder - implement actual PDF generation
        // You can use packages like DomPDF, mPDF, or Snappy
        $pdfPath = storage_path('app/public/documents/' . $document['number'] . '.pdf');
        
        // For now, create a simple text file as placeholder
        Storage::disk('public')->makeDirectory('documents');
        file_put_contents($pdfPath, "Document: {$document['number']}\nCustomer: {$document['customer_name']}\nTotal: {$document['total']}");
        
        return $pdfPath;
    }

    /**
     * Find document by ID
     */
    private function findDocument($id)
    {
        // Implement based on your models
        $invoice = Invoice::find($id);
        if ($invoice) return $invoice;

        $quotation = Quotation::find($id);
        if ($quotation) return $quotation;

        $estimate = Estimate::find($id);
        if ($estimate) return $estimate;

        $po = PurchaseOrder::find($id);
        if ($po) return $po;

        return null;
    }

    /**
     * Process invoice (placeholder)
     */
    private function processInvoice(Request $request)
    {
        // This would save to database and generate PDF
        return (object) ['id' => uniqid()];
    }

    /**
     * Process quotation (placeholder)
     */
    private function processQuotation(Request $request)
    {
        // This would save to database and generate PDF
        return (object) ['id' => uniqid()];
    }

    /**
     * Process estimate (placeholder)
     */
    private function processEstimate(Request $request)
    {
        // This would save to database and generate PDF
        return (object) ['id' => uniqid()];
    }

    /**
     * Process purchase order (placeholder)
     */
    private function processPO(Request $request)
    {
        // This would save to database and generate PDF
        return (object) ['id' => uniqid()];
    }
} 