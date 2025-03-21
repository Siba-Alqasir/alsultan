@extends('admin.layouts.contentLayoutMaster')
@section('title', 'Edit Service')
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
                            <form method="POST" action="{{route('services.update',$service->id)}}" enctype="multipart/form-data" id="form_{{$key}}">
                                {{ method_field('PUT') }}
                                @csrf
                                <input type="hidden" name="lang" value="{{$key}}">
                                @if($key === 'en')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Ordering *</label>
                                                <input type="number" name="ordering" class="form-control" value="{{$service->ordering}}" required>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Title <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <input type="text" name="title" class="form-control"
                                                   value="{{$service->getTranslation('title',$key)}}"
                                                   @if($key === 'en') required @endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-1">
                                        <label class="form-label">Description <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                        <textarea class="form-control" name="description" id="summernote" >{!! $service->getTranslation('description',$key) !!}</textarea>
                                    </div>
                                </div>
                                 @if($key === 'en')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Upload Website Image *</label>
                                                <input type="file" name="image" class="form-control" id="image_url"
                                                       accept="image/*" @if(!$service->getFirstMediaUrl('images')) required @endif />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Upload Mobile Image *</label>
                                                <input type="file" name="mobile_image" style="height: 50%"
                                                       class="form-control" id="image_url_mobile" accept="image/*" @if(!$service->getFirstMediaUrl('mobile_images')) required @endif />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <img class="img-fluid rounded" src="{{$service->getFirstMediaUrl('images')}}" id="image_view">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <img class="img-fluid rounded" src="{{$service->getFirstMediaUrl('mobile_images')}}"  id="image_view_mobile">
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
                    $('#image_view').attr('src', e.target.result);
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
    </script>
@endsection
