@extends('admin.layouts.contentLayoutMaster')
@section('title', 'Edit Feature')
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
                            <form method="POST" action="{{route('treatment-features.update', $feature->id)}}"
                                  enctype="multipart/form-data" id="form_{{$key}}">
                                <input type="hidden" name="lang" value="{{$key}}">
                                <input type="hidden" name="feature_id" value="{{$feature->id}}">
                                <input type="hidden" name="treatment_id" value="{{$feature->treatment_id}}">
                                {{ method_field('PUT') }}
                                @csrf
                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Title <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <input type="text" name="title" class="form-control"
                                                @if($key === 'en') required @endif value="{{$feature->getTranslation('title',$key)}}">
                                        </div>
                                    </div>
                                </div>
                                @if($key === 'en')
                                    <div id="logo_section">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <label class="form-label">Upload Logo *</label>
                                                    <input type="file" name="logo" class="form-control" id="logo_url" accept="image/*"  @if(!$feature->getFirstMediaUrl('logo')) required @endif />
                                                </div>
                                            </div>                                        
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <img class="img-fluid rounded" src="{{$feature->getFirstMediaUrl('logo')}}" id="logo_view">
                                                </div>
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
        $("#logo_url").change(function () {
            readLogoURL(this);
        });
        function readLogoURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#logo_view").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
