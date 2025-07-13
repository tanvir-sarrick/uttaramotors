@extends('backend.layout.template')
@section('title', 'Role')
@section('role', 'active')
@section('role_permission', 'active open')
@section('style')
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
<style>
    .custom-control-label {
    text-transform: capitalize;
    }
    .custom-control-label::before {
        background-color: #fff;
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card">
                <div class="card-header d-flex border-top rounded-0 flex-wrap py-3 flex-column align-items-end">
                    <div class="me-5 ms-n4 pe-5 mb-n6 mb-md-0">
                    </div>
                    <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                        <div class="dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row">
                            <div class="dt-buttons btn-group flex-wrap d-flex mb-6 mb-sm-0">
                                <button id="BackMailerServerBtn" class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light" type="button">
                                    <span><i class="ti ti-plus me-1 ti-xs"></i>Back</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mx-3">
                    <form action="{{ route('dashboard.role.update', $role->id) }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $role->id }}" name="id">
                        <div class="form-group row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Role Name</label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text" name="name" value="{{ $role->name }}" id="example-text-input">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 my-2 control-label">Permissions</label>
                            <div class="col-md-9">
                                <div class="checkbox my-2">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="form-check-input" value="1" id="checkPermissionAll"
                                        {{ App\Models\User::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                                        <label class="form-check-label custom-option-content" for="checkPermissionAll">All</label>
                                    </div>
                                </div>
                                <hr>
                                @php $i=1; @endphp
                                @foreach ($permission_groups as $permission_group)
                                <div class="row">
                                    @php
                                        $permissions = App\Models\User::getpermissionsByGroupName($permission_group->name);
                                        $j = 1;
                                    @endphp
                                    <div class="col-3">
                                        <div class="checkbox my-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="form-check-input" value="{{ $permission_group->name }}"
                                                 id="{{ $i }}Management" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)"
                                                 {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                                <label class="form-check-label custom-option-content" for="{{ $i }}Management">{{ $permission_group->name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-9 role-{{ $i }}-management-checkbox">

                                        @foreach ($permissions as $permission )
                                        <div class="checkbox my-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->name }}"
                                                id="checkPermission{{ $permission->id }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})">
                                                <label class="form-check-label custom-option-content" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                            </div>
                                        </div>
                                        @php
                                            $j++;
                                        @endphp
                                        @endforeach
                                        <br>
                                    </div>
                                </div>
                                @php
                                    $i++;
                                @endphp
                                @endforeach


                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-12" style="text-align: center;">
                                <button class="btn btn-primary me-3 waves-effect waves-light" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#BackMailerServerBtn').click(function (e) {
                e.preventDefault();
                var downloadUrl = "{{ route('dashboard.role.index') }}";
                // Redirect to the download URL
                window.location.href = downloadUrl;
            });
        });
    </script>
    <script>
        $('#checkPermissionAll').click(function(){
            if($(this).is(':checked')){
                $('input[type=checkbox]').prop('checked', true);
            }
            else{
                $('input[type=checkbox]').prop('checked', false);
            }

        });

        function checkPermissionByGroup(className, checkThis){
            const groupIdName = $("#"+checkThis.id);
            const classCheckBox = $('.'+className+' input');
            if(groupIdName.is(':checked')){
                classCheckBox.prop('checked', true);
            }
            else{
                classCheckBox.prop('checked', false);
            }
            implementAllChecked();
        }

        function checkSinglePermission(groupClassName, groupID, countTotalPermission){
            const classCheckbox = $('.'+groupClassName+ ' input');
            const groupIDCheckbox    = $('#'+groupID);

            if( $('.'+groupClassName+ ' input:checked').length == countTotalPermission ){
                groupIDCheckbox.prop('checked', true);
            }
            else{
                groupIDCheckbox.prop('checked', false);
            }
            implementAllChecked();
        }

        function implementAllChecked(){
            const countPermissions = {{ count($all_permissions) }};
            const countPermissionGroup = {{ count($permission_groups) }};

            if( $('input[type=checkbox]:checked').length >= countPermissions + countPermissionGroup ){
                $('#checkPermissionAll').prop('checked', true);
            }
            else{
                $('#checkPermissionAll').prop('checked', false);
            }
        }
    </script>
@endsection
