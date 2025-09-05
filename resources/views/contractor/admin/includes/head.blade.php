<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title')</title>

<!-- <link rel="canonical" href="https://keenthemes.com/metronic" /> -->
<link href="{{ asset('img/favicon.png') }}" rel="shortcut icon" type="image/png">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
<link href="{{ asset('css/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('../css/custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('../css/slideshow.css') }}" rel="stylesheet" type="text/css" />
<meta charset="utf-8">

<link href="{{ asset('css/style.bundle.admin.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/lightbox.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/header/base/light.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/brand/dark.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/aside/dark.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('../css/admin/custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/wizard.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('css/themify-icons.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" />
<style>
    .bg-info-error {
        background-color: #0f2c4d !important;
    }

    .hidden-input {
        display: none;
    }
</style>
<!------ChartJS----->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<!-- Tiny MCE script -->
<script src="https://cdn.tiny.cloud/1/{{ config('services.tinymce.api_key') }}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '.my-mce-editor',  // Initializes TinyMCE on all <textarea> elements with the 'my-editor' class
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    });
</script>
