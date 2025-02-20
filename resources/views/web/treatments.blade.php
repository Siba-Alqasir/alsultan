@extends('web.layouts')
@section('content')
@include('web.components.breadcrumb')

@foreach($data['treatments'] as $treatment)
    <div id="about-one-page" class="tp-about-area tp-about-wrapper fix pt-110 pb-120">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-10">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-xl-5 col-lg-5 wow tpfadeRight" data-wow-duration=".9s"
                            data-wow-delay=".5s">
                            <div class="tp-about-right">
                                <div class="tp-about-title-box mb-50">
                                    <h4 class="tp-section-title">{{$treatment->title}}</h4>
                                </div>
                                <div class="tp-about-text mb-45">
                                    <p>{!! $treatment->description !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div class="p-relative">
                                <div class="tp-about-main-thumb">
                                <img src="{{$data['is_mobile'] ? $treatment->getFirstMediaUrl('mobile_images') : $treatment->getFirstMediaUrl('images')}}" alt="{{$treatment->title}}" class="w-100">
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- features area start -->
    @if(count($treatment->features))
    <div id="service-one-page" class="tp-service-area grey-bg3 pt-110 pb-90">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">

                    <div class="row justify-content-center">
                        <div class="col-xl-7">
                            <div class="tp-service-title-box text-center mb-30">
                            <h4 class="tp-section-title mb-3">{{_t('Treatment Features')}}</h4>
                            <span class="tp-section-subtitle">{{$treatment->features_desc}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-lg-5 justify-content-center">
                        @foreach($treatment->features as $feature)
                            <div class="col-xl col-lg col-md-6 col-sm-6 mb-30 wow tpfadeUp" data-wow-duration=".9s"
                                data-wow-delay=".3s">
                                <div class="tp-service-item text-center">
                                <div class="tp-service-thumb mb-10">
                                    <img src="{{$feature->getFirstMediaUrl('logo')}}" alt="{{$feature->title}}">
                                </div>
                                <div class="tp-service-content">
                                    <p class="pb-5">{{$feature->title}}</p>
                                </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- features area end -->
@endforeach
@endsection