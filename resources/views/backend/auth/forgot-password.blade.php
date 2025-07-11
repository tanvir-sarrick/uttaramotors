@extends('backend.auth.layout.template')
@section('title')
    Forgot Password
@endsection
@section('content')
    <!-- Content Start -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Forgot Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Brand Logo -->
                        <div class="mb-3 text-center">
                            <img src="{{ asset('backend/assets/img/uttara_logo.png') }}" alt="Brand Logo" class="img-fluid" style="max-height: 70px;">
                        </div>

                        <h4 class="mb-1">Forgot Password? 🔒</h4>
                        <p class="mb-6">Enter your email and we'll send you instructions to reset your password</p>
                        @if (session('status'))
                            <div class="text-success mb-2">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="mb-6" action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{ old("email") }}" autofocus="">
                                @error('email')
                                    <p class="text-danger" style="margin: 0px;padding-left: 5px; font-size: 14px;">{{ $message }}</p>
                                @enderror
                            </div>
                            <button class="btn btn-primary d-grid w-100">Send Reset Link</button>
                        </form>
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="d-flex justify-content-center">
                                <i class="ti ti-chevron-left scaleX-n1-rtl me-1_5"></i>Back to login
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password -->
            </div>
        </div>
    </div>
    <!-- Content End-->
@endsection

@section('script')

@endsection

