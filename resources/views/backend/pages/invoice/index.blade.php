@php
    $user = Auth::guard('web')->user();
@endphp
@extends('backend.layout.template')
@section('title', 'All Invoice')
@section('all_invoice', 'active')
@section('invoice', 'active open')
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
                            <h4 class="mb-0">All Invoices</h4>
                        </div>

                        <!-- Filters and Button aligned right -->
                        <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                            <div
                                class="dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row">
                                <div class="dataTables_length mx-n2" id="DataTables_Table_0_length">
                                    <label>
                                        <input type="text" id="filterData" class="form-control" name="filterData"
                                            placeholder="Search By Invoice No./ Dealer Code" style="width: 270px;"
                                            autocomplete="off">
                                    </label>
                                    {{-- <label>
                                        <input type="text" class="form-control" placeholder="Search By Dealer">
                                    </label> --}}
                                </div>
                                @if ($user->can('invoice.import'))
                                    <div class="dt-buttons btn-group flex-wrap d-flex mb-6 mb-sm-0">
                                        <button id="importInvoiceBtn"
                                            class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light"
                                            type="button">
                                            <span><i class="ti ti-plus me-1 ti-xs"></i>Import Invoice</span>
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
                        @include('backend.pages.invoice.showInvoiceList')
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
            // Track the current page globally
            let currentPage = 1;

            // Import Invoice page Start
            $('#importInvoiceBtn').click(function(e) {
                e.preventDefault();
                var redirectUrl = "{{ route('dashboard.invoice.import_index') }}";
                window.location.href = redirectUrl;
            });
            // Import Invoice page End

            // Invoice Delete part start
            $(document).on("click", "#confirmDeleteBtn", function(e) {
                e.preventDefault();

                const url = $(this).data("url");
                const invoiceNumber = $("#invoice_number").val();
                const CurrentPageUrl = "{{ route('dashboard.invoice.loadMoreData') }}?page=" + currentPage;

                Swal.fire({
                    title: "Are you sure?",
                    text: "This invoice will be deleted!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                invoice_number: invoiceNumber,
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire("Deleted!", response.message, "success");
                                    fetchDataList(CurrentPageUrl);
                                } else {
                                    Swal.fire("Warning", response.message, "warning");
                                    fetchDataList(CurrentPageUrl);
                                }
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
            // Invoice Delete part end

            //Function to fetch page number wise data start
            function fetchDataList(CurrentPageUrl) {
                const filterData = $('#filterData').val();
                spinnershow('dataList');
                $.ajax({
                    url: CurrentPageUrl,
                    type: 'POST',
                    data: {
                        filterData: filterData,
                        // currentPage: currentPage
                    },
                    success: function(response) {
                        // $('.dataList').html(response.data);
                        const html = response.data;
                        const count = response.count ?? 0;

                        if (count === 0) {
                            // If current page is empty and not first page, go back one page
                            if (currentPage > 1) {
                                currentPage--;
                                const CurrentPageUrl =
                                    "{{ route('dashboard.invoice.loadMoreData') }}?page=" + currentPage;
                                fetchDataList(CurrentPageUrl); // retry with previous page
                            } else {
                                $('.dataList').html(html);
                            }
                        } else {
                            $('.dataList').html(html);
                        }
                    },
                    error: function() {
                        Swal.fire("Error!", "Failed to load data. Please try again.", "error");
                    },
                });
            }

            //Function to fetch page number wise data end
            $(document).on('keyup', '#filterData', function() {
                var filterData = $(this).val();
                var url = "{{ route('dashboard.invoice.filterData') }}";
                spinnershow('dataList');
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        filterData: filterData,
                    },
                    success: function(res) {
                        $('.dataList').html(res.data);
                    }
                });

            });

            $(document).on('click', '#pagination-container a', function(e) {
                e.preventDefault();
                var CurrentPageUrl = $(this).attr('href');
                currentPage = new URL(CurrentPageUrl).searchParams.get('page');
                fetchDataList(CurrentPageUrl);
            });
        });
    </script>
@endsection
