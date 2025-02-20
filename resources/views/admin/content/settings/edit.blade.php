@extends('admin.layouts.contentLayoutMaster')

@section('title', 'Edit Settings')

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                @if(!in_array($settings->key,["logo"]))
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
                            <form method="POST" action="{{route('settings.update',$settings->id)}}" enctype="multipart/form-data" id="form_{{$key}}">
                                {{ method_field('PUT') }}
                                @csrf
                                <input type="hidden" name="lang" value="{{$key}}">
                                <input type="hidden" name="settings_id" value="{{$settings->id}}">
                                @if($key=="en")
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Name <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <input type="text" name="title" class="form-control"
                                                value="{{$settings->key}}"
                                                    readonly>
                                        </div>
                                    </div>
                                @endif
                                @if ($settings->key === 'brochure')
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Upload File</label>
                                            @if($settings->getFirstMediaUrl('brochure'))<a href="{{$settings->getFirstMediaUrl('brochure')}}" target="_blanck" style="float: right">View File?</a>@endif
                                            <input type="file" name="brochure" class="form-control" id="brochure_url" accept="pdf/*" />
                                        </div>
                                    </div>
                                @else
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Value <b>({{$locale['name']}})</b></label>
                                            <textarea class="form-control" name="value" rows="5"
                                            >{{$settings->getTranslation('value',$key)}}</textarea>
                                        </div>
                                    </div>
                                @endif
                                <button type="submit" data-id="{{$key}}" class="btn btn-primary mt-2" style="float: right">Save</button>
                            </form>
                        </div>
                    @endforeach
                </div>
                @else
                <div class="row">
                  <h3>{{$settings->key}}</h3>
                  <form method="POST" action="{{route('settings.update',$settings->id)}}" enctype="multipart/form-data" id="form_en">
                    {{ method_field('PUT') }}
                    @csrf
                    <input type="hidden" name="lang" value="en">
                    <input type="hidden" name="settings_id" value="{{$settings->id}}">
                    <div class="row">
                    @if($settings->key == "contact_flow_map")
                            <div class="col-lg-6">
                                <div class="mb-1">
                                    <label class="form-label">Upload Image*</label>
                                    <input type="file" name="contact_flow_map" class="form-control" accept="image/*" id="image_url"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-1">
                                    <img style="background-color:currentColor" class="img-fluid rounded" style="width:20%;height:20%;" id="image_view"
                                         src="{{$settings->getFirstMediaUrl('contact_flow_map')}}">
                                </div>
                            </div>
                    @elseif($settings->key == "dark_zlogo")
                            <div class="col-lg-6">
                                <div class="mb-1">
                                    <label class="form-label">Upload Image*</label>
                                    <input type="file" name="dark_logo" class="form-control" accept="image/*" id="image_url"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-1">
                                    <img style="background-color:currentColor" class="img-fluid rounded" style="width:20%;height:20%;" id="image_view"
                                         src="{{$settings->getFirstMediaUrl('dark_logo')}}">
                                </div>
                            </div>
                    @elseif($settings->key == "park_image")
                            <div class="col-lg-6">
                                <div class="mb-1">
                                    <label class="form-label">Upload Image*</label>
                                    <input type="file" name="park_image" class="form-control" accept="image/*" id="image_url"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-1">
                                    <img style="background-color:currentColor" class="img-fluid rounded" style="width:20%;height:20%;" id="image_view"
                                         src="{{$settings->getFirstMediaUrl('park_image')}}">
                                </div>
                            </div>
                        @else
                            <div class="col-lg-6">
                                <div class="mb-1">
                                    <label class="form-label">Upload Image*</label>
                                    <input type="file" name="logo" class="form-control" accept="image/*" id="image_url"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-1">
                                    <img style="background-color:currentColor" class="img-fluid rounded" style="width:20%;height:20%;" id="image_view"
                                         src="{{$settings->getFirstMediaUrl('logo')}}">
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="submit" data-id="form_en" class="btn btn-primary mt-2" style="float: right">Save</button>
                </form>
                </div>
                @endif
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
