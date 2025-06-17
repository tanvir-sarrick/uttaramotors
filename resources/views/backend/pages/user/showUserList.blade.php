
@if ($users->count() > 0)
    <table class="datatables-customers table border-top">
        <thead>
            <tr>
                <th class="text-nowrap">Sl#</th>
                <th class="text-nowrap">Name</th>
                <th class="text-nowrap">Email</th>
                <th class="text-nowrap">Country Name</th>
                <th class="text-nowrap">Mobile</th>
                <th class="text-nowrap">Added date</th>
                <th class="text-nowrap">Action</th>
            </tr>
        </thead>

        <tbody class="table-border-bottom-0">
            @php
                $s= 1;
            @endphp
            @foreach ($users as $data)
                <tr>
                    <th scope="row">{{ $s }}</th>
                    <td class="cell"><span>{{ $data->name }}</span></td>
                    <td class="cell"><span>{{ $data->email }}</span></td>
                    <td class="cell"><span>{{ $data->country_name }}</span></td>
                    <td class="cell"><span>{{ $data->mobile }}</span></td>
                    <td class="cell"><span>{{ $data->created_at }}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="" class="btn btn-danger btn-text-secondary suspendData" data-url="{{ route('admin.dashboard.user.destroy', $data->id) }}">
                                Delete
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
        {{ $users->links('backend.pagination.custom', ['paginator' => $users->onEachSide(1)->withQueryString()->setPageName('page')->setPath(route('admin.dashboard.user.loadMoreUser'))]) }}
    </div>
@else

@endif


