@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('public/backend/assets/css/invoice.css?v=1.0') }}">
@include('layouts.others.invoice-css')
<div class="row">
	<div class="col-xl-8 offset-xl-2">
		@include('backend.user.quotation.action')
		@include('backend.user.quotation.template.loader')
	</div>
</div>
@endsection