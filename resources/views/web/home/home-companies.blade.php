<div id="testimonial-one-page" class="tp-testimonial-2-area pt-120 pb-120">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="tp-testimonial-2-title-box text-center mb-50">
                    <h3 class="tp-section-title">{{_t('Sister Companies')}}</h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="tp-testimonial-2-slider-box">
                    <div class="swiper-container tp-testimonial-2-active">
                        <div class="swiper-wrapper">
                            @foreach($data['sister_companies'] as $company)
                                <div class="swiper-slide">
                                    <div class="tp-testimonial-2-item p-relative">
                                        <div class="tp-testimonial-2-avata">
                                            <a href="{{$company->url ?? '#'}}" target="_blank" @if(!$company->url) onclick="return false;" @endif>
                                                <img src="{{$company->getFirstMediaUrl('logo')}}" alt="{{$company->name}}">
                                            </a>
                                        </div>
                                        <div class="tp-testimonial-2-content">
                                            <div class="tp-testimonial-2-author-info">
                                                <h4 class="tp-testimonial-2-author-name">{{$company->name}}</h4>
                                            </div>
                                            <div class="tp-testimonial-2-text">
                                                <p>
                                                    {!! $company->description !!}
                                                </p>
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