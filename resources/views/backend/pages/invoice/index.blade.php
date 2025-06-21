@extends('backend.layout.template')
@section('title', 'Permission')
@section('invoice', 'active')
@section('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .custom {
            text-transform: capitalize;
        }

        .permission {
            font-size: 12px;
            line-height: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable">
                    <div class="card-header d-flex border-top rounded-0 flex-wrap py-3 flex-column align-items-end">
                        <div class="me-5 ms-n4 pe-5 mb-n6 mb-md-0">
                        </div>
                        <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                            <div
                                class="dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row">
                                <div class="dataTables_length mx-n2" id="DataTables_Table_0_length">
                                    <label>
                                        <input type="text" class="form-control" placeholder="Search">
                                    </label>
                                </div>
                                <div class="dt-buttons btn-group flex-wrap d-flex mb-6 mb-sm-0">
                                    <button id="BackInvoiceBtn"
                                        class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light"
                                        type="button">
                                        <span><i class="ti ti-arrow-back-up me-1 ti-xs"></i>Back</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dataList" id="dataList">
                        @if (session('failures'))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach (session('failures') as $failure)
                                        <li>
                                            Row {{ $failure->row() }}:
                                            @foreach ($failure->errors() as $error)
                                                {{ $error }}<br>
                                            @endforeach
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="col-12 px-3">
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    </button>
                                </div>
                            </div>
                        @endif
                        <div class="col-12 col-xl-12 px-3">
                            <div class="card shadow-none bg-label-warning">
                                <div class="card-body">
                                    <h4 class="card-title text-warning text-center mb-0">Invoice Import</h4>
                                    <p class="card-text mb-0" style="padding-bottom: 3px;">- Some quick example text to
                                        build on the card title and make
                                        up.
                                    </p>
                                    <p class="card-text mb-0" style="padding-bottom: 3px;">- Some quick example text to
                                        build on the card title and make
                                        up.
                                    </p>
                                    <p class="card-text mb-0" style="padding-bottom: 3px;">- Some quick example text to
                                        build on the card title and make
                                        up.
                                    </p>
                                    <p class="card-text ">- Some quick example text to build on the card title and make up.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
