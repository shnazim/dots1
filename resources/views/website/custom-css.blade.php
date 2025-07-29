@php 
$header_color = isset($header_footer_settings->top_header_color) ? $header_footer_settings->top_header_color : '#f97316';
$footer_color = isset($header_footer_settings->footer_color) ? $header_footer_settings->footer_color : '#92400e';
$custom_css = isset($header_footer_settings->custom_css) ? $header_footer_settings->custom_css : '';
@endphp

<style type="text/css">
    .top-navbar {
        background-color: {{ $header_color }};
    }
    .footer {
        background: {{ $footer_color }};
    }

    /* Orange Theme Overrides */
    .btn-primary {
        background-color: #f97316 !important;
        border-color: #f97316 !important;
    }
    
    .btn-primary:hover {
        background-color: #ea580c !important;
        border-color: #ea580c !important;
    }
    
    .text-primary {
        color: #f97316 !important;
    }
    
    .bg-primary {
        background-color: #f97316 !important;
    }
    
    .border-primary {
        border-color: #f97316 !important;
    }
    
    .focus\:ring-primary:focus {
        --tw-ring-color: #f97316 !important;
    }
    
    .focus\:border-primary:focus {
        border-color: #f97316 !important;
    }

    {{ $custom_css }}
</style>