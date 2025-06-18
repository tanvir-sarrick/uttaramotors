
@if ($all_roles->count() > 0)
<table class="datatables-customers table border-top">
    <thead>
        <tr>
            <th>SL.</th>
            <th>Role/Position</th>
            <th>Permissions</th>
            <th class="text-nowrap">ACTION</th>
        </tr>
    </thead>

    <tbody class="table-border-bottom-0">
        @php
            $s= 1;
        @endphp
        @foreach ($all_roles as $data)
            <tr>
                <th scope="row">{{ $s }}</th>
                <td>{{ $data->name }}</td>
                <td>
                    @if (  $data->permissions == null)
                    <p>no role</p>
                    @else
                        @foreach ($data->permissions as $perm)
                        <span class="badge bg-label-success mr-2 my-1">
                            {{ $perm->name }}
                        </span>
                        @endforeach
                    @endif
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.role.edit', $data->id) }}" class="btn btn-info btn-text-secondary" style="margin-right: 5px;">
                            Edit
                        </a>

                        <a href="" class="btn btn-danger btn-text-secondary suspendData" data-url="{{ route('dashboard.role.destroy', $data->id) }}">
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
    {{ $all_roles->links('backend.pagination.custom', ['paginator' => $all_roles->onEachSide(1)->withQueryString()->setPageName('page')->setPath(route('dashboard.role.loadMoreRole'))]) }}
</div>
@else
@endif


