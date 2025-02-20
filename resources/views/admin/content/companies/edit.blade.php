@extends('admin.layouts.contentLayoutMaster')
@section('title', 'Edit Company')
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
                            <form method="POST" action="{{route('companies.update', $company->id)}}"
                                  enctype="multipart/form-data" id="form_{{$key}}">
                                <input type="hidden" name="lang" value="{{$key}}">
                                <input type="hidden" name="company_id" value="{{$company->id}}">
                                {{ method_field('PUT') }}
                                @csrf
                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Name <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <input type="text" name="name" class="form-control"
                                                @if($key === 'en') required @endif value="{{$company->getTranslation('name',$key)}}">
                                        </div>
                                    </div>
                                </div>
                                @if($key === 'en')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Link</label>
                                                <input type="text" name="url" class="form-control" value="{{$company->url}}">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Description <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <textarea class="form-control" id="summernote" name="description">{{$company->getTranslation('description',$key)}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @if($key === 'en')
                                    <div id="logo_section">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <label class="form-label">Upload Logo *</label>
                                                    <input type="file" name="logo" class="form-control" id="logo_url" accept="image/*"  @if(!$company->getFirstMediaUrl('logo')) required @endif />
                                                </div>
                                            </div>                                        
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-1">
                                                    <img class="img-fluid rounded" src="{{$company->getFirstMediaUrl('logo')}}" id="logo_view">
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
