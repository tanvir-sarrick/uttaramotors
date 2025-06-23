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
                        <div class="p-4">
                            @if($invoices->count() <= 0)
                                <!-- Info Card -->
                                <div class="card shadow-sm border-0 bg-label-warning mb-4">
                                    <div class="card-body">
                                        <h4 class="card-title text-warning text-center mb-3">Invoice Import</h4>
                                        <ul class="mb-0 ps-3">
                                            <li class="mb-1">Some quick example text to build on the card title and make up.</li>
                                            <li class="mb-1">Some quick example text to build on the card title and make up.</li>
                                            <li class="mb-1">Some quick example text to build on the card title and make up.</li>
                                            <li>Some quick example text to build on the card title and make up.</li>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            <!-- Alerts -->
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <strong>Whoops!</strong> Please fix the following issues:
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Import Form -->
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    @if($invoices->count() <= 0)
                                        <form action="{{ route('invoices.import') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row g-3">
                                                <!-- Select Dealer -->
                                                <div class="col-md-6">
                                                    <label for="dealerSelect" class="form-label fw-semibold">Select Dealer <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="dealerSelect" name="dealer_id" required>
                                                        <option value="" disabled selected>-- Choose a Dealer --</option>
                                                        <option value="1">Dealer One</option>
                                                        <option value="2">Dealer Two</option>
                                                        <option value="3">Dealer Three</option>
                                                        <!-- Load dynamically if needed -->
                                                    </select>
                                                </div>

                                                <!-- Upload File -->
                                                <div class="col-md-6">
                                                    <label for="excelFile" class="form-label fw-semibold">
                                                        Upload Excel File <span class="text-danger">*</span>
                                                        <small class="text-muted">(Accepted: .xlsx, .xls)</small>
                                                    </label>
                                                    <input type="file" name="file" id="excelFile" class="form-control" accept=".xls,.xlsx" required>
                                                </div>

                                                <!-- Submit Button -->
                                                <div class="col-12 text-end mt-2 px-5">
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="tf-icons ti ti-file-import me-1"></i> Import User Data
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                    @if($invoices->count() > 0)
                                    @php
                                        $totalQty = $invoices->sum('qty');
                                        $totalRate = $invoices->sum('rate'); // optional, usually not summed
                                        $totalAmount = $invoices->sum('amount');
                                    @endphp
                                    <table class="table table-bordered mt-3">
                                        <thead>
                                            <tr class="table-secondary">
                                                <th>SN.</th>
                                                <th>Brand</th>
                                                <th>Part ID</th>
                                                <th>Description</th>
                                                <th>Qty</th>
                                                <th>Rate</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($invoices as $user)
                                                <tr>
                                                    <td>{{ $user->sl_no }}</td>
                                                    <td>{{ $user->brand }}</td>
                                                    <td>{{ $user->part_id }}</td>
                                                    <td>{{ $user->description }}</td>
                                                    <td>{{ $user->qty }}</td>
                                                    <td>{{ number_format($user->rate, 2) }}</td>
                                                    <td>{{ number_format($user->amount, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="fw-bold table-warning">
                                                <td colspan="4" class="text-end">Total</td>
                                                <td>{{ $totalQty }}</td>
                                                <td>-</td>
                                                <td>{{ number_format($totalAmount, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <div class="d-flex justify-content-end gap-2 mt-3">
                                        <!-- Print Button -->
                                        <a href=""
                                        target="_blank"
                                        class="btn btn-outline-primary">
                                            <i class="ti ti-printer me-1"></i> Print PDF
                                        </a>

                                        <!-- Download Button -->
                                        <a href="" class="btn btn-primary">
                                            <i class="ti ti-download me-1"></i> Download PDF
                                        </a>

                                        <!-- Clear Button -->
                                        <form id="clearInvoiceForm" action="{{ route('dashboard.invoice.clear') }}" method="POST">
                                            @csrf
                                            <button type="button" class="btn btn-danger" id="confirmClearBtn">
                                                <i class="ti ti-trash me-1"></i> Clear Data
                                            </button>
                                        </form>
                                    </div>
                                    @endif
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

    <script>
        document.getElementById('confirmClearBtn').addEventListener('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently clear all invoice data.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, clear it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('clearInvoiceForm').submit();
                }
            });
        });
    </script>

@endsection
