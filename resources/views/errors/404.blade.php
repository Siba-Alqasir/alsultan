@extends('web.layouts')
@section('content')
@include('web.components.breadcrumb')
<div id="about-one-page" class="tp-about-area tp-about-wrapper fix pt-110 pb-120">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-10">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xl-12 col-lg-12 wow tpfadeRight" data-wow-duration=".9s"
                         data-wow-delay=".5s">
                        <div class="tp-about-right">
                            {{-- <div class="tp-about-title-box mb-50">
                                <h4 class="tp-section-title">{{$data['page']['title']}}</h4>
                            </div> --}}
                            <div class="tp-about-text mb-45">
                                <p>
                                     {!! $data['page']['description'] !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection