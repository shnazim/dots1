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
    
    <!-- Custom CSS for Google button -->
    <style>
        .google-btn-container {
            margin-top: 1.5rem;
        }
        .google-btn-divider {
            position: relative;
            margin: 1.5rem 0;
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
            padding: 0 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
        }
        .google-btn {
            width: 100%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background-color: white;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s ease-in-out;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .google-btn:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
            color: #111827;
            text-decoration: none;
        }
        .google-btn svg {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.75rem;
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
	@yield('js-script')
</body>
</html>
