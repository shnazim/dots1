<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ get_favicon() }}">

    <title>{{ get_option('site_title', config('app.name')) }}</title>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('public/auth/css/app.css?v=1.1') }}" rel="stylesheet">
    <link href="{{ asset('public/backend/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- Custom CSS for Google button -->
    <style>
        .google-btn-container {
            margin-top: 1.5rem;
        }
        .google-btn-divider {
            position: relative;
            margin: 1.5rem 0;
            text-align: center;
        }
        .google-btn-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #d1d5db;
        }
        .google-btn-divider span {
            position: relative;
            background-color: white;
            padding: 0 0.75rem;
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .google-btn {
            width: 100%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            background-color: white;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s ease-in-out;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            font-family: 'Google Sans', 'Roboto', Arial, sans-serif;
        }
        .google-btn:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
            color: #111827;
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        }
        .google-btn:active {
            transform: translateY(0);
        }
        .google-btn svg {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.75rem;
        }
        
        /* Enhanced form styling for register page */
        .form-signup .form-control {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            transition: all 0.15s ease-in-out;
        }
        .form-signup .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .form-signup .btn-login {
            border-radius: 0.5rem;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.15s ease-in-out;
        }
        .form-signup .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        /* Select2 styling for country codes */
        .select2-container--default .select2-selection--single {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            height: 3rem;
            padding: 0.5rem 1rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            padding-left: 0;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 3rem;
        }
    </style>
    
    @yield('css')
</head>
<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
	
    <script src="{{ asset('public/backend/assets/js/vendor/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: true
            });
        });
    </script>
	@yield('js-script')
</body>
</html>
