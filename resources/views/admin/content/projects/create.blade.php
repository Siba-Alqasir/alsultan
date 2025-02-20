@extends('admin.layouts.contentLayoutMaster')
@section('title', 'Create Project')
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
                            <form method="POST" action="{{route('projects.store')}}" enctype="multipart/form-data"
                                  id="form_{{$key}}">
                                <input type="hidden" name="lang" value="{{$key}}">
                                @csrf
                                @if($key === 'en')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Ordering *</label>
                                                <input type="number" name="ordering" class="form-control" required min="1" pattern="[1-9][0-9]*">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Title <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <input type="text" name="title" class="form-control" @if($key === 'en') required @endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-1">
                                        <label class="form-label">Description <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                        <textarea class="form-control" name="description" id="summernote"></textarea>
                                    </div>
                                </div>
                                @if($key === 'en')
                                    <div class="col-lg-12"><h3 class="text-center mb-2 mt-2">Gallery</h3></div>
                                    <div class="repeater">
                                        <div class="entry">
                                            <div class="row mt-1">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Upload Image</label>
                                                        <input type="file" name="gallery[]"
                                                            class="form-control" id="gallery_url" accept="image/*" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <button class="btn btn-danger btn-remove mt-2" type="button">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-info btn-add mt-1" type="button">Add More</button>
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
    <script type="text/javascript">
        $(document).ready(function() {
            var entry = $('.entry').clone();

            $('.btn-add').click(function() {
                var newEntry = entry.clone();
                newEntry.find('input').val('');
                newEntry.appendTo('.repeater');
            });

            $(document).on('click', '.btn-remove', function() {
                $(this).closest('.entry').remove();
            });
        });
    </script>
@endsection
