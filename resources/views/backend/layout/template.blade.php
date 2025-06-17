<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact">
    <head>
        @include('backend.includes.header')
        @include('backend.includes.css')
    </head>

    <body>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar ">
            <div class="layout-container">
                <!-- Menu -->
                @include('backend.includes.sidebar')
                <!-- / Menu -->
                <!-- Layout container -->
                <div class="layout-page">
                    <!-- Navbar -->
                    @include('backend.includes.topbar')
                    <!-- / Navbar -->
                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            @yield('content')
                        </div>
                        <!-- / Content -->
                        <!-- Footer -->
                        @include('backend.includes.footer')
                        <!-- / Footer -->
                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>
            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
            <!-- Drag Target Area To SlideIn Menu On Small Screens -->
            <div class="drag-target"></div>
        </div>
        <!-- / Layout wrapper -->

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        @include('backend.includes.scripts')
    </body>
</html>

<!-- beautify ignore:end -->

