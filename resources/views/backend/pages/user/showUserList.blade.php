
@if ($users->count() > 0)
<table class="datatables-customers table border-top">
    <thead>
      <tr>
        <th class="text-nowrap">Sl#</th>
        <th class="text-nowrap">Name</th>
        <th class="text-nowrap">Email</th>
        <th class="text-nowrap">Role</th>
        <th class="text-nowrap">Action</th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @php
            $s= 1;
        @endphp
        @foreach ($users as $user)
            <tr>
                <th scope="row">{{ $s }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if (  $user->roles == null)
                        <p>no role</p>
                    @else
                        @foreach ($user->roles as $perm)
                        <span class="badge bg-label-primary mr-2 my-1">
                            {{ $perm->name ?? 'N\A' }}
                        </span>
                        @endforeach
                    @endif
                </td>
                <td>
                    <div class="d-flex align-items-center">
                      <a href="{{ route('dashboard.user.edit', $user->id) }}" class="btn btn-info btn-text-secondary rounded-pill waves-effect btn-icon delete-record">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      <a class="btn btn-danger btn-text-secondary rounded-pill waves-effect btn-icon delete-record">
                        <button style="line-height: 20px!important" type="button" class="btn btn-sm btn-danger btn-text-secondary rounded-pill waves-effect btn-icon delete-record suspendData" data-url="{{ route('dashboard.user.suspend', $user->id) }}">
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
    {{ $users->links('backend.pagination.custom', ['paginator' => $users->onEachSide(1)->withQueryString()->setPageName('page')->setPath(route('dashboard.user.loadMoreItem'))]) }}
</div>
@else

@endif


