@extends('admin.layouts.contentLayoutMaster')
@section('title', 'Create Slider')
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
                            <form method="POST" action="{{route('sliders.store')}}"
                                  enctype="multipart/form-data" id="form_{{$key}}">
                                <input type="hidden" name="lang" value="{{$key}}">
                                @csrf
                                @if($key === 'en')
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-1">
                                                <label class="form-label">Is Active?</label>
                                                <input type="checkbox" id="is_active" name="is_active" checked>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Title <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <input type="text" name="title" class="form-control"
                                                @if($key === 'en') required @endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">SubTitle <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <input type="text" name="sub_title" class="form-control"
                                                @if($key === 'en') required @endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Button Title <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <input type="text" name="btn_title" class="form-control"
                                                @if($key === 'en') required @endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Button Link <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <input type="text" name="btn_link" class="form-control"
                                                @if($key === 'en') required @endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Description <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <textarea class="form-control" name="description" @if($key === 'en') required @endif></textarea>
                                        </div>
                                    </div>
                                </div>
                                @if($key === 'en')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Upload Website Cover *</label>
                                                <input type="file" name="cover" class="form-control" id="cover_url" accept="image/*,video/*" required />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Upload Mobile Cover *</label>
                                                <input type="file" name="mobile_cover" class="form-control" id="cover_url_mobile" accept="image/*,video/*" required />
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