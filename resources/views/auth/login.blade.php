@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-signin p-3 my-5">
                <div class="card-body">
					<img class="logo" src="{{ get_logo() }}">
					
					<h5 class="text-center py-4">{{ _lang('Login To Your Account') }}</h4> 
					
                    @if(Session::has('error'))
                        <div class="alert alert-danger text-center">
                            <strong>{{ session('error') }}</strong>
                        </div>
                    @endif
					
					@if(Session::has('registration_success'))
                        <div class="alert alert-success text-center">
                            <strong>{{ session('registration_success') }}</strong>
                        </div>
                    @endif

                    @if(Session::has('success'))
                        <div class="alert alert-success text-center">
                            <strong>{{ session('success') }}</strong>
                        </div>
                    @endif

					<form method="POST" class="form-signin" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ _lang('Email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
						    <div class="col-md-12">	

								<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ _lang('Password') }}" autocomplete="" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="hidden" name="g-recaptcha-response" id="recaptcha">
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
						<div class="text-center">
							<div class="custom-control custom-checkbox mb-3">
								<input type="checkbox" name="remember" class="custom-control-input" id="remember" {{ old('remember') ? 'checked' : '' }}>
								<label class="custom-control-label" for="remember">{{ _lang('Remember Me') }}</label>
							</div>
						</div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ _lang('Login') }}
                                </button>

                                @if(get_option('member_signup') == 1)
                                    <a href="{{ route('register') }}" class="btn btn-link btn-register">{{ _lang('Create Account') }}</a>
								@endif							
                            </div>
                        </div>

                        @if(get_option('google_login_enabled', 0) == 1)
                        <div class="mt-6">
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-2 bg-white text-gray-500">{{ _lang('Or login with') }}</span>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <a href="{{ route('social.login', 'google') }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out rounded-md">
                                    <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                    </svg>
                                    {{ _lang('Continue with Google') }}
                                </a>
                            </div>
                        </div>
                        @endif
						
						
						<div class="form-group row mt-3">
                            <div class="col-md-12">
								<a class="btn-link" href="{{ route('password.request') }}">
									{{ _lang('Forgot Password?') }}
								</a>
							</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@if(get_option('enable_recaptcha', 0) == 1)
<script src="https://www.google.com/recaptcha/api.js?render={{ get_option('recaptcha_site_key') }}"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('{{ get_option('recaptcha_site_key') }}', {action: 'login'}).then(function(token) {
        if (token) {
            document.getElementById('recaptcha').value = token;
        }
        });
    });
</script>
@endif
@endsection