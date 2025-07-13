@php
    $user = Auth::guard('web')->user();
@endphp
<table class="datatables-customers table table-striped text-center">
    <thead class="table-dark">
        <tr>
            <th class="text-nowrap">Sl#</th>
            <th class="text-nowrap">Invoice Number</th>
            <th class="text-nowrap">Dealer Code</th>
            <th class="text-nowrap">Total Quantity</th>
            <th class="text-nowrap">Total Amount</th>
            @if ($user->can('invoice.print') || $user->can('invoice.delete'))
                <th class="text-nowrap">Action</th>
            @endif
        </tr>
    </thead>

    <tbody class="table-border-bottom-0">
        @if ($invoices->count() > 0)
            @php $s = 1; @endphp
            @foreach ($invoices as $invoice)
                <tr>
                    <th scope="row">{{ $s }}</th>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->dealer->dealer_code }}</td>
                    <td>{{ $invoice->total_qty }}</td>
                    <td>{{ $invoice->total_amount }}</td>
                    @if ($user->can('invoice.print') || $user->can('invoice.delete'))
                        <td>
                            <div class="">
                                <!-- Print Button -->
                                @if ($user->can('invoice.print'))
                                    <form action="{{ route('dashboard.invoicePrint.print') }}" method="GET"
                                        target="_blank" style="display: inline-block; margin-right: 5px;">
                                        <input type="hidden" name="invoice_number"
                                            value="{{ $invoice->invoice_number }}">
                                        <button type="submit"
                                            class="btn btn-sm btn-success btn-text-secondary rounded-pill waves-effect btn-icon printSticker">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                    </form>
                                @endif
                                <!-- Delete Button -->
                                @if ($user->can('invoice.delete'))
                                    <form id="deleteInvoiceForm" style="display: inline-block;">
                                        <input type="hidden" name="invoice_number" id="invoice_number"
                                            value="{{ $invoice->invoice_number }}">
                                        <button type="button"
                                            class="btn btn-sm btn-danger btn-text-secondary rounded-pill waves-effect btn-icon"
                                            id="confirmDeleteBtn" data-url="{{ route('dashboard.invoice.delete') }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    @endif
                </tr>
                @php $s++; @endphp
            @endforeach
        @else
            <tr>
                <td colspan="6">
                    <div class="card bg-light p-3 text-center">
                        <strong>No Invoices Found</strong>
                    </div>
                </td>
            </tr>
        @endif
    </tbody>
</table>

<div id="pagination-container" style="margin-top: 10px;">
    {{ $invoices->links('backend.pagination.custom', [
        'paginator' => $invoices->onEachSide(1)->withQueryString()->setPageName('page')->setPath(route('dashboard.invoice.loadMoreData')),
    ]) }}
</div>
