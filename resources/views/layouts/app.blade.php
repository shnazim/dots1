<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{ !isset($page_title) ? get_option('site_title', config('app.name')) : $page_title }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- App favicon -->
        <link rel="shortcut icon" href="{{ get_favicon() }}">
		<link href="{{ asset('public/backend/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
		<link href="{{ asset('public/backend/plugins/sweet-alert2/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('public/backend/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('public/backend/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	    <link href="{{ asset('public/backend/plugins/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet" />
		<link href="{{ asset('public/backend/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />

		<!-- App Css -->
        <link rel="stylesheet" href="{{ asset('public/backend/plugins/bootstrap/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('public/backend/assets/css/fontawesome.css') }}">
		<link rel="stylesheet" href="{{ asset('public/backend/assets/css/themify-icons.css') }}">
		<link rel="stylesheet" href="{{ asset('public/backend/plugins/metisMenu/metisMenu.css') }}">

		@if(isset(request()->activeBusiness->id))
			@if(get_business_option('backend_direction') == "rtl")
			<link rel="stylesheet" href="{{ asset('public/backend/plugins/bootstrap/css/bootstrap-rtl.min.css') }}">
			@endif
		@else
			@if(get_option('backend_direction') == "rtl")
			<link rel="stylesheet" href="{{ asset('public/backend/plugins/bootstrap/css/bootstrap-rtl.min.css') }}">
			@endif
		@endif

		<!-- Conditionals CSS -->
		@include('layouts.others.import-css')

		<!-- Others css -->
		<link rel="stylesheet" href="{{ asset('public/backend/assets/css/typography.css') }}">
		<link rel="stylesheet" href="{{ asset('public/backend/assets/css/default-css.css') }}">
		<link rel="stylesheet" href="{{ asset('public/backend/assets/css/styles.css?v=1.4') }}">
		<link rel="stylesheet" href="{{ asset('public/backend/assets/css/responsive.css?v=1.0') }}">

		<!-- Modernizr -->
		<script src="{{ asset('public/backend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>


		@if(isset(request()->activeBusiness->id))
			@if(get_business_option('backend_direction') == "rtl")
			<link rel="stylesheet" href="{{ asset('public/backend/assets/css/rtl/style.css?v=1.0') }}">
			@endif
		@else
			@if(get_option('backend_direction') == "rtl")
			<link rel="stylesheet" href="{{ asset('public/backend/assets/css/rtl/style.css?v=1.0') }}">
			@endif
		@endif

		@include('layouts.others.languages')
    </head>

    <body>
		<!-- Main Modal -->
		<div id="main_modal" class="modal" tabindex="-1" role="dialog">
		    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
				    <div class="modal-header">
						<h5 class="modal-title ml-2"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true"><i class="ti-close text-danger"></i></span>
						</button>
				    </div>

				    <div class="alert alert-danger d-none mt-3 mx-4 mb-0"></div>
				    <div class="alert alert-primary d-none mt-3 mx-4 mb-0"></div>
				    <div class="modal-body overflow-hidden"></div>

				</div>
		    </div>
		</div>

		<!-- Secondary Modal -->
		<div id="secondary_modal" class="modal" tabindex="-1" role="dialog">
		    <div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				    <div class="modal-header">
						<h5 class="modal-title ml-2"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true"><i class="ti-close text-danger"></i></span>
						</button>
				    </div>

				    <div class="alert alert-danger d-none mt-3 mx-4 mb-0"></div>
				    <div class="alert alert-primary d-none mt-3 mx-4 mb-0"></div>
				    <div class="modal-body overflow-hidden"></div>
				</div>
		    </div>
		</div>

		<!-- Preloader area start -->
		<div id="preloader">
			<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
		</div>
		<!-- Preloader area end -->

		@php $user_type = auth()->user()->user_type; @endphp

		<div class="page-container">
		    <!-- sidebar menu area start -->
			<div class="sidebar-menu">
				@if($user_type == 'user')
				<div class="extra-details">
					<img class="sidebar-logo" src="{{ asset('public/uploads/media/' . request()->activeBusiness->logo) }}" alt="logo">

					<div class="sidebar-header d-flex justify-content-center">
						<a href="{{ route('dashboard.index') }}" class="dropdown-toggle business-switch" data-toggle="dropdown">
							<h4 class="text-white d-flex align-items-center"><span>{{ request()->activeBusiness->name }}</span><i class="fa fa-angle-down ml-1"></i></h4>
						</a>
						<div class="dropdown-menu">
							@foreach(request()->businessList as $business)
							<a class="dropdown-item" href="{{ route('business.switch_business', $business->id) }}">
								<i class="{{ request()->activeBusiness->id == $business->id ? 'fas fa-check-circle text-primary' : 'far fa-circle' }}"></i>
								<span class="ml-2 {{ request()->activeBusiness->id == $business->id ? 'text-primary font-weight-bold' : '' }}">{{ $business->name }}</span>
							</a>
							@endforeach
						</div>
					</div>
				</div>
				@elseif($user_type == 'admin')
				<div class="extra-details">
					<a href="{{ route('dashboard.index') }}">
						<img class="sidebar-logo" src="{{ get_logo() }}" alt="logo">
					</a>
				</div>
				@endif

				<div class="main-menu">
					<div class="menu-inner">
						<nav>
							<ul class="metismenu {{ $user_type == 'user' && !request()->isOwner ? 'staff-menu' : '' }}" id="menu">
							@if($user_type == 'user')
								@include('layouts.menus.'.(request()->isOwner ? 'user' : 'staff'))
							@else
								@include('layouts.menus.'.Auth::user()->user_type)
							@endif
							</ul>
						</nav>
					</div>
				</div>
			</div>
			<!-- sidebar menu area end -->

			<!-- main content area start -->
			<div class="main-content">
				<!-- header area start -->
				<div class="header-area">
					<div class="row align-items-center">
						<!-- nav and search button -->
						<div class="col-lg-6 col-4 clearfix rtl-2">
							<div class="nav-btn float-left">
								<span></span>
								<span></span>
								<span></span>
							</div>
						</div>

						<!-- profile info & task notification -->
						<div class="col-lg-6 col-8 clearfix rtl-1">

							<ul class="notification-area float-right d-flex align-items-center">
	                            <li class="dropdown d-none d-sm-inline-block">
									<div class="dropdown">
									  <a class="dropdown-toggle d-flex align-items-center" type="button" id="selectLanguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<img class="avatar avatar-xss avatar-circle mr-1" src="{{ get_language() == 'language' ? asset('public/backend/plugins/flag-icon-css/flags/1x1/us.svg') : asset('public/backend/plugins/flag-icon-css/flags/1x1/'.explode('---', get_language())[1].'.svg') }}">
										<span class="d-none d-md-inline-block">{{ explode('---', get_language())[0] }}</span>
										<i class="fa fa-angle-down ml-1"></i>
									  </a>
									  <div class="dropdown-menu" aria-labelledby="selectLanguage">
										@foreach( get_language_list() as $language )
											<a class="dropdown-item" href="{{ route('switch_language') }}?language={{ $language }}"><img class="avatar avatar-xss avatar-circle mr-1" src="{{ asset('public/backend/plugins/flag-icon-css/flags/1x1/'.explode('---', $language)[1].'.svg') }}"> {{ explode('---', $language)[0] }}</a>
										@endforeach
									  </div>
									</div>
								</li>

								{{-- @php $notifications = Auth::user()->notifications->take(15); @endphp
								<li class="dropdown d-none d-sm-inline-block">
									<i class="ti-bell dropdown-toggle" data-toggle="dropdown">
										<span>{{ $notifications->count() }}</span>
									</i>
									<div class="dropdown-menu bell-notify-box notify-box">
										<span class="notify-title text-center">
											@if($notifications->count() > 0)
											{{ _lang('You have').' '.$notifications->count().' '._lang('new notifications') }}
											@else
											{{ _lang("You don't have any new notification") }}
											@endif
										</span>
										<div class="nofity-list">
											@if($notifications->count() == 0)
												<small class="text-center d-block">{{ _lang('No Notification found') }} !</small>
											@endif

											@foreach ($notifications as $notification)
											<a href="{{ route('profile.show_notification', $notification->id) }}" class="ajax-modal-2 notify-item {{ $notification->read_at == null ? 'unread-notification' : '' }}" data-title="{{ _lang('Notification Details') }}">
												<div class="notify-thumb">
													<img src="{{ profile_picture() }}">
												</div>
												<div class="notify-text">
													<span>{{ $notification->data['message'] }}</span><br>
													<span>{{ $notification->created_at->diffForHumans() }}</span>
												</div>
											</a>
											@endforeach
										</div>
									</div>
								</li> --}}

								<li>
									<div class="user-profile">
										<h4 class="user-name dropdown-toggle" data-toggle="dropdown">
											<img class="avatar user-thumb" id="my-profile-img" src="{{ profile_picture() }}" alt="avatar"> {{ Auth::user()->name }} <i class="fa fa-angle-down"></i>
										</h4>
										<div class="dropdown-menu">
											@if(auth()->user()->user_type == 'user')
											<a class="dropdown-item" href="{{ route('membership.index') }}"><i class="ti-crown text-muted mr-2"></i>{{ _lang('My Subscription') }}</a>
											@endif

											<a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="ti-pencil text-muted mr-2"></i>{{ _lang('Profile Settings') }}</a>
											<a class="dropdown-item" href="{{ route('profile.change_password') }}"><i class="ti-exchange-vertical text-muted mr-2"></i></i>{{ _lang('Change Password') }}</a>

											@if(auth()->user()->user_type == 'admin')
											<a class="dropdown-item" href="{{ route('settings.update_settings') }}"><i class="ti-settings text-muted mr-2"></i>{{ _lang('System Settings') }}</a>
											@endif

											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="{{ route('logout') }}"><i class="ti-power-off text-muted mr-2"></i>{{ _lang('Logout') }}</a>
										</div>
									</div>
	                            </li>

	                        </ul>

						</div>
					</div>
				</div><!-- header area end -->

				<!-- page title area start -->
				@if(Request::is('dashboard'))
				<div class="page-title-area mb-3">
					<div class="row align-items-center py-3">
						<div class="col-sm-12">
							<div class="breadcrumbs-area clearfix">
								<h6 class="page-title float-left">{{ _lang('Dashboard') }}</h6>
							</div>
						</div>
					</div>
				</div><!-- page title area end -->
				@endif

				<div class="main-content-inner {{ ! Request::is('dashboard') ? 'mt-4' : '' }}">
					<div class="row">
						<div class="{{ isset($alert_col) ? $alert_col : 'col-lg-12' }}">
							<div class="alert alert-success alert-dismissible" id="main_alert" role="alert">
								<button type="button" id="close_alert" class="close">
									<span aria-hidden="true"><i class="far fa-times-circle"></i></span>
								</button>
								<span class="msg"></span>
							</div>
						</div>
					</div>

					@if(session('login_as_user') == true && session('admin') != null)
					<div class="row">
						<div class="{{ isset($alert_col) ? $alert_col : 'col-lg-12' }}">
							<div class="alert alert-warning" role="alert">
								<span><i class="fas fa-info-circle mr-2"></i>{{ _lang('Back to admin portal?') }} <a href="{{ route('users.back_to_admin') }}">{{ _lang('Click Here') }}</a></span>
							</div>
						</div>
					</div>
					@endif

					@yield('content')
				</div><!--End main content Inner-->

			</div><!--End main content-->

		</div><!--End Page Container-->

        <!-- jQuery  -->
		<script src="{{ asset('public/backend/assets/js/vendor/jquery-3.6.1.min.js') }}"></script>
		<script src="{{ asset('public/backend/assets/js/popper.min.js') }}"></script>
		<script src="{{ asset('public/backend/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('public/backend/plugins/metisMenu/metisMenu.min.js') }}"></script>
		<script src="{{ asset('public/backend/assets/js/print.js') }}"></script>
		<script src="{{ asset('public/backend/plugins/pace/pace.min.js') }}"></script>
        <script src="{{ asset('public/backend/plugins/moment/moment.js') }}"></script>

		<!-- Conditional JS -->
        @include('layouts.others.import-js')

		<script src="{{ asset('public/backend/plugins/dropify/js/dropify.min.js') }}"></script>
		<script src="{{ asset('public/backend/plugins/sweet-alert2/js/sweetalert2.min.js') }}"></script>
		<script src="{{ asset('public/backend/plugins/select2/js/select2.min.js') }}"></script>
		<script src="{{ asset('public/backend/plugins/parsleyjs/parsley.min.js') }}"></script>
		<script src="{{ asset('public/backend/plugins/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
		<script src="{{ asset('public/backend/plugins/daterangepicker/daterangepicker.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('public/backend/assets/js/scripts.js?v=1.2') }}"></script>

		@include('layouts.others.alert')

		<!-- Custom JS -->
		@yield('js-script')
    </body>
</html>
