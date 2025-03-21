@extends('admin.layouts.contentLayoutMaster')
@section('title', 'Edit Color')
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
                            <form method="POST" action="{{route('colors.update',$color->id)}}" enctype="multipart/form-data" id="form_{{$key}}">
                                {{ method_field('PUT') }}
                                @csrf
                                <input type="hidden" name="lang" value="{{$key}}">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Title <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <input type="text" name="title" class="form-control"
                                                   value="{{$color->getTranslation('title',$key)}}"
                                                   @if($key === 'en') required @endif>
                                        </div>
                                    </div>
                                </div>
                                @if($key === 'en')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Upload Image *</label>
                                                <input type="file" name="image" class="form-control" id="image_url"
                                                       accept="image/*" @if(!$color->getFirstMediaUrl('images')) required @endif />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <img class="img-fluid rounded" src="{{$color->getFirstMediaUrl('images')}}" id="image_view">
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
    </script>
@endsection
