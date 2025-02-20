@extends('admin.layouts.contentLayoutMaster')
@section('title', 'Edit Page')
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
                            <form id="form_{{$key}}" method="POST" action="{{route('pages.update',$page->key)}}"
                                  enctype="multipart/form-data" id="form_{{$key}}">
                                {{ method_field('PUT') }}
                                <input type="hidden" name="lang" value="{{$key}}">
                                <input type="hidden" name="page_id" value="{{$page->id}}">
                                @csrf
                                @if(isset($page->removed_inputs['title']) && !$page->removed_inputs['title'])
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Title <b>({{$locale['name']}})</b>
                                            </label>
                                            <input type="text" name="title"
                                                   value="{{$page->getTranslation('title',$key)}}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(isset($page->removed_inputs['sub_title']) && !$page->removed_inputs['sub_title'])
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Sub Title <b>({{$locale['name']}})</b>
                                                </label>
                                                <input type="text" name="sub_title"
                                                       value="{{$page->getTranslation('sub_title',$key)}}" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if(isset($page->removed_inputs['description']) && !$page->removed_inputs['description'])
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Description <b>({{$locale['name']}})</b>@if($key === 'en')*@endif</label>
                                            <textarea id="summernote" name="description">{{$page->getTranslation('description',$key)}}</textarea>
                                        </div>
                                    </div>
                                @endif
                                @if(isset($page->removed_inputs['video']) &&  !$page->removed_inputs['video'])
                                    @if($key === 'en')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Upload Website <span id="file-type-website">Video</span></label>
                                                <input type="file" name="video" class="form-control" id="video_url" accept="video/*"/>
                                            </div>
                                            @if($page->getFirstMediaUrl('videos') !== "")
                                            <div class="invoice-title">
                                                <span class="mt-md-0 mt-2" style="justify-content: end"><a target="_blank" href="{{$page->getFirstMediaUrl('videos')}}">View old file</a></span>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Upload Mobile <span id="file-type-mobile">Video</span></label>
                                                <input type="file" name="mobile_video" class="form-control" id="video_url_mobile" accept="video/*"/>
                                            </div>
                                            @if($page->getFirstMediaUrl('mobile_videos') !== "")
                                            <div class="invoice-title">
                                                <span class="mt-md-0 mt-2" style="justify-content: end"><a target="_blank" href="{{$page->getFirstMediaUrl('mobile_videos')}}">View old file</a></span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                @endif
                                @if($key === 'en')
                                    @if(isset($page->removed_inputs['cover']) && !$page->removed_inputs['cover'])
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Upload Cover <span id="file-type-website">Image</span></label>
                                                <input type="file" name="image" class="form-control" id="image_url"
                                                       accept="image/*"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Upload Mobile Cover <span id="file-type-mobile">Image</span></label>
                                                <input type="file" name="mobile_image" style="height: 50%"
                                                       class="form-control" id="image_url_mobile" accept="image/*"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <img class="img-fluid rounded" src="{{$page->getFirstMediaUrl('images')}}" id="image_view">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <img class="img-fluid rounded" src="{{$page->getFirstMediaUrl('mobile_images')}}" id="image_view_mobile">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                                @if($key === 'en')
                                    @if(isset($page->removed_inputs['logo']) && !$page->removed_inputs['logo'])
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <label class="form-label">Upload <span id="file-type-website">Logo</span></label>
                                                    <input type="file" name="logo" class="form-control" id="logo_url"
                                                           accept="image/*"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <label class="form-label">Upload Mobile <span id="file-type-mobile">Logo</span></label>
                                                    <input type="file" name="mobile_logo" style="height: 50%"
                                                           class="form-control" id="logo_url_mobile" accept="image/*"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <img class="img-fluid rounded" src="{{$page->getFirstMediaUrl('logos')}}" id="logo_view">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <img class="img-fluid rounded" src="{{$page->getFirstMediaUrl('mobile_logos')}}" id="logo_view_mobile">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                @if($key === 'en')
                                    @if(isset($page->removed_inputs['menu_image']) && !$page->removed_inputs['menu_image'])
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Upload Menu <span id="file-type-website">Image</span></label>
                                                <input type="file" name="menu_image" class="form-control" id="menu_image_url"
                                                       accept="image/*"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Upload Menu Mobile <span id="file-type-mobile">Image</span></label>
                                                <input type="file" name="menu_mobile_image" style="height: 50%"
                                                       class="form-control" id="menu_image_url_mobile" accept="image/*"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <img class="img-fluid rounded" src="{{$page->getFirstMediaUrl('menu_images')}}" id="menu_image_view">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <img class="img-fluid rounded" src="{{$page->getFirstMediaUrl('menu_mobile_images')}}" id="menu_image_view_mobile">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                                @if(isset($page->removed_inputs['seo']) && !$page->removed_inputs['seo'])
                                <div class="col-lg-12"><h3 class="text-center mb-2 mt-2">SEO Information</h3></div>
                                <div class="col-lg-12">
                                    <div class="mb-1">
                                        <label class="form-label"> Meta Title <b>({{$locale['name']}})</b></label>
                                        <input type="text" name="meta_title"
                                               value="{{$page->getTranslation('meta_title',$key)}}"
                                               class="form-control">
                                        @error('meta_title')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-1">
                                        <label class="form-label">Meta Description <b>({{$locale['name']}})</b></label>
                                        <input type="text" name="meta_description"
                                               value="{{$page->getTranslation('meta_description',$key)}}"
                                               class="form-control">
                                        @error('meta_description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                                <button type="submit" data-id="{{$key}}" class="btn btn-primary mt-2"
                                        style="float: right">Save
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
    <script>
        $("#logo_url").change(function () {
            readLogoURL(this);
        });
        function readLogoURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#logo_view').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#logo_url_mobile").change(function () {
            readLogoURLMobile(this);
        });
        function readLogoURLMobile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#logo_view_mobile").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script>
        $("#menu_image_url").change(function () {
            readMenuURL(this);
        });
        function readMenuURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#menu_image_view').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#menu_image_url_mobile").change(function () {
            readMenuURLMobile(this);
        });
        function readMenuURLMobile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#menu_image_view_mobile").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
