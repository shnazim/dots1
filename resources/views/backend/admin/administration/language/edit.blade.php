@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header d-flex align-items-center justify-content-between">
				<span class="panel-title">{{ $title }}</span>
			</div>
			<div class="card-body">
				<form method="post" class="validate" id="language-form" autocomplete="off" action="{{ route('languages.update', $id) }}">
					@csrf
					<input name="_method" type="hidden" value="PATCH">
					<div class="row">
						@foreach( $language as $key => $lang )
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">{{ $key }}</label>
								<input type="text" class="form-control language-field" name="language[{{ str_replace(' ','_',$key) }}]" value="{{ $lang }}" required>
							</div>
						</div>
						@endforeach

						<div class="col-md-12 mt-2">
							<div class="form-group">
								<button type="submit" class="btn btn-primary submit-btn"><i class="ti-check-box mr-2"></i>{{ _lang('Save Translation') }}</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script>
(function ($) {
	"use strict";

	$(document).on('submit', '#language-form', function(e){
		e.preventDefault();

		var actionUrl = $(this).attr('action');
		var form = $(this);

		$.ajax({
			method: "POST",
			url: actionUrl,
			data: $.param($(form).serializeArray().slice(0, 990)),
			success: function(data) {

				var secondBatchData = $(form).serializeArray().slice(990);
				secondBatchData.push({name: '_method', value: 'PATCH'});
				secondBatchData.push({name: '_token', value: $('meta[name="csrf-token"]').attr('content')});

				setTimeout(function() {
					$.ajax({
						method: "POST",
						url: actionUrl,
						data: $.param(secondBatchData),
						success: function(data) {
							var json = JSON.parse(JSON.stringify(data));

							Swal.fire({
								text: json['message'],
								icon: json['result'],
								confirmButtonText: "{{ _lang('Close') }}",
							});
							$(".submit-btn").prop('disabled', false);
						}
					});
				}, 500);
			}
		});
	});

})(jQuery);
</script>
@endsection
