@extends('admin.layouts.contentLayoutMaster')

@section('title', 'Edit  Category')

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified" id="myTab2" role="tablist">
                    @foreach($active_lang as $key=>$locale)
                        <li class="nav-item">
                            <a class="nav-link @if($key === 'en') active @endif" id="{{$key}}-tab-justified"
                               data-bs-toggle="tab" href="#add-{{$key}}" role="tab"
                               aria-controls="add-{{$key}}">{{$locale['name']}}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content pt-1">
                    @foreach($active_lang as $key=>$locale)
                        <div class="tab-pane @if($key === 'en') active @endif" id="add-{{$key}}" role="tabpanel"
                             aria-labelledby="{{$key}}-tab-justified">
                            <form method="POST" action="{{route('categories.update',$category->id)}}" enctype="multipart/form-data" id="form_{{$key}}">
                                {{ method_field('PUT') }}
                                @csrf
                                <input type="hidden" name="lang" value="{{$key}}">
                                <input type="hidden" name="category_id" value="{{$category->id}}">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Title <b>({{$locale['name']}})</b> @if($key === 'en')*@endif
                                            </label>
                                            <input type="text" name="title" class="form-control" @if($key === 'en') required @endif value="{{$category->getTranslation('title',$key)}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Description <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <textarea class="form-control" name="description" id="summernote" >{{$category->getTranslation('description',$key)}}</textarea>
                                        </div>
                                    </div>
                                    @if($key === 'en')
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <label class="form-label">Upload Image *</label>
                                                    <input type="file" name="image" class="form-control" id="image_url" accept="image/*" @if(!$category->getFirstMediaUrl('images')) required @endif />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <label class="form-label">Upload Mobile Image *</label>
                                                    <input type="file" name="mobile_image" class="form-control" id="image_url_mobile" accept="image/*" @if(!$category->getFirstMediaUrl('mobile_images')) required @endif />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <img class="img-fluid rounded" src="{{$category->getFirstMediaUrl('images')}}" id="image_view">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <img class="img-fluid rounded" src="{{$category->getFirstMediaUrl('mobile_images')}}" id="image_view_mobile">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <label class="form-label">Upload Cover *</label>
                                                    <input type="file" name="cover" class="form-control" id="cover_url" accept="image/*" @if(!$category->getFirstMediaUrl('cover')) required @endif />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <label class="form-label">Upload Catalogue</label>
                                                    @if($category->getFirstMediaUrl('catalogue'))<a href="{{$category->getFirstMediaUrl('catalogue')}}" target="_blanck" style="float: right">View File?</a>@endif
                                                    <input type="file" name="catalogue" class="form-control" accept="*" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <img class="img-fluid rounded" src="{{$category->getFirstMediaUrl('cover')}}" id="cover_view">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-lg-12"><h3 class="text-center mb-2 mt-2">SEO Information</h3></div>
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label"> Meta Title <b>({{$locale['name']}})</b></label>
                                            <input type="text" name="meta_title" value="{{$category->getTranslation('meta_title',$key)}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Meta Description <b>({{$locale['name']}})</b></label>
                                            <input type="text" name="meta_description" value="{{$category->getTranslation('meta_description',$key)}}" class="form-control">
                                        </div>
                                    </div>
                                        
                                </div>
                                <button type="submit" data-id="{{$key}}" class="btn btn-primary mt-2" style="float: right">Save</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        $("#image_url").change(function () {
            readURL(this);
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#image_view").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image_url_mobile").change(function () {
            readURLMobile(this);
        });
        function readURLMobile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#image_view_mobile").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#cover_url").change(function () {
            readCoverURL(this);
        });
        function readCoverURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#cover_view").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @if(session('errors'))
        @if(session('errors')->first('catalogue') )
            <script>
                toastr['error'](
                    "{{ session('errors')->first('catalogue') }}",
                    "Error",
                    {
                        closeButton: true,
                        tapToDismiss: false,
                        progressBar: true,
                    });
            </script>
        @endif
    @endif
@endsection