@extends('backend.layout.template')
@section('title', 'Role')
@section('role', 'active')
@section('role_permission', 'active open')
@section('style')
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header d-flex border-top rounded-0 flex-wrap py-3 flex-column align-items-end">
                    <div class="me-5 ms-n4 pe-5 mb-n6 mb-md-0">
                    </div>
                    <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                        <div class="dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row">
                            <div class="dataTables_length mx-n2" id="DataTables_Table_0_length">
                                <label>
                                    <input type="text" class="form-control" placeholder="Search">
                                </label>
                            </div>
                            <div class="dt-buttons btn-group flex-wrap d-flex mb-6 mb-sm-0">
                                <button id="createMailerServerBtn" class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light" type="button">
                                    <span><i class="ti ti-plus me-1 ti-xs"></i>Create Role</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-datatable table-responsive dataList" id="dataList">
                    @if (session('success'))
                    <div class="col-12 px-3">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    </div>
                @endif
                    @include('backend.pages.role.showRoleList')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Track the current page globally
            let currentPage = 1;
            $('#createMailerServerBtn').click(function (e) {
                e.preventDefault();
                var downloadUrl = "{{ route('dashboard.role.create') }}";
                // Redirect to the download URL
                window.location.href = downloadUrl;
            });

            // User suspend part start
            $(document).on("click", ".suspendData", function(e) {
                e.preventDefault();
                const url = $(this).data("url");

                Swal.fire({
                    title: "Are you sure?",
                    text: "This Data will be Deleted!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Deleted the Data!",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "POST",
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire("Suspended!", response.message, "success");
                                } else {
                                    Swal.fire("Suspended!", response.message, "warning");
                                }
                                // Reload the current page after suspension
                                const CurrentPageUrl = "{{ route('dashboard.role.loadMoreRole') }}?page=" + currentPage;
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
            // User suspend part end

            //Function to fetch all data start
            function showAllData() {
                spinnershow('dataList');
                $.ajax({
                    url: "{{ route('dashboard.role.index') }}",
                    type: 'GET',
                    success: function(response) {
                        $(".dataList").html(response.data);
                    },

                    error: function(xhr, status, error) {
                        console.error("Error fetching data: ", error);
                    }
                });
            }
            //Function to fetch all data end

            //Function to fetch page number wise data start
            function fetchDataList(CurrentPageUrl) {
                const datarange = $('#dateRange').val();
                spinnershow('dataList');
                $.ajax({
                    url: CurrentPageUrl,
                    type: 'POST',
                    data: {
                        datarange: datarange,
                    },
                    success: function (response) {
                        $('.dataList').html(response.data);
                    },
                    error: function () {
                        Swal.fire("Error!", "Failed to load data. Please try again.", "error");
                    },
                });
            }
            //Function to fetch page number wise data end


            $(document).on('click', '#pagination-container a', function(e) {
                e.preventDefault();
                var CurrentPageUrl = $(this).attr('href');
                currentPage = new URL(CurrentPageUrl).searchParams.get('page') || 1;
                fetchDataList(CurrentPageUrl);
            });
        });
    </script>
@endsection
