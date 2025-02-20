@extends('admin.layouts.contentLayoutMaster')
@section('title', 'Edit Slider')
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
                            <form method="POST" action="{{route('sliders.update', $slider->id)}}"
                                  enctype="multipart/form-data" id="form_{{$key}}">
                                <input type="hidden" name="lang" value="{{$key}}">
                                <input type="hidden" name="slider_id" value="{{$slider->id}}">
                                {{ method_field('PUT') }}
                                @csrf
                                @if($key === 'en')
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-1">
                                                <label class="form-label">Is Active?</label>
                                                <input type="checkbox" id="is_active" name="is_active" @if($slider->is_active === 1)
                                                checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Title <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <input type="text" name="title" class="form-control"
                                                @if($key === 'en') required @endif value="{{$slider->getTranslation('title',$key)}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">SubTitle <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <input type="text" name="sub_title" class="form-control"
                                                @if($key === 'en') required @endif value="{{$slider->getTranslation('sub_title',$key)}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Button Title <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <input type="text" name="btn_title" class="form-control"
                                                @if($key === 'en') required @endif value="{{$slider->getTranslation('btn_title',$key)}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Button Link <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <input type="text" name="btn_link" class="form-control"
                                                @if($key === 'en') required @endif value="{{$slider->getTranslation('btn_link',$key)}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Description <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <textarea class="form-control" name="description" @if($key === 'en') required @endif>{{$slider->getTranslation('description',$key)}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @if($key === 'en')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Upload Website Cover *</label>
                                                <a href="{{$slider->is_video ? $slider->getFirstMediaUrl('videos') : $slider->getFirstMediaUrl('images')}}" target="_blanck" style="float: right">View Old File?</a>
                                                <input type="file" name="cover" class="form-control" id="cover_url" accept="image/*,video/*" @if(!$slider->getFirstMediaUrl('images') && !$slider->getFirstMediaUrl('videos')) required @endif />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Upload Mobile Cover *</label>
                                                <a href="{{$slider->is_video ? $slider->getFirstMediaUrl('mobile_videos') : $slider->getFirstMediaUrl('mobile_images')}}" target="_blanck" style="float: right">View Old File?</a>
                                                <input type="file" name="mobile_cover" class="form-control" id="cover_url_mobile" accept="image/*,video/*" @if(!$slider->getFirstMediaUrl('mobile_images') && !$slider->getFirstMediaUrl('mobile_videos')) required @endif />
                                            </div>
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
    $(document).ready(function() {
        if ($('[id^=summernote]').length > 0) {
            $('[id^=summernote]').summernote({
                height: 80,
            });
        }
    });
</script>
@if(session('errors'))
    @if(session('errors')->first('cover') )
        <script>
            toastr['error'](
                "{{ session('errors')->first('cover') }}",
                "Error",
                {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                });
        </script>
    @elseif(session('errors')->first('mobile_cover') )
        <script>
            toastr['error'](
                "{{ session('errors')->first('mobile_cover') }}",
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
