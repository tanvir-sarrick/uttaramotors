@extends('backend.auth.layout.template')
@section('title')
    Login
@endsection
@section('content')
    <!-- Content Start -->
    <div class="authentication-wrapper authentication-cover">
        <div class="authentication-inner row m-0">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-8 p-0">
            <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
                <img src="{{  asset('backend/assets/img/backgrounds/Uttara-LoginBg.png') }}" alt="auth-login-cover" class="my-5" style="width: 590px; height: auto;">
            </div>
            </div>
            <!-- /Left Text -->

            <!-- Login -->
            <div class="d-flex col-12 col-lg-4 align-items-center authentication-bg p-sm-12">
                <div class="w-px-400 mx-auto mt-12 pt-5">
                    <!-- Brand Logo -->
                    <div class="mb-3 text-center">
                        <img src="{{ asset('backend/assets/img/uttara_logo.png') }}" alt="Brand Logo" class="img-fluid" style="max-height: 80px;">
                    </div>

                    <h4 class="mb-1">Login 👋</h4>
                    @if (session('status'))
                        <div class="text-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="mb-6" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required autofocus autocomplete="username">
                            @error('email')
                                <span class="mt-2 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-6 form-password-toggle">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required autocomplete="current-password">
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            @error('password')
                                <span class="mt-2 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-8">
                            <div class="d-flex justify-content-between">
                                <div class="form-check mb-0 ms-2">
                                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                    <label class="form-check-label" for="remember_me">Remember Me</label>
                                </div>
                                <a href="{{ route('password.request') }}">
                                    <p class="mb-0">Forgot Password?</p>
                                </a>
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100" id="adminlogin">
                            Log in
                        </button>
                    </form>
                </div>
            </div>

            <!-- /Login -->
        </div>
    </div>
    <!-- Content End-->
@endsection
@section('script')
    <script>

    </script>
@endsection

