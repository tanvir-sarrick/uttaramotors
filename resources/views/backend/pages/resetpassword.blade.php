@extends('backend.layout.template')
@section('title', 'Reset Password')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex border-top rounded-0 flex-wrap py-3 align-items-center">
                <!-- Left side: Header -->
                <div class="flex-grow-1">
                    <h5 class="mb-0">Reset Password</h4>
                </div>

                <!-- Right side: Back button -->
                <div class="d-flex justify-content-end align-items-baseline">
                    <div class="dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row">
                        <div class="dt-buttons btn-group flex-wrap d-flex mb-6 mb-sm-0">
                            <button id="BackBtn" class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light" type="button">
                                <span><i class="ti ti-arrow-left me-1 ti-xs"></i>Back</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                {{-- Flash Messages --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST" class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate>
                    @csrf

                    <div class="row">
                        <div class="mb-6 col-md-6 form-password-toggle">
                            <label class="form-label" for="current_password">Current Password</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control @error('current_password') is-invalid @enderror" type="password" name="current_password" id="current_password" placeholder="············">
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-6 col-md-6 form-password-toggle">
                            <label class="form-label" for="password">New Password</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" placeholder="············">
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-6 col-md-6 form-password-toggle">
                            <label class="form-label" for="password_confirmation">Confirm New Password</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="············">
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-danger me-3 waves-effect waves-light">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        setTimeout(function () {
            $('#success-alert').fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
            $('#error-alert').fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 3000);

        $('#BackBtn').click(function (e) {
            e.preventDefault();
            var downloadUrl = "{{ route('dashboard.password.index') }}";
            // Redirect to the download URL
            window.location.href = downloadUrl;
        });
    });
</script>
@endsection
