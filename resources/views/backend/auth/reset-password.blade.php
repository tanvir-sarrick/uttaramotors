@extends('backend.auth.layout.template')
@section('title')
    Reset Password
@endsection
@section('content')
    <!-- Content Start -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
          <div class="authentication-inner">
            <!-- Reset Password -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                        <div class="mb-3 text-center">
                            <img src="{{ asset('backend/assets/img/uttara_logo.png') }}" alt="Brand Logo" class="img-fluid" style="max-height: 70px;">
                        </div>
                    <!-- /Logo -->

                    <h4 class="mb-1">Reset Password 🔒</h4>
                    <p class="mb-6"><span class="fw-medium">Your new password must be different from previously used passwords</span></p>
                    <form action="{{ route('password.store') }}" method="POST">
                        @csrf
                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <input type="hidden" name="email" value="{{ $request->email }}">

                        <div class="mb-4 form-password-toggle">
                            <label class="form-label" for="password">New Password</label>
                            <div class="input-group input-group-merge mb-1">
                                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password">
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            @error('password')
                                <p class="text-danger" style="margin: 0px;padding-left: 5px; font-size: 14px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6 form-password-toggle">
                            <label class="form-label" for="confirm-password">Confirm Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="confirm-password" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password">
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary d-grid w-100 mb-6">Change Password</button>
                    </form>
                    
                    <div class="text-center">
                        <a href="{{ route('login') }}">
                            <i class="ti ti-chevron-left scaleX-n1-rtl me-1_5"></i>Back to login
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Reset Password -->
          </div>
        </div>
    </div>
    <!-- Content End-->
@endsection

@section('script')

@endsection

