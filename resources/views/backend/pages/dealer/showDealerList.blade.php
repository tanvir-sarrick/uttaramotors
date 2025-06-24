@if ($dealers->count() > 0)
<table class="datatables-customers table border-top">
    <thead>
      <tr>
        <th class="text-nowrap">Sl#</th>
        <th class="text-nowrap">Dealer Code</th>
        <th class="text-nowrap">Dealer Name</th>
        <th class="text-nowrap">Status</th>
        <th class="text-nowrap">Action</th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @php
            $s= 1;
        @endphp
        @foreach ($dealers as $dealer)
            <tr>
                <th scope="row">{{ $s }}</th>
                <td>{{ $dealer->dealer_code }}</td>
                <td>{{ $dealer->dealer_name }}</td>
                <td>
                    @if ($dealer->status === 1)
                    <span class="tb-status text-success">Active</span>
                    @else
                        <span class="tb-status text-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex align-items-center">
                      <a href="{{ route('dashboard.dealer.edit', $dealer->id) }}" class="btn btn-info btn-text-secondary rounded-pill waves-effect btn-icon delete-record">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      <a class="btn btn-danger btn-text-secondary rounded-pill waves-effect btn-icon delete-record">
                        <button style="line-height: 20px!important" type="button" class="btn btn-sm btn-danger btn-text-secondary rounded-pill waves-effect btn-icon delete-record softDeleteData" data-url="{{ route('dashboard.dealer.softdelete', $dealer->id) }}">
                            <i class="fas fa-trash-alt" ></i>
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
    {{ $dealers->links('backend.pagination.custom', ['paginator' => $dealers->onEachSide(1)->withQueryString()->setPageName('page')->setPath(route('dashboard.dealer.loadMoreItem'))]) }}
</div>
@else
{{-- No Data --}}
@endif
