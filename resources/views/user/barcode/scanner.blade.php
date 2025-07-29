@extends('layouts.app')

@section('title', 'Barcode Scanner')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Barcode & QR Code Scanner</h4>
                    <p class="card-text">Scan barcodes and QR codes using your device camera</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="scanner-container">
                                <div id="reader" class="w-100" style="min-height: 400px;"></div>
                                <div class="scanner-overlay">
                                    <div class="scanner-frame"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="scanned-results">
                                <h5>Scanned Results</h5>
                                <div id="scanned-data" class="mt-3">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        Point your camera at a barcode or QR code to scan
                                    </div>
                                </div>
                                
                                <div class="scanner-controls mt-4">
                                    <button id="start-scanner" class="btn btn-primary btn-block">
                                        <i class="fas fa-camera"></i> Start Scanner
                                    </button>
                                    <button id="stop-scanner" class="btn btn-secondary btn-block mt-2" style="display: none;">
                                        <i class="fas fa-stop"></i> Stop Scanner
                                    </button>
                                    <button id="switch-camera" class="btn btn-outline-primary btn-block mt-2">
                                        <i class="fas fa-sync"></i> Switch Camera
                                    </button>
                                </div>

                                <div class="scanner-settings mt-4">
                                    <h6>Scanner Settings</h6>
                                    <div class="form-group">
                                        <label for="scan-type">Scan Type</label>
                                        <select id="scan-type" class="form-control">
                                            <option value="both">Barcode & QR Code</option>
                                            <option value="barcode">Barcode Only</option>
                                            <option value="qr">QR Code Only</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="beep-sound">Beep Sound</label>
                                        <select id="beep-sound" class="form-control">
                                            <option value="true">Enabled</option>
                                            <option value="false">Disabled</option>
                                        </select>
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

<style>
.scanner-container {
    position: relative;
    border: 2px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
}

.scanner-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    z-index: 10;
}

.scanner-frame {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 250px;
    height: 250px;
    border: 2px solid #007bff;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.5);
}

.scanner-frame::before,
.scanner-frame::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border: 3px solid #007bff;
}

.scanner-frame::before {
    top: -3px;
    left: -3px;
    border-right: none;
    border-bottom: none;
}

.scanner-frame::after {
    bottom: -3px;
    right: -3px;
    border-left: none;
    border-top: none;
}

.scanned-results {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    height: 100%;
}

#reader {
    background: #000;
}

#reader video {
    width: 100% !important;
    height: auto !important;
}
</style>

@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
let html5QrcodeScanner = null;
let currentCameraId = null;
let cameras = [];

document.addEventListener('DOMContentLoaded', function() {
    const startButton = document.getElementById('start-scanner');
    const stopButton = document.getElementById('stop-scanner');
    const switchButton = document.getElementById('switch-camera');
    const scanTypeSelect = document.getElementById('scan-type');
    const beepSoundSelect = document.getElementById('beep-sound');

    // Initialize scanner
    function initScanner() {
        const config = {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0,
            supportedScanTypes: getSupportedScanTypes()
        };

        html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            config,
            false
        );

        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    }

    function getSupportedScanTypes() {
        const scanType = scanTypeSelect.value;
        switch(scanType) {
            case 'barcode':
                return [Html5QrcodeScanType.SCAN_TYPE_CAMERA];
            case 'qr':
                return [Html5QrcodeScanType.SCAN_TYPE_CAMERA];
            default:
                return [Html5QrcodeScanType.SCAN_TYPE_CAMERA];
        }
    }

    function onScanSuccess(decodedText, decodedResult) {
        // Play beep sound if enabled
        if (beepSoundSelect.value === 'true') {
            playBeepSound();
        }

        // Display scanned result
        displayScannedResult(decodedText, decodedResult);

        // Stop scanner after successful scan
        setTimeout(() => {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
                startButton.style.display = 'block';
                stopButton.style.display = 'none';
            }
        }, 2000);
    }

    function onScanFailure(error) {
        // Handle scan failure silently
        console.log('Scan failed:', error);
    }

    function displayScannedResult(text, result) {
        const scannedData = document.getElementById('scanned-data');
        const timestamp = new Date().toLocaleString();
        
        const resultHtml = `
            <div class="alert alert-success">
                <h6><i class="fas fa-check-circle"></i> Scan Successful!</h6>
                <p><strong>Data:</strong> ${text}</p>
                <p><strong>Type:</strong> ${result.result.format.formatName}</p>
                <p><strong>Time:</strong> ${timestamp}</p>
                <div class="mt-2">
                    <button class="btn btn-sm btn-primary" onclick="copyToClipboard('${text}')">
                        <i class="fas fa-copy"></i> Copy
                    </button>
                    <button class="btn btn-sm btn-success" onclick="searchProduct('${text}')">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
        `;
        
        scannedData.innerHTML = resultHtml;
    }

    function playBeepSound() {
        const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmGgU7k9n1unEiBC13yO/eizEIHWq+8+OWT');
        audio.play();
    }

    // Event listeners
    startButton.addEventListener('click', function() {
        initScanner();
        startButton.style.display = 'none';
        stopButton.style.display = 'block';
    });

    stopButton.addEventListener('click', function() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear();
            startButton.style.display = 'block';
            stopButton.style.display = 'none';
        }
    });

    switchButton.addEventListener('click', function() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear();
            setTimeout(() => {
                initScanner();
            }, 100);
        }
    });

    scanTypeSelect.addEventListener('change', function() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear();
            setTimeout(() => {
                initScanner();
            }, 100);
        }
    });
});

// Utility functions
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        showToast('Copied to clipboard!', 'success');
    }, function(err) {
        console.error('Could not copy text: ', err);
        showToast('Failed to copy to clipboard', 'error');
    });
}

function searchProduct(barcode) {
    // Redirect to product search or inventory
    window.open(`/user/products?search=${barcode}`, '_blank');
}

function showToast(message, type) {
    // Simple toast notification
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
@endpush 