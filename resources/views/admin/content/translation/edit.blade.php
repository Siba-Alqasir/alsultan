@extends('admin.layouts.contentLayoutMaster')

@section('title', 'Edit Translation')
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
                            <form id="customForm" method="POST" action="{{route('translation.store',$translation->id)}}"
                                  enctype="multipart/form-data" id="form_{{$key}}">
                                <input type="hidden" name="lang_name" value="{{$key}}">
                                <input type="hidden" name="key" value="{{$translation->key}}">

                                @csrf
                                <div class="col-lg-12">
                                    <div class="mb-1">
                                        <label class="form-label">Value <b>({{$locale['name']}})</b> @if($key === 'en')*@endif
                                        </label>
                                        <input type="text" name="value" class="form-control"
                                               @if($key === 'en') required
                                               @endif value="{{\DB::table('translations')->where('key', $translation->key)->where('language_code', $key)->first() ? \DB::table('translations')->where('key', $translation->key)->where('language_code', $key)->first()->value : ''}}">
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
