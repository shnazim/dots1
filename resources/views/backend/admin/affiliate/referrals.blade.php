@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
		    <div class="card-header d-flex align-items-center">
				<span class="panel-title">{{ _lang('Referrals History') }}</span>
			</div>
			<div class="card-body">
				<table id="referral_earnings_table" class="table">
					<thead>
					    <tr>
                            <th>{{ _lang('Register Date') }}</th>
                            <th>{{ _lang('User') }}</th>
                            <th>{{ _lang('Referrer') }}</th>
                            <th>{{ _lang('Amount') }}</th>
                            <th>{{ _lang('Percentage') }}</th>
                            <th>{{ _lang('Commission') }}</th>
					    </tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script>
(function ($) {
	"use strict";

	$('#referral_earnings_table').DataTable({
		processing: true,
		serverSide: true,
		ajax: _url + '/admin/affiliate/get_referrals_data',
		"columns" : [
			{ data : 'created_at', name : 'created_at' },
			{ data : 'name', name : 'name' },
			{ data : 'referrer.name', name : 'referrer.name' },
			{ data : 'referral_payment.amount', name : 'referral_payment.amount' },
			{ data : 'referral_payment.commission_percentage', name : 'referral_payment.commission_percentage' },
			{ data : 'referral_payment.commission_amount', name : 'referral_payment.commission_amount' },
		],
		responsive: true,
		"bStateSave": true,
		"bAutoWidth":false,
		"ordering": false,
		"language": {
		   "decimal":        "",
		   "emptyTable":     "{{ _lang('No Data Found') }}",
		   "info":           "{{ _lang('Showing') }} _START_ {{ _lang('to') }} _END_ {{ _lang('of') }} _TOTAL_ {{ _lang('Entries') }}",
		   "infoEmpty":      "{{ _lang('Showing 0 To 0 Of 0 Entries') }}",
		   "infoFiltered":   "(filtered from _MAX_ total entries)",
		   "infoPostFix":    "",
		   "thousands":      ",",
		   "lengthMenu":     "{{ _lang('Show') }} _MENU_ {{ _lang('Entries') }}",
		   "loadingRecords": "{{ _lang('Loading...') }}",
		   "processing":     "{{ _lang('Processing...') }}",
		   "search":         "{{ _lang('Search') }}",
		   "zeroRecords":    "{{ _lang('No matching records found') }}",
		   "paginate": {
			  "first":      "{{ _lang('First') }}",
			  "last":       "{{ _lang('Last') }}",
			  "previous":   "<i class='fas fa-angle-left'></i>",
			  "next":       "<i class='fas fa-angle-right'></i>"
		  }
		}
	});
})(jQuery);
</script>
@endsection