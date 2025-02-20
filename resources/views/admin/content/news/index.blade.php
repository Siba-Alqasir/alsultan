@extends('admin.layouts.contentLayoutMaster')

@section('title', 'News & Blogs')

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
                    <div class="card-body">
                        <form id="filters-form" method="GET" action="{{ Route('news.index') }}" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-1">
                                        <label class="form-label">Choose Language</label>
                                        <select class="form-control" name="lang" required>
                                            @foreach($active_lang as $key=>$lang)
                                                <option value="{{$key}}"
                                                    @if($locale==$key) selected @endif>{{$lang['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="text-left">
                                        <button type="submit" class="btn btn-primary mt-2">Search</button>
                                    </div>
                                </div>
                            </div>                       
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    @can('news-create')
                        <div class="card-header" style="justify-content: end;">
                            <a type="button" class="btn btn-primary" href="{{route('news.create')}}"> Add News</a>
                        </div>
                    @endcan
                    <div class="card-body">
                        <table class="datatables-basic table" id="item_tables">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($news as $key=>$new)
                                <tr id="item_id_{{$new->id}}">
                                    <td class="text-center">{{++$key}}</td>
                                    <td class="text-center">{{$new->getTranslation('title',$locale)}}</td>
                                    <td class="text-center">
                                        @can('news-edit')
                                            <a type="button" class="btn btn-info waves-effect waves-float waves-light"
                                            href="{{route('news.edit',$new->id)}}">Edit</a>
                                        @endcan
                                        @can('news-delete')
                                            <a type="button" class="btn btn-danger waves-effect waves-float waves-light"
                                            onclick="delete_item(this)" item_id="item_id_{{$new->id}}"
                                            item_url="{{route('news.destroy',$new->id)}}">Delete</a>
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
