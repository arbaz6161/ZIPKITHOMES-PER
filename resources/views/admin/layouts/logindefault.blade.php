<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title')</title>

<link href="/assets/img/favicon.png" rel="shortcut icon" type="image/png">
<link href="{{ asset('css/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.bundle.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/main_client.css') }}">
<link rel="stylesheet" type="text/css" href="/css/superadmin/custom.css">
<link rel="stylesheet" type="text/css" href="/css/admin/custom.css">

@yield('css')

<body>
    @yield('content')

    <script src="{{ asset('js/plugins.bundle.js') }}"></script>
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

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
    @yield('scripts')

</html>