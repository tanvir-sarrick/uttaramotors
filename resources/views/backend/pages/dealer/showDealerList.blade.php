@php
    $user = Auth::guard('web')->user();
@endphp
<table class="datatables-customers table table-striped text-center">
    <thead class="table-dark">
        <tr>
            <th class="text-nowrap">Sl#</th>
            <th class="text-nowrap">Dealer Code</th>
            <th class="text-nowrap">Dealer Name</th>
            <th class="text-nowrap">Status</th>
            @if ($user->can('dealer.edit') || $user->can('dealer.delete'))
                <th class="text-nowrap">Action</th>
            @endif
        </tr>
    </thead>

    <tbody class="table-border-bottom-0">
        @if ($dealers->count() > 0)
            @php $s = 1; @endphp
            @foreach ($dealers as $dealer)
                <tr>
                    <th scope="row">{{ $s }}</th>
                    <td>{{ $dealer->dealer_code }}</td>
                    <td>{{ $dealer->dealer_name }}</td>
                    <td>
                        @if ($dealer->status === 1)
                            <span class="badge bg-label-success me-1">Active</span>
                        @else
                            <span class="badge bg-label-danger me-1">Inactive</span>
                        @endif
                    </td>
                    @if ($user->can('dealer.edit') || $user->can('dealer.delete'))
                        <td>
                            <div class="">
                                @if ($user->can('dealer.edit'))
                                    <a href="{{ route('dashboard.dealer.edit', $dealer->id) }}"
                                        class="btn btn-sm btn-info btn-text-secondary rounded-pill waves-effect btn-icon">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                @endif
                                @if ($user->can('dealer.delete'))
                                    <button type="button"
                                        class="btn btn-sm btn-danger btn-text-secondary rounded-pill waves-effect btn-icon softDeleteData"
                                        data-url="{{ route('dashboard.dealer.softdelete', $dealer->id) }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    @endif
                </tr>
                @php $s++; @endphp
            @endforeach
        @else
            <tr>
                <td colspan="5">
                    <div class="card bg-light p-3 text-center">
                        <strong>No Dealers Found</strong>
                    </div>
                </td>
            </tr>
        @endif
    </tbody>
</table>

<div id="pagination-container" style="margin-top: 10px;">
    {{ $dealers->links('backend.pagination.custom', [
        'paginator' => $dealers->onEachSide(1)->withQueryString()->setPageName('page')->setPath(route('dashboard.dealer.loadMoreDealer')),
    ]) }}
</div>
