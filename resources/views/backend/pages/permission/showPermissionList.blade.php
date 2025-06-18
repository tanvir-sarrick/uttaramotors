
@if ($all_permissions->count() > 0)
<div class="row mx-2">
    @php $i=1; @endphp
        @foreach ($permission_groups as $permission_group)
        <div class="col-4 mb-5">
            <div class="card" style="background-color: #605daf47;">
                @php
                    $permissions = App\Models\User::getpermissionsByGroupName($permission_group->name);
                    $j = 1;
                @endphp
                <div class="col-12">
                    <div class="my-2" style="text-align:center;">
                        <div class="custom-control">
                            <label class="custom badge badge-primary" style="font-size: 13px;">{{ $permission_group->name }}</label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @foreach ($permissions as $permission )
                    <div class="my-2 mx-2">
                        <div class="custom-control">
                            <label class="custom">{{ $permission->name }}</label>
                        </div>
                    </div>
                    @php
                        $j++;
                    @endphp
                    @endforeach
                    <br>
                    <div class="mb-2" style="float:right">
                        <a href="{{ route('dashboard.permission.edit', $permission_group->name ) }}">
                            <button type="button" class="btn btn-sm btn-success permission"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </a>
                        <a style="margin-right: 10px;">
                            <button style="line-height: 20px!important" type="button" class="btn btn-sm btn-danger suspendData" data-url="{{ route('dashboard.permission.destroy', $permission_group->name) }}">
                                <i class="fas fa-trash-alt" ></i>
                            </button>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        @php
            $i++;
        @endphp
        @endforeach
</div>

@else
@endif


