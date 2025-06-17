<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide">
  <head>
    @include('backend.auth.includes.header')
    @include('backend.auth.includes.css')
  </head>

  <body>
    @yield('content')

    <!-- Core JS -->
    @include('backend.auth.includes.scripts')
  </body>
</html>
