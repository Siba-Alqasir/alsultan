@extends('web.layouts')
@section('content')
@include('web.components.breadcrumb')
    <!-- about area start -->
    <div id="about-one-page" class="tp-about-area tp-about-wrapper fix pt-110 pb-120">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-10">
                    <div class="row justify-content-between align-items-center">

                    <div class="col-xl-5 col-lg-5 wow tpfadeRight" data-wow-duration=".9s"
                        data-wow-delay=".5s">
                        <div class="tp-about-right">
                            <div class="tp-about-title-box mb-50">
                                <h4 class="tp-section-title">{{$data['about_page_main']['title']}}</h4>
                            </div>
                            <div class="tp-about-text mb-45">
                                <p>{!! $data['about_page_main']['description'] !!}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6">
                        <div class="p-relative">
                            <div class="tp-about-main-thumb">
                                <img src="{{$data['is_mobile'] ? $data['about_page_main']->getFirstMediaUrl('mobile_images') : $data['about_page_main']->getFirstMediaUrl('images')}}" alt="{{$data['about_page_main']['title']}}" class="w-100">
                            </div>
                        </div>
                    </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about area end -->

    <!-- funfact area start -->
    <div class="tp-funfact-2-area fix pt-115 pb-95">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row justify-content-between">
                        <div class="col-xxl-5 col-lg-6 wow tpfadeLeft" data-wow-duration=".9s"
                        data-wow-delay=".5s">
                            <div class="tp-funfact-2-title-box mb-40">
                                <h3 class="tp-section-title mb-20">{{$data['about_page_vision']['title']}}</h3>
                                <p>{!! $data['about_page_vision']['description'] !!}</p>
                            </div>
                            <div class="tp-funfact-2-title-box">
                                <h3 class="tp-section-title mb-20">{{$data['about_page_mission']['title']}}</h3>
                                <p>{!! $data['about_page_mission']['description'] !!}</p>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-lg-6 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".7s">
                            <div class="tp-funfact-2-wrap">
                                <ul>
                                    @foreach($data['statistics'] as $item)
                                        <li>
                                            <div class="tp-funfact-item">
                                                <div class="p-relative">
                                                    <span>{{$item->title}}</span>
                                                    <h5 class="tp-funfact-2-number"><i class="purecounter" data-purecounter-duration="1"
                                                        data-purecounter-end="{{$item->value}}">0</i>@if ($item->metrics)+<sup>{{$item->metrics}}</sup>@endif
                                                    </h5>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- funfact area end -->

    <!-- service area start -->
    <div id="service-one-page" class="tp-service-area pt-110 pb-90">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row justify-content-center">
                        <div class="col-xl-7">
                            <div class="tp-service-title-box text-center mb-30">
                                <h4 class="tp-section-title mb-3">{{_t('Quality Policy')}}</h4>
                                <span class="tp-section-subtitle">{{_t('We maintain our product quality')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-lg-5 justify-content-center">
                        @foreach($data['policies'] as $item)
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-30 wow tpfadeUp" data-wow-duration=".9s"
                                data-wow-delay=".3s">
                                <div class="tp-service-item text-center">
                                    <div class="tp-service-thumb mb-10">
                                        <img src="{{$item->getFirstMediaUrl('logo')}}" alt="{{$item->description}}">
                                    </div>
                                    <div class="tp-service-content">
                                        <p class="pb-5">{{$item->description}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- service area end -->

    <!-- testimonial area start -->
    <div id="testimonial-one-page" class="tp-testimonial-2-area pt-110 pb-90 grey-bg3">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="tp-testimonial-2-title-box text-center mb-50">
                    <h3 class="tp-section-title">{{_t('Certificates')}}</h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="tp-testimonial-2-slider-box">
                        <div class="swiper-container tp-testimonial-2-active">
                            <div class="swiper-wrapper">
                                @foreach($data['certificates'] as $item)
                                    <div class="swiper-slide">
                                        <div class="tp-testimonial-2-item p-relative text-center">
                                            <div class="tp-testimonial-2-avata">
                                                <img src="{{$item->getFirstMediaUrl('logo')}}" alt="{{$item->title}}">
                                            </div>
                                            <div class="tp-testimonial-2-content">
                                                <div class="tp-testimonial-2-author-info">
                                                    <h4 class="tp-testimonial-2-author-name">{{$item->title}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- testimonial area end -->
@endsection