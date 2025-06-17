@extends('backend.layout.template')
@section('title')
    Change-Password
@endsection
@section('home', 'active')
@section('style')
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/%40form-validation/form-validation.css') }}">
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Reset Password</h5>
            <div class="card-body">
              <div class="mb-6 col-12 mb-0">
                <div class="alert alert-warning">
                  <h5 class="alert-heading mb-1">Are you sure you want to reset your password?</h5>
                  <p class="mb-0">If YES, please click the button below.</p>
                </div>
              </div>
              <form id="formResetPassword">
                <div class="form-check my-8">
                  <input class="form-check-input" type="checkbox" name="accountResetPassword" id="accountResetPassword">
                  <label class="form-check-label" for="accountActivation">I confirm my account reset password</label>
                </div>
                <button type="submit" class="btn btn-danger deactivate-accountResetPassword" disabled="">Reset Password</button>
              </form>
            </div>
          </div>
      </div>
</div>
@endsection

@section('script')
<script src="{{ asset('backend/assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/%40form-validation/popular.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/%40form-validation/bootstrap5.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/%40form-validation/auto-focus.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/cleavejs/cleave.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
{{-- <script src="{{ asset('backend/assets/js/pages-account-settings-account.js') }}"></script> --}}
<script>
    $(document).ready(function () {
        $('#accountResetPassword').on('change', function () {
            if ($(this).is(':checked')) {
                $('.deactivate-accountResetPassword').removeAttr('disabled'); // Enable button
            } else {
                $('.deactivate-accountResetPassword').attr('disabled', 'disabled'); // Disable button
            }
        });
    });
</script>
@endsection
