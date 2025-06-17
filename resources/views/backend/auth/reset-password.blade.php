@extends('backend.auth.layout.template')
@section('title')
    Reset Password
@endsection
@section('content')
    <!-- Content Start -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
          <div class="authentication-inner py-6">
            <!-- Reset Password -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-6">
                        <a href="index.html" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <svg width="32" height="22" viewbox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0"></path>
                                <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616"></path>
                                <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="#7367F0"></path>
                            </svg>
                        </span>
                        <span class="app-brand-text demo text-heading fw-bold">Vuexy</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-1">Reset Password 🔒</h4>
                    <p class="mb-6"><span class="fw-medium">Your new password must be different from previously used passwords</span></p>
                    <form action="{{ route('admin.auth.password.store') }}" method="POST">
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

                        <button class="btn btn-primary d-grid w-100 mb-6">
                            Set new password
                        </button>

                        <div class="text-center">
                            <a href="{{ route('admin.auth.login') }}">
                                <i class="ti ti-chevron-left scaleX-n1-rtl me-1_5"></i>
                                Back to login
                            </a>
                        </div>
                    </form>
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

