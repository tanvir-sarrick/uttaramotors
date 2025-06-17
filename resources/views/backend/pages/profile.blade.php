@extends('backend.layout.template')
@section('title')
    My-Profile
@endsection
@section('home', 'active')
@section('style')
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/%40form-validation/form-validation.css') }}">
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-6">
          <!-- Account -->
          <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-6">
              <img src="{{ $admin->image ? asset('backend/assets/img/avatars/' . $admin->image) : asset('backend/assets/img/avatars/1.png') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar">
              <div class="button-wrapper">
                <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                  <span class="d-none d-sm-block">Upload new photo</span>
                  <i class="ti ti-upload d-block d-sm-none"></i>
                  <input type="file" id="upload" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                </label>
                <button type="button" class="btn btn-label-secondary account-image-reset mb-4" id="reset">
                  <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                  <span class="d-none d-sm-block">Reset</span>
                </button>

                <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
              </div>
            </div>
          </div>
          <div class="card-body pt-4">
            <form id="formAccountSettings">
              <div class="row">
                <div class="mb-4 col-md-6">
                  <label for="firstName" class="form-label">Full Name</label>
                  <input class="form-control" type="text" id="firstName" name="name" value="{{ $admin->name }}" autofocus="">
                </div>
                <div class="mb-4 col-md-6">
                  <label for="email" class="form-label">E-mail</label>
                  <input class="form-control" type="text" id="email" name="email" value="{{ $admin->email }}" placeholder="john.doe@example.com">
                </div>
              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-3">Save changes</button>
              </div>
            </form>
          </div>
          <!-- /Account -->
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
            $('#uploadedAvatar').attr('src', "{{ asset('backend/assets/img/avatars/1.png') }}");
        });
      $('#formAccountSettings').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData();
        formData.append('name', $('#firstName').val());
        formData.append('email', $('#email').val());
        formData.append('_token', '{{ csrf_token() }}'); // CSRF token

        let fileInput = $('#upload')[0];
        let file = fileInput.files[0];
        if (file) {
            formData.append('image', file);
        }

        // Send AJAX request
        $.ajax({
            url: "{{ route('admin.dashboard.updateprofile') }}", // Your route for updating profile
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert('Profile updated successfully.');
                    window.location.href = response.redirect;
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Show validation errors
                    let errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        alert(`${field}: ${errors[field][0]}`); // You can improve this to show errors near each field
                    }
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
      });
    });
</script>
@endsection
