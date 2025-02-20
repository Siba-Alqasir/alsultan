@extends('admin.layouts.contentLayoutMaster')

@section('title', 'Edit Section')
@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified" id="myTab2" role="tablist">
                    @foreach($active_lang as $key=>$locale)
                        <li class="nav-item">
                            <a class="nav-link @if($key === 'en') active @endif" id="{{$key}}-tab-justified"
                               data-bs-toggle="tab" href="#add-{{$key}}"
                               role="tab" aria-controls="add-{{$key}}" aria-selected="false"
                               @if($key === 'en') aria-selected="true" @endif>{{$locale['name']}}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content pt-1">
                    @foreach($active_lang as $key=>$locale)
                        <div class="tab-pane @if($key === 'en') active @endif" id="add-{{$key}}" role="tabpanel"
                             aria-labelledby="{{$key}}-tab-justified">
                            <form id="form_{{$key}}" method="POST" action="{{route('sections.update',$section->key)}}"
                                  enctype="multipart/form-data" id="form_{{$key}}">
                                <input type="hidden" name="lang" value="{{$key}}">
                                <input type="hidden" name="slider_id" value="{{$section->id}}">
                                {{ method_field('PUT') }}
                                @csrf
                                @if(isset($section->removed_inputs['title']) && !$section->removed_inputs['title'])
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Title <b>({{$locale['name']}}) @if($key === 'en' && $section->is_required['title'] === 1)*@endif</b>
                                                </label>
                                                @if($section->is_required['title_editor'])
                                                    <textarea id="summernote" name="title">{{$section->getTranslation('title',$key)}}</textarea>
                                                @else
                                                    <input type="text" name="title" class="form-control"
                                                    @if($key === 'en') @if($section->is_required['title'] === 1) required @endif
                                                    @endif value="{{$section->getTranslation('title',$key)}}">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if(isset($section->removed_inputs['sub_title']) && !$section->removed_inputs['sub_title'])
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">SubTitle <b>({{$locale['name']}}) @if($key === 'en' && $section->is_required['sub_title'] === 1)*@endif</b>
                                                </label>
                                                <input type="text" name="sub_title" class="form-control"
                                                    @if($key === 'en') @if($section->is_required['sub_title'] === 1) required @endif
                                                    @endif value="{{$section->getTranslation('sub_title',$key)}}">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    @if(isset($section->removed_inputs['btn_title']) && !$section->removed_inputs['btn_title'])
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Button Title <b>({{$locale['name']}})</b> @if($key === 'en' && $section->is_required['btn_title'] === 1)*@endif</label>
                                                <input type="text" name="btn_title" class="form-control"
                                                       value="{{$section->getTranslation('btn_title',$key)}}" @if($section->is_required['btn_title'] === 1) required @endif>
                                            </div>
                                        </div>
                                    @endif
                                    @if(isset($section->removed_inputs['btn_link']) && !$section->removed_inputs['btn_link'])
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Button Link <b>({{$locale['name']}})</b> @if($key === 'en' && $section->is_required['btn_link'] === 1)*@endif</label>
                                                <input type="text" name="btn_link" class="form-control"
                                                 value="{{$section->getTranslation('btn_link',$key)}}"  @if($section->is_required['btn_link'] === 1) required @endif>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if(isset($section->removed_inputs['description']) && !$section->removed_inputs['description'])
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Description <b>({{$locale['name']}})</b> @if($key === 'en' && $section->is_required['description'] === 1)*@endif</label>
                                            @if($section->key != 'about_page_vision' && $section->key != 'about_page_mission')
                                                <textarea id="summernote" name="description">{{$section->getTranslation('description',$key)}}</textarea>
                                            @else
                                                <textarea rows=3 class="form-control" name="description" @if($section->is_required['description'] === 1) required @endif>{{$section->getTranslation('description',$key)}}</textarea>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if(isset($section->removed_inputs['highlight']) && !$section->removed_inputs['highlight'] && $key === 'en')
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Video Link</label>
                                            <input type="text" name="highlight" class="form-control" value="{{$section->highlight}}">
                                        </div>
                                    </div>
                                @endif
                                @if(isset($section->removed_inputs['video']) && !$section->removed_inputs['video'])
                                    @if($key === 'en')
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <label class="form-label">Upload Website Video @if($section->is_required['video'] === 1)*@endif</label>
                                                    <input type="file" name="video" class="form-control" id="video_url" accept="video/*"/>
                                                </div>
                                                @if($section->getFirstMediaUrl('videos') !== "")
                                                    <div class="invoice-title">
                                                        <span class="mt-md-0 mt-2" style="justify-content: end"><a target="_blank" href="{{$section->getFirstMediaUrl('videos')}}">View old file</a></span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <label class="form-label">Upload Mobile Video @if($section->is_required['video'] === 1)*@endif</label>
                                                    <input type="file" name="mobile_video" class="form-control" id="video_url_mobile" accept="video/*"/>
                                                </div>
                                                @if($section->getFirstMediaUrl('mobile_videos') !== "")
                                                    <div class="invoice-title">
                                                        <span class="mt-md-0 mt-2" style="justify-content: end"><a target="_blank" href="{{$section->getFirstMediaUrl('mobile_videos')}}">View old file</a></span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                @if(isset($section->removed_inputs['image']) && !$section->removed_inputs['image'])
                                    @if($key === 'en')
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <label class="form-label">Upload Image @if($section->is_required['image'] === 1)*@endif</label>
                                                    <input type="file" name="image"
                                                            class="form-control" id="image_url" accept="image/*"  />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <label class="form-label">Upload Mobile Image @if($section->is_required['image'] === 1)*@endif</label>
                                                    <input type="file" name="mobile_image"
                                                            class="form-control" id="image_url_mobile"
                                                            accept="image/*"  />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <img class="img-fluid rounded" src="{{$section->getFirstMediaUrl('images')}}" id="image_view">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <img class="img-fluid rounded" src="{{$section->getFirstMediaUrl('mobile_images')}}" id="image_view_mobile">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                @if(isset($section->removed_inputs['second_image']) && !$section->removed_inputs['second_image'])
                                    @if($key === 'en')
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <label class="form-label">Upload Second Image @if($section->is_required['second_image'] === 1)*@endif</label>
                                                    <input type="file" name="second_image"
                                                            class="form-control" id="second_image_url" accept="image/*"  />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <label class="form-label">Upload Second Mobile Image @if($section->is_required['second_image'] === 1)*@endif</label>
                                                    <input type="file" name="mobile_second_image"
                                                            class="form-control" id="second_image_url_mobile"
                                                            accept="image/*"  />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <img class="img-fluid rounded" src="{{$section->getFirstMediaUrl('second_image')}}" id="second_image_view">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <img class="img-fluid rounded" src="{{$section->getFirstMediaUrl('mobile_second_image')}}" id="second_image_view_mobile">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <button type="submit" data-id="{{$key}}" class="btn btn-primary mt-2" style="float: right">Save
                                </button>
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
        $("#second_image_url").change(function () {
            readSURL(this);
        });
        function readSURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#second_image_view").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#second_image_url_mobile").change(function () {
            readSURLMobile(this);
        });
        function readSURLMobile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#second_image_view_mobile").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
