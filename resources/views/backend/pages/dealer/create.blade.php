@extends('backend.layout.template')
@section('title', 'Dealers')
@section('dealer', 'active')
@section('active_open', 'active open')
@section('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

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
                    <h4 class="mb-0">Add New Dealer</h4>
                </div>

                <!-- Right side: Back button -->
                <div class="d-flex justify-content-end align-items-baseline">
                    <div class="dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row">
                        <div class="dt-buttons btn-group flex-wrap d-flex mb-6 mb-sm-0">
                            <button id="BackDealerBtn" class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light" type="button">
                                <span><i class="ti ti-arrow-left me-1 ti-xs"></i>Back</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <form class="form" action="{{ route('dashboard.dealer.store') }}" method="post">
                @csrf
                <div class="row mx-3">
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="dealer_code" class="form-label">Dealer Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="dealer_code" name="dealer_code" value="{{ old('dealer_code') }}" placeholder="Enter Dealer Code">
                            @error('dealer_code')
                                <span class="text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="dealer_name" class="form-label">Dealer Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="dealer_name" name="dealer_name" value="{{ old('dealer_name') }}" placeholder="Enter Dealer Name">
                            @error('dealer_name')
                                <span class="text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <select class="form-select js-select2" name="status" id="status"
                                    data-placeholder="Select status">
                                    <option value="" disabled>-- Select --</option>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label"></label>
                            <button class="btn btn-primary me-3 mt-6 waves-effect waves-light" type="submit">Save</button>
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
            $('#BackDealerBtn').click(function (e) {
                e.preventDefault();
                var downloadUrl = "{{ route('dashboard.dealer.index') }}";
                // Redirect to the download URL
                window.location.href = downloadUrl;
            });
        });
    </script>
@endsection
