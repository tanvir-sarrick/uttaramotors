@extends('backend.layout.template')
@section('title', 'Permission')
@section('permission', 'active')
@section('style')
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <form class="form" action="{{ route('dashboard.permission.store') }}" method="post">
                        @csrf
                        <div class="add_item">
                            <div class="form-group row">
                                <!--  Group Name Start !-->
                                <div class="col-sm-12">
                                    <label for="example-text-input" class="">Group Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="group_name" value="{{ old('group_name') }}"
                                    id="example-text-input" placeholder="Enter Group Name" >
                                    @error('group_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!--  Permission Name !-->
                                <div class="col-lg-10 col-10 mt-2">
                                    <label for="example-text-input" class="">Permission Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name[]" value="{{ old('name') }}"
                                        id="example-text-input" placeholder="Enter Permission Name" >
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-2 mt-4">
                                    <span class="btn btn-success addeventmore" style="margin-top: 12px;"><i class="fa fa-plus-circle"></i></span>
                                </div>
                            </div>
                        </div>
                        <div style="visibility: hidden;">
                            <div class="whole_extra_item_add" id="whole_extra_item_add">
                                <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
                                    <div class="row">
                                        <!--  Permission Name !-->
                                        <div class="col-lg-9 col-8 mb-2">
                                            <label for="example-text-input" class="">Permission Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="name[]" value="{{ old('name') }}"
                                                id="example-text-input" placeholder="Enter Permission Name" >
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-4 mt-3">
                                            <span class="btn btn-success addeventmore" style="margin-top: 12px;"><i class="fa fa-plus-circle"></i></span>
                                            <span class="btn btn-danger removeeventmore" style="margin-top: 12px;"><i class="fa fa-minus-circle"></i></span>
                                        </div>
                                    </div>
                                </div>
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
                var downloadUrl = "{{ route('dashboard.permission.index') }}";
                // Redirect to the download URL
                window.location.href = downloadUrl;
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            var counter = 0;
            $(document).on("click", ".addeventmore", function(){
                //alert('h');
                var whole_extra_item_add = $('#whole_extra_item_add').html();
                $(this).closest('.add_item').append(whole_extra_item_add);
                counter++;
            });

            $(document).on("click", ".removeeventmore", function(event){
                //alert('h');
                // var whole_extra_item_add = $('#whole_extra_item_add').html();
                 $(this).closest('.delete_whole_extra_item_add').remove();
                 counter -= 1;
            });
        });
    </script>
@endsection
