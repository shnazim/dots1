<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

class BarcodeController extends Controller
{
    public function generateBarcode(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'type' => 'required|in:CODE128,CODE39,EAN13,UPC,ITF14',
            'width' => 'integer|min:1|max:10',
            'height' => 'integer|min:10|max:200',
        ]);

        $text = $request->input('text');
        $type = $request->input('type');
        $width = $request->input('width', 2);
        $height = $request->input('height', 100);

        try {
            $barcode = new DNS1D();
            $barcodeImage = $barcode->getBarcodePNG($text, $type, $width, $height);
            
            return response()->json([
                'success' => true,
                'barcode' => 'data:image/png;base64,' . $barcodeImage,
                'text' => $text,
                'type' => $type
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating barcode: ' . $e->getMessage()
            ], 400);
        }
    }

    public function generateQR(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:2048',
            'size' => 'integer|min:100|max:1000',
            'format' => 'in:png,svg,eps',
            'style' => 'in:square,dot,round',
            'eye' => 'in:square,circle',
            'margin' => 'integer|min:0|max:10',
        ]);

        $text = $request->input('text');
        $size = $request->input('size', 300);
        $format = $request->input('format', 'png');
        $style = $request->input('style', 'square');
        $eye = $request->input('eye', 'square');
        $margin = $request->input('margin', 1);

        try {
            $qrCode = QrCode::format($format)
                ->size($size)
                ->margin($margin)
                ->style($style)
                ->eye($eye)
                ->generate($text);

            if ($format === 'png') {
                $base64 = base64_encode($qrCode);
                return response()->json([
                    'success' => true,
                    'qr_code' => 'data:image/png;base64,' . $base64,
                    'text' => $text,
                    'format' => $format
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'qr_code' => $qrCode,
                    'text' => $text,
                    'format' => $format
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating QR code: ' . $e->getMessage()
            ], 400);
        }
    }

    public function barcodeScanner()
    {
        return view('user.barcode.scanner');
    }

    public function downloadBarcode(Request $request)
    {
        $request->validate([
            'barcode_data' => 'required|string',
            'filename' => 'required|string|max:255',
        ]);

        $barcodeData = $request->input('barcode_data');
        $filename = $request->input('filename');

        // Remove data URL prefix if present
        $barcodeData = preg_replace('/^data:image\/png;base64,/', '', $barcodeData);
        
        $imageData = base64_decode($barcodeData);
        
        return response($imageData)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '.png"');
    }

    public function downloadQR(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
            'filename' => 'required|string|max:255',
            'format' => 'required|in:png,svg,eps',
        ]);

        $qrData = $request->input('qr_data');
        $filename = $request->input('filename');
        $format = $request->input('format');

        if ($format === 'png') {
            $qrData = preg_replace('/^data:image\/png;base64,/', '', $qrData);
            $imageData = base64_decode($qrData);
            
            return response($imageData)
                ->header('Content-Type', 'image/png')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '.png"');
        } else {
            return response($qrData)
                ->header('Content-Type', 'text/plain')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '.' . $format . '"');
        }
    }

    public function printLabels(Request $request)
    {
        $request->validate([
            'labels' => 'required|array|min:1',
            'label_type' => 'required|in:product,shipping,inventory',
            'printer_settings' => 'array',
        ]);

        $labels = $request->input('labels');
        $labelType = $request->input('label_type');
        $printerSettings = $request->input('printer_settings', []);

        // Generate labels based on type
        $generatedLabels = [];
        foreach ($labels as $label) {
            $generatedLabels[] = $this->generateLabel($label, $labelType);
        }

        return response()->json([
            'success' => true,
            'labels' => $generatedLabels,
            'print_data' => $this->preparePrintData($generatedLabels, $printerSettings)
        ]);
    }

    private function generateLabel($labelData, $type)
    {
        $barcode = new DNS1D();
        $barcodeImage = $barcode->getBarcodePNG($labelData['code'], 'CODE128', 2, 50);

        return [
            'barcode' => 'data:image/png;base64,' . $barcodeImage,
            'text' => $labelData['text'] ?? '',
            'code' => $labelData['code'],
            'type' => $type,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ];
    }

    private function preparePrintData($labels, $settings)
    {
        // Prepare print-ready data
        return [
            'labels' => $labels,
            'settings' => array_merge([
                'paper_size' => 'A4',
                'orientation' => 'portrait',
                'margins' => [10, 10, 10, 10],
                'label_width' => 100,
                'label_height' => 50,
            ], $settings)
        ];
    }
} 