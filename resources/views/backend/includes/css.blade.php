
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/fonts/fontawesome.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('backend/assets/vendor/fonts/tabler-icons.css') }}"> --}}
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/fonts/flag-icons.css') }}">

    <!-- Core CSS -->

    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/rtl/core.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/rtl/theme-default.css') }}">

    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo.css') }}">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/node-waves/node-waves.css') }}">

    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/typeahead-js/typeahead.css') }}">


    <!-- Page CSS -->


    <!-- Helpers -->
    <script src="{{ asset('backend/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    {{-- <script src="{{ asset('backend/assets/vendor/js/template-customizer.js') }}"></script> --}}

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('backend/assets/js/config.js') }}"></script>

    <style>
        .app-brand-logo.demo {
            width: auto;
            height: auto;
        }
    </style>
    @yield('style')
