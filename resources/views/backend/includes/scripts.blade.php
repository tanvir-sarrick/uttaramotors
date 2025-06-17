    <script src="{{ asset('backend/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/libs/hammer/hammer.js') }}"></script>
    {{-- <script src="{{ asset('backend/assets/vendor/libs/i18n/i18n.js') }}"></script> --}}
    <script src="{{ asset('backend/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ asset('backend/assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->



    <!-- Main JS -->
    <script src="{{ asset('backend/assets/js/main.js') }}"></script>
    {{-- <script src="{{ asset('backend/assets/js/custom.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function () {

        });
    </script>



@yield('script')
