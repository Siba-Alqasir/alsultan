@extends('admin.layouts.contentLayoutMaster')

@section('title', 'Clients')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
@endsection

@section('content')
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @can('clients-create')
                        <div class="card-header" style="justify-content: end;">
                            <a type="button" class="btn btn-primary" href="{{route('clients.create')}}"> Add Client</a>
                        </div>
                    @endcan
                    <div class="card-body">
                        <table class="datatables-basic table" id="item_tables">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">Logo</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Name</th>                                
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($clients as $key=>$client)
                                <tr id="item_id_{{$client->id}}">
                                    <td class="text-center">{{++$key}}</td>                                    
                                    <td class="text-center">
                                        <img style="width:100px;height:100px" src="{{$client->getFirstMediaUrl('logo')}}">
                                    </td>
                                    <td class="text-center">{{$client->type}}</td>
                                    <td class="text-center">{{$client->getTranslation('name','en')}}</td>
                                    <td class="text-center">
                                        @can('clients-edit')
                                            <a type="button" class="btn btn-info waves-effect waves-float waves-light"
                                            href="{{route('clients.edit',$client->id)}}">Edit</a>
                                        @endcan
                                        @can('clients-delete')
                                            <a type="button" class="btn btn-danger waves-effect waves-float waves-light"
                                            onclick="delete_item(this)" item_id="item_id_{{$client->id}}"
                                            item_url="{{route('clients.destroy',$client->id)}}">Delete</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('vendor-script')
    <script src="{{ asset(mix('admin-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('admin-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('admin-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('admin-assets/vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
    <script src="{{ asset(mix('admin-assets/vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('admin-assets/vendors/js/tables/datatable/buttons.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('admin-assets/vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection
@section('page-script')
    <script>
        $(document).ready(function () {
            $('#item_tables').DataTable({
                displayLength: 25,
                lengthMenu: [25, 50, 75, 100],
                language: {
                    paginate: {
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    }
                }
            });
        });
    </script>
@endsection
