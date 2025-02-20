<!-- slider area start -->
<div class="tp-slider-area">
    <div class="tp-slider-wrapper p-relative">
        <div class="tp-slider-arrow-wrap d-none d-xl-block">
            <div class="tp-slider-arrow-box">
                <button class="slider-prev">
                    <span>
                    <i class="fa-regular fa-arrow-left-long"></i>
                    </span>
                </button>
                <button class="slider-next">
                    <span>
                    <i class="fa-regular fa-arrow-right-long"></i>
                    </span>
                </button>
            </div>
        </div>
        <div class="swiper-container tp-slider-active">
            <div class="swiper-wrapper">
                @foreach($data['sliders'] as $slider)
                    <div class="swiper-slide">
                        <div class="tp-slider-height tp-slider-overlay p-relative">
                        <div class="tp-slider-box">
                            <div class="tp-slider-bg" data-background="{{$data['is_mobile'] ? $slider->getFirstMediaUrl('mobile_images') : $slider->getFirstMediaUrl('images')}}"></div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-xxxl-8 col-xxl-7 col-xl-7 col-lg-8 col-md-10">
                                    <div class="tp-slider-content z-index">
                                        <div class="tp-slider-title-box mb-30">
                                            <h1 class="tp-slider-title"><span>{{$slider->sub_title}}</span><br>{{$slider->title}}</h1>
                                        </div>
                                        <div class="tp-slider-text-wrap-box">
                                            <div class="tp-slider-text-wrap">
                                                <div class="tp-slider-text">
                                                <p>{!! $slider->description !!}</p>
                                                <a class="tp-btn-theme" href="{{$slider->btn_link}}" target="blanck">
                                                    <span>{{$slider->btn_title}}</span>
                                                </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                @endforeach  
            </div>
        </div>
    </div>
 </div>
 <!-- slider area end -->