@extends('backend.layout.template')
@section('title', 'My-Profile')

@section('style')
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/@form-validation/form-validation.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-6">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('backend/assets/img/avatars/1.png') }}"
                            alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar">

                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload new photo</span>
                                <i class="ti ti-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" name="photo" class="account-file-input" hidden accept="image/*">
                            </label>
                            <button type="button" class="btn btn-label-secondary mb-4" id="reset">
                                <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button>

                            <div>Allowed JPG or PNG. Max size of 800K</div>
                            @error('photo') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-4 col-md-6">
                            <label for="firstName" class="form-label">Full Name</label>
                            <input class="form-control" type="text" id="firstName" name="name" value="{{ old('name', $user->name) }}">
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input class="form-control" type="text" id="email" value="{{ $user->email }}" disabled>
                        </div>
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-3">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Optional image preview
    $('#upload').on('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
            $('#uploadedAvatar').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    $('#reset').on('click', function () {
        $('#upload').val('');
        $('#uploadedAvatar').attr('src', "{{ $user->photo ? asset('storage/' . $user->photo) : asset('backend/assets/img/avatars/1.png') }}");
    });

    $(document).ready(function () {
        setTimeout(function () {
            $('#success-alert').fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 3000);
    });
</script>
@endsection
