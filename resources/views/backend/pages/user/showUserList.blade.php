<table class="datatables-customers table table-striped text-center">
    <thead class="table-dark">
        <tr>
            <th class="text-nowrap">Sl#</th>
            <th class="text-nowrap">Name</th>
            <th class="text-nowrap">Email</th>
            <th class="text-nowrap">Role</th>
            <th class="text-nowrap">Status</th>
            @if ($usr->can('user.edit') || $usr->can('user.delete'))
                <th class="text-nowrap">Action</th>
            @endif
        </tr>
    </thead>

    <tbody class="table-border-bottom-0">
        @if ($users->count() > 0)
            @php $s = 1; @endphp
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $s }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->roles == null || $user->roles->isEmpty())
                            <p>No Role</p>
                        @else
                            @foreach ($user->roles as $perm)
                                <span class="badge bg-label-primary mr-2 my-1">{{ $perm->name ?? 'N/A' }}</span>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if ($user->status === 1)
                            <span class="badge bg-label-success me-1">Active</span>
                        @else
                            <span class="badge bg-label-danger me-1">Inactive</span>
                        @endif
                    </td>
                    @if ($usr->can('user.edit') || $usr->can('user.delete'))
                        <td>
                            <div class="">
                                @if ($usr->can('user.edit'))
                                    <a href="{{ route('dashboard.user.edit', $user->id) }}"
                                        class="btn btn-sm btn-info btn-text-secondary rounded-pill waves-effect btn-icon">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                @endif
                                @if ($usr->can('user.delete'))
                                    <button type="button"
                                        class="btn btn-sm btn-danger btn-text-secondary rounded-pill waves-effect btn-icon softDeleteData"
                                        data-url="{{ route('dashboard.user.softdelete', $user->id) }}">
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
                <td colspan="6">
                    <div class="card bg-light p-3 text-center">
                        <strong>No Users Found</strong>
                    </div>
                </td>
            </tr>
        @endif
    </tbody>
</table>

<div id="pagination-container" style="margin-top: 10px;">
    {{ $users->links('backend.pagination.custom', [
        'paginator' => $users->onEachSide(1)->withQueryString()->setPageName('page')->setPath(route('dashboard.user.loadMoreUser')),
    ]) }}
</div>
