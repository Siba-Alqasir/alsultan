@extends('admin.layouts.contentLayoutMaster')

@section('title', 'Create Settings')

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified" id="myTab2" role="tablist">
                    @foreach($active_lang as $key=>$locale)
                        @if($key === 'en')
                        <li class="nav-item">
                            <a class="nav-link @if($key === 'en') active @endif" id="{{$key}}-tab-justified"
                               data-bs-toggle="tab" href="#add-{{$key}}"
                               role="tab" aria-controls="add-{{$key}}" aria-selected="false"
                               @if($key === 'en') aria-selected="true" @endif>{{$locale['name']}}</a>
                        </li>
                        @endif
                    @endforeach
                </ul>
                <!-- Tab panes -->
                <div class="tab-content pt-1">
                    @foreach($active_lang as $key=>$locale)
                        <div class="tab-pane @if($key === 'en') active @endif" id="add-{{$key}}" role="tabpanel"
                             aria-labelledby="{{$key}}-tab-justified">
                            <form method="POST" action="{{route('settings.store')}}"
                                  enctype="multipart/form-data" id="form_{{$key}}">
                                <input type="hidden" name="lang" value="{{$key}}">
                                @csrf
                                 @if($key === 'en')
                                <div class="col-lg-12">
                                    <div class="mb-1">
                                        <label class="form-label">Name <b>({{$locale['name']}})</b></label>
                                        <input type="text" name="key" class="form-control"
                                                @if($key === 'en') required @endif>
                                    </div>
                                </div>
                                @endif
                                <div class="col-lg-12">
                                    <div class="mb-1">
                                        <label class="form-label">Value <b>({{$locale['name']}})</b></label>
                                        <textarea class="form-control" name="value"
                                                   @if($key === 'en') required @endif></textarea>
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
                $('#image_view').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
