@extends('admin.layouts.contentLayoutMaster')
@section('title', 'Inquiries')
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
@endsection
@section('content')
    <section id="basic-datatable">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <table class="datatables-basics table" id="item_tables">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            @if($type === 'inquiry')<th class="text-center">Category</th>@endif
                            @if($type === 'inquiry')<th class="text-center">Company</th>@endif
                            <th class="text-center">Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($inquiries as $key=>$inquiry)
                            <tr id="item_id_{{$inquiry->id}}">
                                <td class="text-center">{{++$key}}</td>
                                <td class="text-center">{{$inquiry->name}}</td>
                                <td class="text-center">{{$inquiry->email}}</td>
                                @if($type === 'inquiry') <td class="text-center">{{$inquiry->category}}</td> @endif
                                @if($type === 'inquiry') <td class="text-center">{{$inquiry->company}}</td> @endif
                                <td class="text-center">{{date('Y-m-d H:i',strtotime($inquiry->created_at))}}</td>
                                <td class="text-center">
                                    @can('inquiries-list')
                                        <a type="button" class="btn btn-info waves-effect waves-float waves-light"
                                            href="{{route('inquiries.show',$inquiry->id)}}"
                                        >View</a>
                                    @endcan
                                    @can('inquiries-delete')
                                        <a type="button" class="btn btn-danger waves-effect waves-float waves-light"
                                            onclick="delete_item(this)" item_id="item_id_{{$inquiry->id}}"
                                            item_url="{{route('inquiries.destroy',$inquiry->id)}}">Delete</a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
            $("[id*='item_tables']").DataTable({
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
