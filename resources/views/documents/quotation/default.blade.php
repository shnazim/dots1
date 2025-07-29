<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation - {{ $quotation->quotation_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        .company-info {
            text-align: center;
            margin-bottom: 30px;
        }
        .quotation-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .customer-info, .quotation-info {
            flex: 1;
        }
        .quotation-info {
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .totals {
            text-align: right;
            margin-top: 20px;
        }
        .total-row {
            font-weight: bold;
            font-size: 18px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>QUOTATION</h1>
    </div>

    <div class="company-info">
        <h2>Document Management System</h2>
        <p>Professional Document Solutions</p>
        <p>Email: info@dots.com | Phone: +1 (555) 123-4567</p>
    </div>

    <div class="quotation-details">
        <div class="customer-info">
            <h3>Bill To:</h3>
            <p><strong>{{ $quotation->customer->name }}</strong></p>
            <p>{{ $quotation->customer->email }}</p>
            @if($quotation->customer->phone)
                <p>{{ $quotation->customer->phone }}</p>
            @endif
            @if($quotation->customer->address)
                <p>{{ $quotation->customer->address }}</p>
            @endif
        </div>
        
        <div class="quotation-info">
            <h3>Quotation Details:</h3>
            <p><strong>Quotation #:</strong> {{ $quotation->quotation_number }}</p>
            <p><strong>Date:</strong> {{ $quotation->quotation_date }}</p>
            <p><strong>Valid Until:</strong> {{ $quotation->expired_date }}</p>
            <p><strong>Project:</strong> {{ $quotation->title }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item/Service</th>
                <th style="text-align: center;">Quantity</th>
                <th style="text-align: right;">Unit Price</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td style="text-align: right;">${{ number_format($item->unit_price, 2) }}</td>
                <td style="text-align: right;">${{ number_format($item->sub_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <p><strong>Subtotal:</strong> ${{ number_format($quotation->sub_total, 2) }}</p>
        <p><strong>Tax (10%):</strong> ${{ number_format($quotation->grand_total - $quotation->sub_total, 2) }}</p>
        <p class="total-row">Total: ${{ number_format($quotation->grand_total, 2) }}</p>
    </div>

    @if($quotation->note)
    <div style="margin-top: 30px;">
        <h4>Notes:</h4>
        <p>{{ $quotation->note }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>This quotation is valid until {{ $quotation->expired_date }}</p>
        <p>Generated on {{ date('F j, Y') }}</p>
    </div>
</body>
</html> 