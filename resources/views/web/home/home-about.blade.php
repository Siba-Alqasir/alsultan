 <!-- video area start -->
 <div class="tp-video-area">
    <div class="container-fluid p-0">
       <div class="row gx-0 justify-content-center">
          <div class="col-xl-10">
             <div class="tp-video-box p-relative">
                <div class="tp-video-thumb">
                   <img src="{{$data['is_mobile'] ? $data['home_page_visualizer']->getFirstMediaUrl('mobile_images') : $data['home_page_visualizer']->getFirstMediaUrl('images') }}" alt="{{$data['home_page_visualizer']['title']}}" class="w-100">
                </div>
                <div class="tp-video-play-button">
                   <h1>{{$data['home_page_visualizer']['title']}}</h1>
                   <p>{!! $data['home_page_visualizer']['description'] !!}</p>
                   <a class="popup-video d-none" href="{{$data['home_page_visualizer']['highlight']}}">{{_t('START')}}</a>
                   <div class="coming-soon-statment">{{_t('Coming Soon')}}</div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
 <!-- video area end -->

<!-- about area start -->
<div id="about-one-page" class="tp-about-area tp-about-wrapper fix pt-120 pb-120">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-10">
                <div class="row justify-content-between align-items-center">

                <div class="col-xl-5 col-lg-5 wow tpfadeRight" data-wow-duration=".9s"
                    data-wow-delay=".5s">
                    <div class="tp-about-right">
                        <div class="tp-about-title-box mb-50">
                            <h4 class="tp-section-title">{{$data['home_page_about']['title']}}</h4>
                        </div>
                        <div class="tp-about-text mb-45">
                            <p>{!! $data['home_page_about']['description'] !!}</p>
                        </div>
                        <div class="tp-about-button-box d-wrap d-sm-flex align-items-center">
                            <div class="tp-about-button">
                            <a class="tp-btn-theme" href="{{$data['home_page_about']['btn_link']}}"><span>{{$data['home_page_about']['btn_title']}}</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6">
                    <div class="p-relative">
                        <div class="tp-about-main-thumb">
                            <img src="{{$data['is_mobile'] ? $data['home_page_about']->getFirstMediaUrl('mobile_images') : $data['home_page_about']->getFirstMediaUrl('images') }}" alt="{{$data['home_page_about']['title']}}" class="w-100">
                        </div>
                    </div>
                </div>
                
                </div>
            </div>
        </div>
    </div>
</div>
<!-- about area end -->

{{-- Insatgram --}}
<div class="ig-area">
    <div class="container-fluid">
       <div class="row justify-content-center">
          <div class="col-md-10">
             <div class="ig-area-block">
                <script src="https://static.elfsight.com/platform/platform.js" async></script>
                <div class="elfsight-app-a304fbab-4d4b-4c5c-9ef5-ee721ef0b188" data-elfsight-app-lazy></div>
             </div>
          </div>
       </div>
    </div>
 </div>
 {{-- Insatgram --}}