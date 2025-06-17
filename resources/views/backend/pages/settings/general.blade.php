@extends('backend.layout.template')
@section('title')
    General-Settings
@endsection
@section('settings', 'active')
@section('style')
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/%40form-validation/form-validation.css') }}">
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        @if (Session::has('success'))
            <div class="row">
                <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                </div>
            </div>
        @endif
    </div>
    <div class="col-6 mb-5">
        <div class="card">
            <div class="card-body">
                <div class="col-12 mb-0">
                    <div class="alert alert-info" style="padding: 5px;text-align:center;">
                    <h6 class="alert-heading m-0">App Name</h6>
                    </div>
                </div>
                <form class="settings-form" method="POST" action="{{ route('admin.dashboard.settings.app_name.set') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="appName" class="form-label">App Name</label>
                        <input type="text" class="form-control" id="appName" name="app_name"
                            value="{{ get_settings('app_name') ?? '' }}" required>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-6 mb-5">
        <div class="card">
            <div class="card-body">
                <div class="col-12 mb-0">
                    <div class="alert alert-info" style="padding: 5px;text-align:center;">
                    <h6 class="alert-heading m-0">WhatsApp Number</h6>
                    </div>
                </div>
                <form class="settings-form" method="POST" action="{{ route('admin.dashboard.settings.whatsapp.set') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="whatsapp" class="form-label">Whats App Number</label>
                        <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                            value="{{ get_settings('whatsapp_number') ?? '' }}" required>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-6 mb-5">
        <div class="card">
            <div class="card-body">
                <div class="col-12 mb-0">
                    <div class="alert alert-info" style="padding: 5px;text-align:center;">
                    <h6 class="alert-heading m-0">App Logo</h6>
                    </div>
                </div>
                <form class="settings-form" method="POST" action="{{ route('admin.dashboard.settings.app_logo.set') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 mb-0">
                        <div class="d-flex align-items-start align-items-sm-center gap-6">
                        <img src="{{ get_settings('app_logo') ? asset('backend/assets/img/' . get_settings('app_logo')) : asset('backend/assets/img/avatars/1.png') }}" alt="{{ get_settings('app_icon') ?? '' }}" alt="{{ get_settings('app_logo') ?? '' }}" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar">
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-success me-3 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo</span>
                            <i class="ti ti-upload d-block d-sm-none"></i>
                            <input type="file" id="upload" name="app_logo" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                            </label>
                            <button type="button" class="btn btn-label-secondary account-image-reset mb-4" id="reset">
                            <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                            </button>
                        </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-6 mb-5">
        <div class="card">
            <div class="card-body">
                <div class="col-12 mb-0">
                    <div class="alert alert-info" style="padding: 5px;text-align:center;">
                    <h6 class="alert-heading m-0">App Logo</h6>
                    </div>
                </div>
                <form class="settings-form" method="POST" action="{{ route('admin.dashboard.settings.app_icon.set') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 mb-0">
                        <div class="d-flex align-items-start align-items-sm-center gap-6">
                        <img src="{{ get_settings('app_icon') ? asset('backend/assets/img/' . get_settings('app_icon')) : asset('backend/assets/img/avatars/1.png') }}" alt="{{ get_settings('app_icon') ?? '' }}" class="d-block w-px-100 h-px-100 rounded" id="uploadedApp_icon">
                        <div class="button-wrapper">
                            <label for="upload_icon" class="btn btn-success me-3 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo</span>
                            <i class="ti ti-upload d-block d-sm-none"></i>
                            <input type="file" id="upload_icon" name="app_icon" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                            </label>
                            <button type="button" class="btn btn-label-secondary account-image-reset mb-4" id="reset_icon">
                            <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                            </button>
                        </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-6 mb-5">
        <div class="card">
            <div class="card-body">
                <div class="col-12 mb-0">
                    <div class="alert alert-info" style="padding: 5px;text-align:center;">
                    <h6 class="alert-heading m-0">Meta Tags</h6>
                    </div>
                </div>
                <form class="settings-form" method="POST" action="{{ route('admin.dashboard.settings.meta_tags.set') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="appName" class="form-label">Meta Tags
                            <span class="text-warning">
                                (Please write them as comma (,) separeted text)</span></label>
                        <input type="text" class="form-control" id="meta_tags" name="meta_tags"
                            value="{{ get_settings('meta_tags') ?? '' }}" required>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
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
        $(document).on('change', '#upload', function() {
            const file = this.files[0]; // Get the selected file
            if (file) {
                // Update the span inside the label with the file name
                $('#account-file-input').text(file.name);
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#uploadedAvatar').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        $(document).on('click', '#reset', function() {
            $('#upload').val('');
            // Revert the avatar to the default image
            // Check if `get_settings('app_icon')` is available
            var appIcon = "{{ get_settings('app_logo') ? asset('backend/assets/img/' . get_settings('app_logo')) : asset('backend/assets/img/avatars/1.png') }}";
            // Update the avatar with the appropriate image
            $('#uploadedAvatar').attr('src', appIcon);
        });

        $(document).on('change', '#upload_icon', function() {
            const file = this.files[0]; // Get the selected file
            if (file) {
                // Update the span inside the label with the file name
                $('#account-file-input').text(file.name);
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#uploadedApp_icon').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        $(document).on('click', '#reset_icon', function() {
            $('#upload_icon').val('');
            // Revert the avatar to the default image
            var appIcon = "{{ get_settings('app_icon') ? asset('backend/assets/img/' . get_settings('app_icon')) : asset('backend/assets/img/avatars/1.png') }}";
            // Update the avatar with the appropriate image
            $('#uploadedApp_icon').attr('src', appIcon);

        });
    });
</script>

@endsection
