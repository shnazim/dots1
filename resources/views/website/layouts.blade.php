<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ !isset($page_title) ? get_option('site_title', config('app.name')) : $page_title }}</title>
        <!-- Favicon-->
        <link rel="icon" type="image/png" href="{{ get_favicon() }}" />

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#f97316', // orange-500
                            secondary: '#6c757d',
                            success: '#f59e0b', // amber-500
                            info: '#ea580c', // orange-600
                            warning: '#ffc107',
                            danger: '#dc2626', // red-600
                            'navy': {
                                900: '#92400e', // amber-900
                                800: '#ea580c', // orange-800
                                700: '#c2410c', // orange-700
                            }
                        }
                    }
                }
            }
        </script>

        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" rel="stylesheet">

        <!--Google Font-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&amp;display=swap" rel="stylesheet">

        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('public/website/css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('public/website/vendors/slick/slick.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/website/vendors/slick/slick-theme.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/backend/plugins/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/website/css/styles.css') }}" rel="stylesheet" />
        @php $header_footer_settings = json_decode(get_trans_option('header_footer_page')); @endphp
        @php $header_footer_media = json_decode(get_trans_option('header_footer_page_media')); @endphp

        @include('website.custom-css')
    </head>
    <body class="d-flex flex-column h-100">
        <!--Preloader-->
        <div id="preloader">
            <div class="lds-dual-ring"></div>
        </div>

        <!--Top Navigation with Language-->
        <nav class="top-navbar">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="phone"><i class="bi bi-telephone me-2"></i> {{ @get_option('phone') ?: '+1 234 567 8900' }}</span>
                    <ul>
                        <li class="nav-item">
                            <a class="nav-link has-submenu text-white py-2 text-nowrap" href="#"><i class="bi bi-translate me-2 d-none d-lg-inline"></i> {{ @explode('---', get_language())[0] ?: 'English' }}</a>
                            <ul class="submenu">
                                @try
                                    @foreach(get_language_list() as $language)
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center" href="{{ route('switch_language') }}?language={{ $language }}">
                                        <img class="avatar avatar-xss avatar-circle me-2" src="{{ asset('public/backend/plugins/flag-icon-css/flags/1x1/'.explode('---', $language)[1].'.svg') }}"> 
                                        <span>{{ explode('---', $language)[0] }}</span>
                                    </a>
                                </li> 
                                @endforeach
                                @catch(Exception $e)
                                    <!-- Languages not available -->
                                @endtry
                            </ul>
                        </li> 
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Navigation Menu -->
        <nav class="bg-white shadow-lg border-b border-gray-200" id="main_navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="{{ url('/') }}" class="flex items-center">
                            <img src="{{ @get_logo() ?: asset('public/backend/images/company-logo.png') }}" alt="logo" class="h-8 w-auto"/>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-8">
                            <a href="{{ url('/') }}" class="text-gray-700 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ url()->current() == url('/') ? 'text-orange-600 bg-orange-50' : '' }}">
                                Home
                            </a>
                            <a href="{{ url('/pricing') }}" class="text-gray-700 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ url()->current() == url('/pricing') ? 'text-orange-600 bg-orange-50' : '' }}">
                                Pricing
                            </a>
                            <a href="{{ url('/features') }}" class="text-gray-700 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ url()->current() == url('/features') ? 'text-orange-600 bg-orange-50' : '' }}">
                                Features
                            </a>
                            <a href="{{ url('/about') }}" class="text-gray-700 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ url()->current() == url('/about') ? 'text-orange-600 bg-orange-50' : '' }}">
                                About Us
                            </a>
                            <a href="{{ url('/faq') }}" class="text-gray-700 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ url()->current() == url('/faq') ? 'text-orange-600 bg-orange-50' : '' }}">
                                FAQ
                            </a>
                            <a href="{{ url('/contact') }}" class="text-gray-700 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ url()->current() == url('/contact') ? 'text-orange-600 bg-orange-50' : '' }}">
                                Contact Us
                            </a>
                        </div>
                    </div>

                    <!-- Desktop Login Button -->
                    <div class="hidden md:block">
                        @auth
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('dashboard.index') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                    Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @endauth
                        @guest
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                    Sign Up
                                </a>
                                <a href="{{ route('login') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                    Login
                                </a>
                            </div>
                        @endguest
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button type="button" class="mobile-menu-button bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-orange-600 hover:bg-orange-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-orange-500 transition-colors duration-200" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <!-- Icon when menu is closed -->
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <!-- Icon when menu is open -->
                            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="mobile-menu hidden md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-orange-600 hover:bg-orange-50 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ url()->current() == url('/') ? 'text-orange-600 bg-orange-50' : '' }}">
                        Home
                    </a>
                    <a href="{{ url('/pricing') }}" class="text-gray-700 hover:text-orange-600 hover:bg-orange-50 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ url()->current() == url('/pricing') ? 'text-orange-600 bg-orange-50' : '' }}">
                        Pricing
                    </a>
                    <a href="{{ url('/features') }}" class="text-gray-700 hover:text-orange-600 hover:bg-orange-50 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ url()->current() == url('/features') ? 'text-orange-600 bg-orange-50' : '' }}">
                        Features
                    </a>
                    <a href="{{ url('/about') }}" class="text-gray-700 hover:text-orange-600 hover:bg-orange-50 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ url()->current() == url('/about') ? 'text-orange-600 bg-orange-50' : '' }}">
                        About Us
                    </a>
                    <a href="{{ url('/faq') }}" class="text-gray-700 hover:text-orange-600 hover:bg-orange-50 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ url()->current() == url('/faq') ? 'text-orange-600 bg-orange-50' : '' }}">
                        FAQ
                    </a>
                    <a href="{{ url('/contact') }}" class="text-gray-700 hover:text-orange-600 hover:bg-orange-50 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ url()->current() == url('/contact') ? 'text-orange-600 bg-orange-50' : '' }}">
                        Contact Us
                    </a>
                    <div class="pt-4 pb-3 border-t border-gray-200">
                        @auth
                            <div class="space-y-3">
                                <a href="{{ route('dashboard.index') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 block text-center">
                                    Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @endauth
                        @guest
                            <div class="space-y-3">
                                <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 block text-center">
                                    Sign Up
                                </a>
                                <a href="{{ route('login') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 block text-center">
                                    Login
                                </a>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-shrink-0">
            @yield('content')

            @php $gdpr_cookie_consent = json_decode(get_trans_option('gdpr_cookie_consent_page')) @endphp
            
            @if(isset($gdpr_cookie_consent->cookie_consent_status) && $gdpr_cookie_consent->cookie_consent_status == 1)
            @include('cookie-consent::index')
            @endif
        </main>
        
        <!-- Footer-->
        <footer class="footer">
            <!-- Footer Top -->
            <div class="footer-top">
                <div class="container px-4">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer about">
                                <div class="logo">
                                    <a href="#"><h4>{{ isset($header_footer_settings->widget_1_heading) ? $header_footer_settings->widget_1_heading : '' }}</h4></a>
                                </div>

                                <p class="text">{{ isset($header_footer_settings->widget_1_content) ? $header_footer_settings->widget_1_content : '' }}</p>
                                
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer links">
                                <h4>{{ isset($header_footer_settings->widget_2_heading) ? $header_footer_settings->widget_2_heading : '' }}</h4>
                                <ul>
                                    @if(isset($header_footer_settings->widget_2_menus))
                                    @foreach($header_footer_settings->widget_2_menus as $widget_2_menu)
                                        <li><a href="{{ url('/'.$widget_2_menu) }}">{{ get_page_title($widget_2_menu) }}</a></li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer links">
                                <h4>{{ isset($header_footer_settings->widget_3_heading) ? $header_footer_settings->widget_3_heading : '' }}</h4>
                                <ul>
                                    @if(isset($header_footer_settings->widget_3_menus))
                                    @foreach($header_footer_settings->widget_3_menus as $widget_3_menu)
                                        <li><a href="{{ url('/'.$widget_3_menu) }}">{{ get_page_title($widget_3_menu) }}</a></li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Footer Top -->
            <div class="copyright">
                <div class="container px-4">
                    <div class="inner">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="left">
                                    {!! isset($header_footer_settings->copyright_text) ? xss_clean($header_footer_settings->copyright_text) : '' !!}
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="right">
                                    <img src="{{ isset($header_footer_media->payment_gateway_image) ? asset('public/uploads/media/'.$header_footer_media->payment_gateway_image) : asset('public/website/assets/payment_gateways.png') }}" alt="#">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        
        <script src="{{ asset('public/website/js/jquery-3.6.3.min.js') }}"></script>
        <script src="{{ asset('public/website/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('public/website/vendors/slick/slick.min.js') }}"></script>
        <script src="{{ asset('public/backend/plugins/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
        <script src="{{ asset('public/website/js/wow.min.js') }}"></script>
        <script src="{{ asset('public/backend/plugins/sweet-alert2/js/sweetalert2.min.js') }}"></script>

        <!-- Core theme JS-->
        <script src="{{ asset('public/website/js/scripts.js') }}"></script>
        @include('website.custom-js')

        <!-- Mobile Menu JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.querySelector('.mobile-menu-button');
                const mobileMenu = document.querySelector('.mobile-menu');
                const menuIcons = mobileMenuButton.querySelectorAll('svg');

                mobileMenuButton.addEventListener('click', function() {
                    // Toggle mobile menu visibility
                    mobileMenu.classList.toggle('hidden');
                    
                    // Toggle menu icons
                    menuIcons.forEach(icon => {
                        icon.classList.toggle('hidden');
                        icon.classList.toggle('block');
                    });

                    // Update aria-expanded attribute
                    const isExpanded = !mobileMenu.classList.contains('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', isExpanded);
                });

                // Close mobile menu when clicking on a link
                const mobileMenuLinks = mobileMenu.querySelectorAll('a');
                mobileMenuLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.add('hidden');
                        menuIcons[0].classList.remove('hidden');
                        menuIcons[0].classList.add('block');
                        menuIcons[1].classList.add('hidden');
                        menuIcons[1].classList.remove('block');
                        mobileMenuButton.setAttribute('aria-expanded', 'false');
                    });
                });

                // Close mobile menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                        menuIcons[0].classList.remove('hidden');
                        menuIcons[0].classList.add('block');
                        menuIcons[1].classList.add('hidden');
                        menuIcons[1].classList.remove('block');
                        mobileMenuButton.setAttribute('aria-expanded', 'false');
                    }
                });
            });
        </script>
    </body>
</html>
