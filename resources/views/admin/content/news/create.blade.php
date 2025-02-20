@extends('admin.layouts.contentLayoutMaster')
@section('title', 'Create Blog')
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
                            <form method="POST" action="{{route('news.store')}}"
                                  enctype="multipart/form-data" id="form_{{$key}}">
                                <input type="hidden" name="lang" value="{{$key}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Title <b>({{$locale['name']}})</b> *</label>
                                            <input type="text" name="title" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-1">
                                            <label class="form-label">Date *</label>
                                            <input type="date" name="date" class="form-control" required >
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-1">
                                            <label class="form-label">Author <b>({{$locale['name']}})</b></label>
                                            <input type="text" name="author" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Description <b>({{$locale['name']}})</b> *</label>
                                            <textarea class="form-control" id="summernote" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-1">
                                            <label class="form-label">Upload List Image *</label>
                                            <input type="file" name="list_image" class="form-control" id="list_image_url" accept="image/*" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-1">
                                            <label class="form-label">Upload Cover *</label>
                                            <input type="file" name="cover" class="form-control" id="cover_url" accept="image/*" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-1">
                                            <img class="img-fluid rounded" src="" id="list_image_view">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-1">
                                            <img class="img-fluid rounded" src="" id="cover_view">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12"><h3 class="text-center mb-2">SEO Information</h3></div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Meta Title <b>({{$locale['name']}})</b> *</label>
                                            <input type="text" name="meta_title" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Meta Description <b>({{$locale['name']}})</b> *</label>
                                            <input type="text" name="meta_description" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
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
        $("#list_image_url").change(function () {
            readLURL(this);
        });
        function readLURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#list_image_view").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#cover_url").change(function () {
            readCURLMobile(this);
        });
        function readCURLMobile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#cover_view").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
