@extends('layouts.app')

@section('content')
<form method="post" class="validate" autocomplete="off" action="{{ route('pages.default_pages.store', 'home') }}" enctype="multipart/form-data">
	<div class="row">
		<div class="col-lg-8 offset-lg-2">
			<div class="card">
				<div class="card-header d-flex align-items-center justify-content-between">
					<span class="panel-title">{{ _lang('Update Blogs Page') }}</span>
					<a href="{{ route('pages.default_pages') }}" class="btn btn-outline-primary btn-xs"><i class="fas fa-chevron-left mr-2"></i>{{ _lang('Back') }}</a>
				</div>
				<div class="card-body">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-6">
					        <div class="form-group">
						        <label class="control-label">{{ _lang('Title') }}</label>
						        <input type="text" class="form-control" name="blogs_page[title]" value="{{ isset($pageData->title) ? $pageData->title : '' }}" required>
					        </div>
					    </div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">{{ _lang('Language') }}</label>
								<select class="form-control" name="model_language" required>
									{{ load_language(get_language()) }}
								</select>
							</div>
						</div>

						<div class="col-md-12">
					        <div class="form-group">
						        <label class="control-label">{{ _lang('Blogs Heading') }}</label>
						        <input type="text" class="form-control" name="blogs_page[blogs_heading]" value="{{ isset($pageData->blogs_heading) ? $pageData->blogs_heading : '' }}" required>
					        </div>
					    </div>

						<div class="col-md-12">
					        <div class="form-group">
						        <label class="control-label">{{ _lang('Blogs Sub Heading') }}</label>
						        <input type="text" class="form-control" name="blogs_page[blogs_sub_heading]" value="{{ isset($pageData->blogs_sub_heading) ? $pageData->blogs_sub_heading : '' }}">
					        </div>
					    </div>

						<div class="col-md-12 mt-2">
							<div class="form-group">
								<button type="submit" class="btn btn-primary  mt-2"><i class="ti-check-box mr-2"></i>{{ _lang('Save Changes') }}</button>
							</div>
						</div>
					</div>
				</div>
			</div>
	    </div>
	</div>
</form>
@endsection


