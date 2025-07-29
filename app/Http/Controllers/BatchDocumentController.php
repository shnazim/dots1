<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DocumentTemplateExport;
use App\Models\Invoice;
use App\Models\Quotation;
use App\Models\Estimate;
use App\Models\PurchaseOrder;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Item;
use App\Models\BatchJob;
use App\Models\DocumentTemplate;
use Carbon\Carbon;
use ZipArchive;
use PDF;

class BatchDocumentController extends Controller
{
    /**
     * Show batch document management dashboard
     */
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $batchJobs = BatchJob::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total_jobs' => BatchJob::where('user_id', Auth::id())->count(),
            'completed_jobs' => BatchJob::where('user_id', Auth::id())->where('status', 'completed')->count(),
            'pending_jobs' => BatchJob::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'failed_jobs' => BatchJob::where('user_id', Auth::id())->where('status', 'failed')->count(),
        ];

        return view('documents.batch.dashboard', compact('batchJobs', 'stats'));
    }

    /**
     * Show batch job details
     */
    public function showJob($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $batchJob = BatchJob::where('user_id', Auth::id())->findOrFail($id);
        
        return view('documents.batch.job-details', compact('batchJob'));
    }

    /**
     * Create new batch job
     */
    public function createJob(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'redirect' => route('login'),
                'message' => 'Please login to create batch jobs'
            ]);
        }

        $request->validate([
            'type' => 'required|in:invoice,quotation,estimate,po',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template_id' => 'nullable|exists:document_templates,id'
        ]);

        try {
            $batchJob = new BatchJob();
            $batchJob->user_id = Auth::id();
            $batchJob->type = $request->type;
            $batchJob->name = $request->name;
            $batchJob->description = $request->description;
            $batchJob->template_id = $request->template_id;
            $batchJob->status = 'pending';
            $batchJob->total_documents = 0;
            $batchJob->processed_documents = 0;
            $batchJob->failed_documents = 0;
            $batchJob->save();

            return response()->json([
                'success' => true,
                'job_id' => $batchJob->id,
                'message' => 'Batch job created successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating batch job: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating batch job'
            ]);
        }
    }

    /**
     * Upload and process batch data
     */
    public function uploadData(Request $request, $jobId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'redirect' => route('login'),
                'message' => 'Please login to upload data'
            ]);
        }

        $batchJob = BatchJob::where('user_id', Auth::id())->findOrFail($jobId);

        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:10240'
        ]);

        try {
            // Store the uploaded file
            $filePath = $request->file('excel_file')->store('batch_uploads/' . $batchJob->id, 'private');
            
            // Process the Excel data
            $data = Excel::toArray([], $request->file('excel_file'))[0];
            $documents = $this->processExcelData($data, $batchJob->type);
            
            // Update batch job
            $batchJob->file_path = $filePath;
            $batchJob->total_documents = count($documents);
            $batchJob->data = $documents;
            $batchJob->status = 'ready';
            $batchJob->save();

            return response()->json([
                'success' => true,
                'documents' => $documents,
                'count' => count($documents),
                'message' => 'Data uploaded and processed successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error uploading batch data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error processing file: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Generate documents for batch job
     */
    public function generateDocuments(Request $request, $jobId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'redirect' => route('login'),
                'message' => 'Please login to generate documents'
            ]);
        }

        $batchJob = BatchJob::where('user_id', Auth::id())->findOrFail($jobId);

        if ($batchJob->status !== 'ready') {
            return response()->json([
                'success' => false,
                'message' => 'Batch job is not ready for processing'
            ]);
        }

        try {
            // Update status to processing
            $batchJob->status = 'processing';
            $batchJob->started_at = now();
            $batchJob->save();

            $documents = $batchJob->data ?? [];
            $generatedDocuments = [];
            $errors = [];
            $processed = 0;

            foreach ($documents as $index => $documentData) {
                try {
                    $document = $this->generateDocument($documentData, $batchJob->type, $batchJob->template_id);
                    $generatedDocuments[] = $document;
                    $processed++;
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 1) . ": " . $e->getMessage();
                    Log::error("Error generating document in batch job {$jobId}: " . $e->getMessage());
                }

                // Update progress
                $batchJob->processed_documents = $processed;
                $batchJob->failed_documents = count($errors);
                $batchJob->save();
            }

            // Create ZIP file if multiple documents
            $zipUrl = null;
            if (count($generatedDocuments) > 1) {
                $zipUrl = $this->createZipFile($generatedDocuments, $batchJob->type, $batchJob->id);
            }

            // Update batch job status
            $batchJob->status = 'completed';
            $batchJob->completed_at = now();
            $batchJob->generated_documents = $generatedDocuments;
            $batchJob->errors = $errors;
            $batchJob->zip_url = $zipUrl;
            $batchJob->save();

            return response()->json([
                'success' => true,
                'documents' => $generatedDocuments,
                'zip_url' => $zipUrl,
                'errors' => $errors,
                'total' => count($documents),
                'successful' => count($generatedDocuments),
                'failed' => count($errors)
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating batch documents: ' . $e->getMessage());
            
            $batchJob->status = 'failed';
            $batchJob->errors = [$e->getMessage()];
            $batchJob->save();

            return response()->json([
                'success' => false,
                'message' => 'Error generating documents: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Download batch results
     */
    public function downloadResults($jobId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $batchJob = BatchJob::where('user_id', Auth::id())->findOrFail($jobId);

        if ($batchJob->status !== 'completed') {
            return redirect()->back()->with('error', 'Batch job is not completed');
        }

        if ($batchJob->zip_url) {
            return response()->download(storage_path('app/public/' . $batchJob->zip_url));
        } else {
            // Single document download
            $documents = $batchJob->generated_documents;
            if (count($documents) === 1) {
                return response()->download($documents[0]['pdf_path']);
            }
        }

        return redirect()->back()->with('error', 'No documents to download');
    }

    /**
     * Delete batch job
     */
    public function deleteJob($jobId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $batchJob = BatchJob::where('user_id', Auth::id())->findOrFail($jobId);

        try {
            // Delete associated files
            if ($batchJob->file_path) {
                Storage::disk('private')->delete($batchJob->file_path);
            }
            if ($batchJob->zip_url) {
                Storage::disk('public')->delete($batchJob->zip_url);
            }

            $batchJob->delete();

            return response()->json([
                'success' => true,
                'message' => 'Batch job deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting batch job: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting batch job'
            ]);
        }
    }

    /**
     * Get batch job progress
     */
    public function getProgress($jobId)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'redirect' => route('login')]);
        }

        $batchJob = BatchJob::where('user_id', Auth::id())->findOrFail($jobId);

        return response()->json([
            'success' => true,
            'status' => $batchJob->status,
            'progress' => $batchJob->total_documents > 0 ? 
                round(($batchJob->processed_documents / $batchJob->total_documents) * 100) : 0,
            'processed' => $batchJob->processed_documents,
            'total' => $batchJob->total_documents,
            'failed' => $batchJob->failed_documents
        ]);
    }

    /**
     * Process Excel data
     */
    private function processExcelData($data, $type)
    {
        $headers = array_shift($data); // Remove header row
        $documents = [];

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
    private function generateDocument($data, $type, $templateId = null)
    {
        try {
            switch ($type) {
                case 'invoice':
                    return $this->createInvoiceFromData($data, $templateId);
                case 'quotation':
                    return $this->createQuotationFromData($data, $templateId);
                case 'estimate':
                    return $this->createEstimateFromData($data, $templateId);
                case 'po':
                    return $this->createPOFromData($data, $templateId);
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
    private function createInvoiceFromData($data, $templateId = null)
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
        $invoice->template_id = $templateId;
        $invoice->save();

        // Add items
        $this->addItemsToDocument($invoice, $data);

        // Generate PDF
        $pdfPath = $this->generatePDF($invoice, 'invoice', $templateId);

        return [
            'id' => $invoice->id,
            'number' => $invoice->invoice_number,
            'customer_name' => $customer->name,
            'total' => $invoice->total,
            'pdf_path' => $pdfPath,
            'download_url' => route('documents.download', $invoice->id)
        ];
    }

    /**
     * Create quotation from data
     */
    private function createQuotationFromData($data, $templateId = null)
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
        $quotation->template_id = $templateId;
        $quotation->save();

        $this->addItemsToDocument($quotation, $data);

        $pdfPath = $this->generatePDF($quotation, 'quotation', $templateId);

        return [
            'id' => $quotation->id,
            'number' => $quotation->quotation_number,
            'customer_name' => $customer->name,
            'total' => $quotation->total,
            'pdf_path' => $pdfPath,
            'download_url' => route('documents.download', $quotation->id)
        ];
    }

    /**
     * Create estimate from data
     */
    private function createEstimateFromData($data, $templateId = null)
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
        $estimate->template_id = $templateId;
        $estimate->save();

        $this->addItemsToDocument($estimate, $data);

        $pdfPath = $this->generatePDF($estimate, 'estimate', $templateId);

        return [
            'id' => $estimate->id,
            'number' => $estimate->estimate_number,
            'customer_name' => $customer->name,
            'total' => $estimate->total,
            'pdf_path' => $pdfPath,
            'download_url' => route('documents.download', $estimate->id)
        ];
    }

    /**
     * Create PO from data
     */
    private function createPOFromData($data, $templateId = null)
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
        $po->template_id = $templateId;
        $po->save();

        $this->addItemsToDocument($po, $data);

        $pdfPath = $this->generatePDF($po, 'po', $templateId);

        return [
            'id' => $po->id,
            'number' => $po->po_number,
            'vendor_name' => $vendor->name,
            'total' => $po->total,
            'pdf_path' => $pdfPath,
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
        $item->description = $data['item_description'];
        $item->quantity = $data['quantity'];
        $item->unit_price = $data['unit_price'];
        $item->tax_rate = $data['tax_rate'] ?? 0;
        $item->document_id = $document->id;
        $item->document_type = get_class($document);
        $item->save();
    }

    /**
     * Generate PDF for document
     */
    private function generatePDF($document, $type, $templateId = null)
    {
        // Get template
        $template = $templateId ? DocumentTemplate::find($templateId) : null;
        
        // Generate PDF using template or default
        $pdf = PDF::loadView("documents.{$type}.template", [
            'document' => $document,
            'template' => $template
        ]);

        $filename = $document->{$type . '_number'} . '.pdf';
        $pdfPath = storage_path('app/public/documents/' . $filename);
        
        // Ensure directory exists
        Storage::disk('public')->makeDirectory('documents');
        
        // Save PDF
        $pdf->save($pdfPath);
        
        return $pdfPath;
    }

    /**
     * Create ZIP file for multiple documents
     */
    private function createZipFile($documents, $type, $jobId)
    {
        $zipName = $type . '_batch_' . $jobId . '_' . date('Y-m-d_H-i-s') . '.zip';
        $zipPath = storage_path('app/public/batch_documents/' . $zipName);

        // Ensure directory exists
        Storage::disk('public')->makeDirectory('batch_documents');

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($documents as $document) {
                if (file_exists($document['pdf_path'])) {
                    $zip->addFile($document['pdf_path'], $document['number'] . '.pdf');
                }
            }
            $zip->close();
        }

        return 'batch_documents/' . $zipName;
    }
} 