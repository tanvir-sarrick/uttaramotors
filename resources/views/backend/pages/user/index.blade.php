@extends('backend.layout.template')
@section('title', 'Users')
@section('Users', 'active')
@section('style')
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
    /* .select2-container .select2-selection--single .select2-selection__rendered {
        padding-top: 5px;
    } */
    /* .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px;
    } */
</style>
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
                                <label style="margin: 0px 15px;">Date Range:</label>
                                <label>
                                    <select class="form-select" id="dateRange" name="datarange">
                                        <option value="all" >All</option>
                                        <option value="daily" >Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="yearly">Yearly</option>
                                    </select>
                                </label>
                                <label style="margin: 0px 15px;">Country:</label>
                                <label>
                                    <select class="form-select-lg" id="countryFilter" name="country_name">
                                        <option value="">All</option>
                                        @php
                                        $all_countries_array = [];
                                        foreach ($all_countries as $single_country){
                                            if( $single_country != '' && !in_array($single_country, $all_countries_array) ){
                                                $selected = '';
                                                // if($single_country == $country){
                                                //     $selected = 'selected';
                                                // }
                                        @endphp
                                            <option value="{{ $single_country }}" {{ $selected; }}>{{ $single_country }}</option>
                                        @php
                                                array_push($all_countries_array, $single_country);
                                            }
                                        }
                                        @endphp
                                    </select>
                                </label>
                            </div>
                            <div class="dt-buttons btn-group flex-wrap d-flex mb-6 mb-sm-0">
                                <button id="downloadUserBtnTxt" class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light" type="button">
                                    <span><i class="ti ti-upload me-1 ti-xs"></i>Export TXT</span>
                                </button>
                            </div>
                            <div class="dt-buttons btn-group flex-wrap d-flex mb-6 mb-sm-0">
                                <button id="downloadUserBtnCsv" class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light" type="button">
                                    <span><i class="ti ti-upload me-1 ti-xs"></i>Export CSV</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-datatable table-responsive dataList" id="dataList">
                    @include('backend.pages.user.showUserList')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#countryFilter").select2({
            allowClear: true,

        });
    </script>
    <script>
        $(document).ready(function() {
            // Track the current page globally
            let currentPage = 1;
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
                                const CurrentPageUrl = "{{ route('admin.dashboard.user.loadMoreUser') }}?page=" + currentPage;
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
                    url: "{{ route('admin.dashboard.user.index') }}",
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
                var countryFilter = $('#countryFilter').val();
                spinnershow('dataList');
                $.ajax({
                    url: CurrentPageUrl,
                    type: 'POST',
                    data: {
                        datarange: datarange,
                        countryFilter: countryFilter,
                    },
                    success: function (response) {
                        $('.dataList').html(response.data);
                        $('#dateRange').val(res.dateRange);
                        $('#countryFilter').val(res.countryFilter);
                    },
                    error: function () {
                        Swal.fire("Error!", "Failed to load data. Please try again.", "error");
                    },
                });
            }
            //Function to fetch page number wise data end


            // Filter Date Range
            $('#dateRange, #countryFilter').change(function(e) {
                var datarange = $('#dateRange').val();
                var countryFilter = $('#countryFilter').val();

                var url = "{{ route('admin.dashboard.user.filterUser') }}";
                spinnershow('dataList');
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        datarange: datarange,
                        countryFilter: countryFilter,
                    },
                    success: function(res) {
                        $('.dataList').html(res.data);
                        $('#dateRange').val(res.dateRange);
                        $('#countryFilter').val(res.countryFilter);
                    }
                });

            });


            $(document).on('click', '#pagination-container a', function(e) {
                e.preventDefault();
                var CurrentPageUrl = $(this).attr('href');
                currentPage = new URL(CurrentPageUrl).searchParams.get('page') || 1;
                fetchDataList(CurrentPageUrl);
            });

            $('#downloadUserBtnTxt').click(function (e) {
                e.preventDefault();
                // Get the selected date range
                var datarange = $('#dateRange').val();
                var countryFilter = $('#countryFilter').val();

                // Construct the URL with query parameters
                //var downloadUrl = "{{ route('admin.dashboard.user.download.txt') }}?datarange=" + datarange;
                var downloadUrl = "{{ route('admin.dashboard.user.download.txt') }}?datarange=" + encodeURIComponent(datarange) + "&countryFilter=" + encodeURIComponent(countryFilter);

                // Redirect to the download URL
                window.location.href = downloadUrl;
            });

            $('#downloadUserBtnCsv').click(function (e) {
                e.preventDefault();
                // Get the selected date range
                var datarange = $('#dateRange').val();
                var countryFilter = $('#countryFilter').val();

                // Construct the URL with query parameters
                var downloadUrl = "{{ route('admin.dashboard.user.download.csv') }}?datarange=" + encodeURIComponent(datarange) + "&countryFilter=" + encodeURIComponent(countryFilter);
                // Redirect to the download URL
                window.location.href = downloadUrl;
            });
        });
    </script>
@endsection
