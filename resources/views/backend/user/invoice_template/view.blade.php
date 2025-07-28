@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-xl-8 offset-xl-2">
		<div class="card">
			<div class="card-body">
			  @php $body = $invoicetemplate->body; @endphp
			  @php $body = str_replace('<!--$invoice_items_header-->','<tr><td colspan="4" class="text-center">$invoice_items_header</td></tr>',$body); @endphp
			  @php $body = str_replace('<!--$invoice_items-->','<tr><td colspan="4" class="text-center">$invoice_items</td></tr>',$body); @endphp
			  @php $body = str_replace('<!--$invoice_summary-->','<tr><td class="text-center">$invoice_summary</td></tr>',$body); @endphp
			  @php $body = str_replace('<!--$invoice_payment_history-->','<tr><td colspan="4" class="text-center">$invoice_payment_history</td></tr>',$body); @endphp
			  @php $body = str_replace('<!--$company_logo-->', asset('public/uploads/media/'.request()->activeBusiness->logo), $body); @endphp
			  @php $body = str_replace('<!--$qr_code-->', asset('public/backend/images/qr_code.png'), $body); @endphp

			  {!! xss_clean($body) !!}
			</div>
	    </div>
	</div>
</div>
@endsection


