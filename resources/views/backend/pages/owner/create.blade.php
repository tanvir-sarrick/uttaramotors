@extends('admin.layout.template')
@section('title')
    Create Owner
@endsection
@section('open')
    active open
@endsection
@section('create')
    active
@endsection

@section('content')
    <h6 class="fw-bold"><span class="text-muted fw-light"></span> Create Owner</h6>

    <!-- Basic Layout -->
    <div class="row d-flex justify-content-center">
        <div class="col-lg-9">
            <div class="card mb-4">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">Company Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="form-control" id="basic-default-company" placeholder="Enter Company Name" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Email Address <span
                                    class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <input type="text" id="email" class="form-control"
                                    placeholder="Enter Email Address" />
                                <span class="input-group-text" id="basic-default-email2">@example.com</span>
                            </div>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="············">
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">Confirm Password <span
                                    class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password_confirmation" class="form-control"
                                    name="password_confirmation" placeholder="············">
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-phone">Phone No</label>
                            <input type="text" id="phone" class="form-control phone-mask"
                                placeholder="Enter Phone Number" />
                        </div>
                        <button data-url="{{ route('admin.owner.store') }}" id="submit_now" type="submit" class="btn btn-primary float-end">Submit Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#submit_now').click(function (e) {
            e.preventDefault();

            var url             = $(this).data('url');
            var name            = $('#name').val();
            var email           = $('#email').val();
            var password        = $('#password').val();
            var password_confirmation = $('#password_confirmation').val();
            var phone           = $('#phone').val();


            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    name,
                    email,
                    password,
                    password_confirmation,
                    phone
                },
                success: function (response) {
                    if (response.success) {
                            toastr.success(response.message);

                            setTimeout(function () {
                                window.location.href = '{{ route('admin.owner.index') }}'; // Replace with your actual redirect URL
                            }, 3000);
                        }

                        else {
                            toastr.error(response.message);
                        }
                },

                error: function (xhr, status, error) {
                    // Handle validation error messages
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        var keys = Object.keys(errors);

                        keys.forEach(function (key, index) {
                            setTimeout(function () {
                                toastr.error(errors[key]);
                            }, index * 1000); // Set the delay in milliseconds
                        });
                    }

                    else {
                        toastr.error('An error occurred while processing your request.');
                    }
                }
            });
        });
    });
</script>
@endsection
