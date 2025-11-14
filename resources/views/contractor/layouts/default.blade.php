<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include("contractor.includes.head")
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body id="kt_body" class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading">
    <div id="kt_header_mobile" class="header-mobile">
        <a href="http://zipkithomes.com/">
                @isset($contractor->logo)
                    <img src="{{ $contractor->logo }}" class="logo-default max-h-40px" alt="Logo">
                @else
                    <img src="{{ asset('img/client/cropped-zipkit-logo.png') }}" class="logo-default max-h-40px"
                        alt="Myplanbase Logo">
                    @endif
        </a>
        <div class="d-flex align-items-center">
            <button class="btn p-0 burger-icon-left ml-4" id="kt_header_mobile_toggle">
                <span class="svg-icon svg-icon-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <title>Stockholm-icons / Text / Text-width</title>
                        <desc>Created with Sketch.</desc>
                        <defs></defs>
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"></rect>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M22 11.5C22 12.3284 21.3284 13 20.5 13H3.5C2.6716 13 2 12.3284 2 11.5C2 10.6716 2.6716 10 3.5 10H20.5C21.3284 10 22 10.6716 22 11.5Z" fill="black"></path>
                            <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M14.5 20C15.3284 20 16 19.3284 16 18.5C16 17.6716 15.3284 17 14.5 17H3.5C2.6716 17 2 17.6716 2 18.5C2 19.3284 2.6716 20 3.5 20H14.5ZM8.5 6C9.3284 6 10 5.32843 10 4.5C10 3.67157 9.3284 3 8.5 3H3.5C2.6716 3 2 3.67157 2 4.5C2 5.32843 2.6716 6 3.5 6H8.5Z" fill="black"></path>
                        </g>
                    </svg>
                </span>
            </button>
        </div>
    </div>
    <div class="d-flex flex-column flex-root">
        <div class="">
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                @include("contractor.includes.header")
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding: 0%">
                    @yield('subheader')
                    <div class="">
                        @yield('content')
                    </div>
                </div>
                @include("contractor.includes.footer")
            </div>
        </div>
    </div>
    <div id="kt_scrolltop" class="scrolltop">
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <polygon points="0 0 24 0 24 24 0 24" />
                    <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
                    <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
                </g>
            </svg>
        </span>
    </div>
    <script>
        // var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";
        var HOST_URL="";
    </script>
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1200
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#FFFFFF",
                        "primary": "#6993FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#F3F6F9",
                        "dark": "#212121"
                    },
                    "light": {
                        "white": "#FFFFFF",
                        "primary": "#E1E9FF",
                        "secondary": "#ECF0F3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#FFFFFF",
                        "primary": "#FFFFFF",
                        "secondary": "#212121",
                        "success": "#FFFFFF",
                        "info": "#FFFFFF",
                        "warning": "#FFFFFF",
                        "danger": "#FFFFFF",
                        "light": "#464E5F",
                        "dark": "#FFFFFF"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#ECF0F3",
                    "gray-300": "#E5EAEE",
                    "gray-400": "#D6D6E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#80808F",
                    "gray-700": "#464E5F",
                    "gray-800": "#1B283F",
                    "gray-900": "#212121"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <script src="{{ asset('js/plugins.bundle.js') }}"></script>
    <script src="{{ asset('js/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('js/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('js/widgets.js') }}"></script>
    <script src="{{ asset('../js/custom.js') }}"></script>
    <script src="{{ asset('js/re-capcha.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.2/alpine.min.js" defer></script>

    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.v3_site_key') }}"></script>
    <script>
        grecaptcha.ready(function() {
            // The "action" can be any string that helps you identify the action in analytics
            grecaptcha.execute('{{ config('services.recaptcha.v3_site_key') }}', {action: 'contact_form'}).then(function(token) {
                // Store the token in the hidden field
                document.getElementById('g-recaptcha-response').value = token;
            });
        });
    </script>

    <form id="delete-form" method="POST" style="margin-bottom: 0px;">
        @csrf
        @method('DELETE')
    </form>

    @stack('scripts')
</body>

</html>
