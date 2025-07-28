@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">   
			<div class="card-header d-sm-flex align-items-center justify-content-between">
				<span class="panel-title">{{ request()->type == 'global' ? _lang('Predefined Templates') : _lang('Invoice Templates') }}</span>
				<div>
					@if(request()->type == 'global')
					<a class="btn btn-danger btn-xs" href="{{ route('invoice_templates.index') }}"><i class="fas fa-palette mr-1"></i>{{ _lang('My Templates') }}</a>
					@else
					<a class="btn btn-danger btn-xs" href="{{ route('invoice_templates.index') }}?type=global"><i class="fas fa-palette mr-1"></i>{{ _lang('Predefined Templates') }}</a>
					@endif
					<a class="btn btn-primary btn-xs" href="{{ route('invoice_templates.create') }}"><i class="ti-plus mr-1"></i>{{ _lang('Add New') }}</a>
				</div>
			</div>
			<div class="card-body">

				<table class="table data-table">
					<thead>
						<tr>
							<th>{{ _lang('Name') }}</th>
							<th>{{ _lang('Type') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
						</tr>
					</thead>
					<tbody>			
					@foreach($invoicetemplates as $invoicetemplate)
						<tr id="row_{{ $invoicetemplate->id }}">
							<td class='name'>{{ $invoicetemplate->name }}</td>
							<td class='type'>{{ ucwords($invoicetemplate->type) }}</td>

							<td class="text-center">
								@if(request()->type == 'global')
									<a href="{{ route('invoice_templates.copy', $invoicetemplate->id) }}" class="btn btn-outline-primary text-center btn-xs"><i class="fas fa-clone"></i> {{ _lang('Copy') }}</a>
								@else	
								<div class="dropdown">
									<button class="btn btn-outline-primary dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										{{ _lang('Action') }}
									</button>
									<form action="{{ route('invoice_templates.destroy', $invoicetemplate->id) }}" method="post">
										@csrf
										<input name="_method" type="hidden" value="DELETE">
										
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a href="{{ route('invoice_templates.edit', $invoicetemplate->id) }}" class="dropdown-item dropdown-edit"><i class="fas fa-edit"></i> {{ _lang('Edit') }}</a>
											<a href="{{ route('invoice_templates.show', $invoicetemplate->id) }}" class="dropdown-item dropdown-view"><i class="fas fa-eye"></i> {{ _lang('View') }}</a>
											<a href="{{ route('invoice_templates.clone', $invoicetemplate->id) }}" class="dropdown-item dropdown-view"><i class="far fa-clone"></i> {{ _lang('Duplicate') }}</a>
											<button class="btn-remove dropdown-item" type="submit"><i class="fas fa-recycle"></i> {{ _lang('Delete') }}</button>
										</div>
									</form>
								</div>
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection


