@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-6 offset-lg-3">
		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ _lang('Update Role') }}</span>
			</div>
			<div class="card-body">
				<form method="post" class="validate" autocomplete="off" action="{{ route('roles.update', $id) }}" enctype="multipart/form-data">
					{{ csrf_field()}}
					<input name="_method" type="hidden" value="PATCH">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
							   <label class="control-label">{{ _lang('Name') }}</label>
							   <input type="text" class="form-control" name="name" value="{{ $role->name }}" required>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
							   <label class="control-label">{{ _lang('Description') }}</label>
							   <textarea class="form-control" name="description">{{ $role->description }}</textarea>
							</div>
						</div>


						<div class="col-md-12 mt-2">
							<div class="form-group">
								<button type="submit" class="btn btn-primary"><i class="ti-check-box mr-2"></i>{{ _lang('Update') }}</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection


