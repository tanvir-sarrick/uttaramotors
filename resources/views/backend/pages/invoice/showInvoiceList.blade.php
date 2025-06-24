@if ($invoices->count() > 0)
    <table class="datatables-customers table border-top">
        <thead>
            <tr>
                <th class="text-nowrap">Sl#</th>
                <th class="text-nowrap">Invoice Number</th>
                <th class="text-nowrap">Dealer Name</th>
                <th class="text-nowrap">Total Quantity</th>
                <th class="text-nowrap">Total Amount</th>
                <th class="text-nowrap">Action</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @php
                $s = 1;
            @endphp
            @foreach ($invoices as $invoice)
                <tr>
                    <th scope="row">{{ $s }}</th>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->dillear_id }}</td>
                    <td>{{ $invoice->total_qty }}</td>
                    <td>{{ $invoice->total_amount }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href=""
                                class="btn btn-info btn-text-secondary rounded-pill waves-effect btn-icon delete-record">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a
                                class="btn btn-danger btn-text-secondary rounded-pill waves-effect btn-icon delete-record">
                                <button style="line-height: 20px!important" type="button"
                                    class="btn btn-sm btn-danger btn-text-secondary rounded-pill waves-effect btn-icon delete-record suspendData"
                                    data-url="">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </a>
                        </div>
                    </td>
                </tr>
                @php
                    $s++;
                @endphp
            @endforeach
        </tbody>
    </table>
    <div id="pagination-container">
        {{-- Render Custom Pagination --}}
        {{ $invoices->links('backend.pagination.custom', ['paginator' => $invoices->onEachSide(1)->withQueryString()->setPageName('page')->setPath(route('dashboard.invoice.loadMoreData'))]) }}
    </div>
@else
@endif
