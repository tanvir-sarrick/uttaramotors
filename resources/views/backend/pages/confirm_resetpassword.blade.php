@extends('backend.layout.template')
@section('title', 'Change-Password')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Reset Password</h5>
            <div class="card-body">
                <div class="mb-4 col-12">
                    <div class="alert alert-warning">
                        <h5 class="alert-heading mb-1">Are you sure you want to reset your password?</h5>
                        <p class="mb-0">If YES, please click the button below.</p>
                    </div>
                </div>

                <div class="form-check my-4">
                    <input class="form-check-input" type="checkbox" id="accountResetPassword">
                    <label class="form-check-label" for="accountResetPassword">I confirm that I want to reset my password</label>
                </div>

                <a href="{{ route('dashboard.password.reset') }}"
                class="btn btn-danger deactivate-accountResetPassword disabled"
                id="resetPasswordLink"
                onclick="return !this.classList.contains('disabled');">
                Reset Password
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            const $checkbox = $('#accountResetPassword');
            const $button = $('#resetPasswordLink');

            $checkbox.on('change', function () {
            $button.toggleClass('disabled', !$(this).is(':checked'));
            });
        });
    </script>
@endsection
