@php
$invoice = isset($invoice) ? $invoice : null;
$invoice = isset($purchase) ? $purchase : $invoice;
$invoice = isset($quotation) ? $quotation : $invoice;
$primary_color = get_business_option('invoice_primary_color', '#30336b', $invoice->business_id);
$primary_text_color = get_business_option('primary_text_color', '#ffffff', $invoice->business_id);

$invoice_secondary_color = get_business_option('invoice_secondary_color', '#30336b', $invoice->business_id);
$secondary_text_color = get_business_option('secondary_text_color', '#ffffff', $invoice->business_id);
@endphp

<style type="text/css">
.default-invoice .invoice-header{background: {{ $primary_color; }} !important;}
.default-invoice .invoice-header h2.title{color: {{$primary_text_color}} !important;}
.default-invoice .invoice-header h4.company-name{color: {{$primary_text_color}} !important;}
.default-invoice .invoice-header p{color: {{$primary_text_color}} !important;}

.default-invoice .invoice-body table thead th{background-color: {{ $invoice_secondary_color; }} !important;}
.default-invoice .invoice-body table thead th {color: {{$secondary_text_color}} !important;}
.default-invoice .invoice-summary table td {background-color: {{ $invoice_secondary_color; }} !important;}
.default-invoice .invoice-summary table td {color: {{ $secondary_text_color; }} !important;}
</style>
