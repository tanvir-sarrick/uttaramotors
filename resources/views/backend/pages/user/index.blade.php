@php
    $usr = Auth::guard('web')->user();
@endphp
@extends('backend.layout.template')
@section('title', 'Users')
@section('user', 'active')
@section('settings', 'active open')
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

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable table-responsive">
                    <div class="card-header d-flex border-top rounded-0 flex-wrap py-3 align-items-center">
                        <!-- Header Title aligned left -->
                        <div class="flex-grow-1">
                            <h4 class="mb-0">Users</h4>
                        </div>

                        <!-- Filters and Button aligned right -->
                        <div
                            class="d-flex flex-column flex-md-row align-items-end align-items-md-center justify-content-md-end">
                            <div
                                class="dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row">
                                <div class="dataTables_length mx-n2" id="DataTables_Table_0_length">
                                    <label>
                                        <input type="text" id="filterData" name="filterData" class="form-control"
                                            placeholder="Search By User Name/Email" style="width: 240px;"
                                            autocomplete="off">
                                    </label>

                                    <label>
                                        <select class="form-select js-select2" name="status" id="filterStatus"
                                            data-placeholder="Select Status">
                                            <option value="2">All Users</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </label>
                                </div>
                                @if ($usr->can('user.create'))
                                    <div class="dt-buttons btn-group flex-wrap d-flex mb-6 mb-sm-0">
                                        <button id="createUserBtn"
                                            class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light"
                                            type="button">
                                            <span><i class="ti ti-plus me-1 ti-xs"></i>Create User</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-datatable table-responsive dataList pb-0" id="dataList">
                        @if (session('success'))
                            <div class="col-12 px-3">
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    </button>
                                </div>
                            </div>
                        @endif
                        @include('backend.pages.user.showUserList')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Track The Current Page Globally
            let currentPage = 1;

            $('#createUserBtn').click(function(e) {
                e.preventDefault();
                window.location.href = "{{ route('dashboard.user.create') }}";
            });

            // User Soft Delate part start
            $(document).on("click", ".softDeleteData", function(e) {
                e.preventDefault();
                const url = $(this).data("url");

                Swal.fire({
                    title: "Are you sure?",
                    text: "This Data will be Soft Deleted!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Soft Deleted the Data!",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "GET",
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire("Soft Deleted!", response.message,
                                        "success");
                                } else {
                                    Swal.fire("Soft Deleted!", response.message,
                                        "warning");
                                }
                                const CurrentPageUrl =
                                    "{{ route('dashboard.user.loadMoreUser') }}?page=" +
                                    currentPage;
                                fetchDataList(CurrentPageUrl);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire("Error!",
                                    "Something went wrong. Please try again.",
                                    "error");
                            },
                        });
                    }
                });
            });
            // Dealer Soft Delate part end

            $(document).on('click', '#pagination-container a', function(e) {
                e.preventDefault();
                var CurrentPageUrl = $(this).attr('href');
                currentPage = new URL(CurrentPageUrl).searchParams.get('page') || 1;
                fetchDataList(CurrentPageUrl);
            });

            //Function To Fetch Page Number Wise Data Start
            function fetchDataList(CurrentPageUrl) {
                const filterData = $('#filterData').val();
                const status = $('#filterStatus').val();
                spinnershow('dataList');
                $.ajax({
                    url: CurrentPageUrl,
                    type: 'POST',
                    data: {
                        filterData: filterData,
                        status: status,
                    },
                    success: function(response) {
                        $('.dataList').html(response.data);
                    },
                    error: function() {
                        Swal.fire("Error!", "Failed to load data. Please try again.", "error");
                    },
                });
            }
            //Function To Fetch Page Number Wise Data End

            //Filter User data by name or email start
            $(document).on('keyup', '#filterData', function() {
                var status = $('#filterStatus').val();
                var filterData = $(this).val();
                var url = "{{ route('dashboard.user.filterUserData') }}";
                spinnershow('dataList');
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        filterData: filterData,
                        status: status
                    },
                    success: function(res) {
                        $('.dataList').html(res.data);
                    }
                });

            });
            //Filter User data by name or email end

            //Filter User data by status start
            $(document).on('change', '#filterStatus', function() {
                var filterData = $('#filterData').val();
                var status = $(this).val();

                var url = "{{ route('dashboard.user.filterUserData') }}";
                spinnershow('dataList');
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        filterData: filterData,
                        status: status
                    },
                    success: function(res) {

                        $('.dataList').html(res.data);
                    }
                });

            });
            ////Filter User data by status start
        });
    </script>
@endsection
