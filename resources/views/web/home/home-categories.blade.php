@foreach($data['categories'] as $category)
    @if($loop->odd)
        <div class="tp-about-area grey-bg3 pt-120 pb-120">
            <div class="container-fluid">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-10">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-xl-6 col-lg-6">
                        <div class="p-relative">
                            <div class="tp-about-main-thumb">
                                <img src="{{$data['is_mobile'] ? $category->getFirstMediaUrl('mobile_images') : $category->getFirstMediaUrl('images')}}" alt="{{$category->title}}" class="w-100">
                            </div>
                        </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 wow tpfadeRight" data-wow-duration=".9s"
                        data-wow-delay=".5s">
                        <div class="tp-about-right">
                            <div class="tp-about-title-box mb-50">
                                <h4 class="tp-section-title">{{$category->title}}</h4>
                            </div>
                            <div class="tp-about-text mb-45">
                                <p>{!! $category->description !!}</p>
                            </div>
                            <div class="tp-about-button-box d-wrap d-sm-flex align-items-center">
                                <div class="tp-about-button">
                                    <a class="tp-btn-theme" href="{{LaravelLocalization::localizeUrl('/products/by-category/'.$category->slug)}}"><span>{{_t('Discover Collection')}}</span></a>
                                </div>
                                @if($category->getFirstMediaUrl('catalogue'))
                                    <div class="tp-about-contact">
                                        <a href="{{route('download.catalogue', ['id' => $category->id])}}">
                                        <span>
                                            <svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M6 20L18 20" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 4V16M12 16L15.5 12.5M12 16L8.5 12.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                        </span>
                                        {{_t('Download Catalogue')}}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    @else
        <div class="tp-about-area pt-120 pb-120">
            <div class="container-fluid">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-10">
                    <div class="row justify-content-between align-items-center">

                        <div class="col-xl-5 col-lg-5 order-1 order-lg-0 wow tpfadeRight" data-wow-duration=".9s"
                        data-wow-delay=".5s">
                        <div class="tp-about-right">
                            <div class="tp-about-title-box mb-50">
                                <h4 class="tp-section-title">{{$category->title}}</h4>
                            </div>
                            <div class="tp-about-text mb-45">
                                <p>{!! $category->description !!}</p>
                            </div>
                            <div class="tp-about-button-box d-wrap d-sm-flex align-items-center">
                                <div class="tp-about-button">
                                    <a class="tp-btn-theme" href="{{LaravelLocalization::localizeUrl('/products/by-category/'.$category->slug)}}"><span>{{_t('Discover Collection')}}</span></a>
                                </div>
                                @if($category->getFirstMediaUrl('catalogue'))
                                    <div class="tp-about-contact">
                                        <a href="{{route('download.catalogue', ['id' => $category->id])}}">
                                        <span>
                                            <svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M6 20L18 20" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 4V16M12 16L15.5 12.5M12 16L8.5 12.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                        </span>
                                        {{_t('Download Catalogue')}}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 order-0 order-lg-1">
                        <div class="p-relative">
                            <div class="tp-about-main-thumb">
                                <img src="{{$data['is_mobile'] ? $category->getFirstMediaUrl('mobile_images') : $category->getFirstMediaUrl('images')}}" alt="{{$category->title}}" class="w-100">
                            </div>
                        </div>
                        </div>

                    </div>
                </div>
            </div>
            </div>
        </div>
    @endif
@endforeach
