@extends('backend.layout.template')
@section('title', 'Users')
@section('user', 'active')
@section('settings', 'active open')
@section('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet">

    <style>
        .custom-control-label {
            text-transform: capitalize;
        }
        .custom-control-label::before {
            background-color: #fff;
        }
    </style>

@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex border-top rounded-0 flex-wrap py-3 align-items-center">
                <!-- Left side: Header -->
                <div class="flex-grow-1">
                    <h4 class="mb-0">Edit User</h4>
                </div>

                <!-- Right side: Back button -->
                <div class="d-flex justify-content-end align-items-baseline">
                    <div class="dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row">
                        <div class="dt-buttons btn-group flex-wrap d-flex mb-6 mb-sm-0">
                            <button id="BackUserBtn" class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light" type="button">
                                <span><i class="ti ti-arrow-left me-1 ti-xs"></i>Back</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <form class="form" action="{{ route('dashboard.user.update', $user->id) }}" method="post">
                @csrf
                <div class="row mx-3 mb-5">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" placeholder="Enter Name" required="">
                            @error('name')
                                <span class="text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" placeholder="Enter Email Address">
                            @error('email')
                                <span class="text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password" autocomplete="new-password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            @error('password')
                                <span class="text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">Confirm Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password_confirmation" autocomplete="new-password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            @error('password_confirmation')
                                <span class="text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="roles" class="form-label">Assign Roles <span class="text-danger">*</span></label>
                            <select class="form-select" name="roles">
                                <option value="">All User Roles</option>
                                @foreach ($all_roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                                <span class="text-danger mt-2">{{ $message }}</span>
                            @enderror

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <select class="form-select js-select2" name="status" id="status" data-placeholder="Select status">
                                    <option value="" disabled>-- Select --</option>
                                    <option value="1" @if ($user->status === 1) selected @endif>Active</option>
                                    <option value="0" @if ($user->status === 0) selected @endif>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label"></label>
                            <button class="btn btn-primary me-3 mt-3 waves-effect waves-light" type="submit">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#BackUserBtn').click(function (e) {
                e.preventDefault();
                var downloadUrl = "{{ route('dashboard.user.index') }}";
                // Redirect to the download URL
                window.location.href = downloadUrl;
            });
        });
    </script>
@endsection
