<!-- blog area start -->
<div class="tp-blog-area pt-120 pb-120 grey-bg3">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="tp-blog-title-wrap mb-50">
                    <div class="row align-items-end">
                        <div class="col-xl-6 col-lg-6 col-md-8">
                            <div class="tp-blog-title-box">
                                <h4 class="tp-section-title">{{_t('News & Blog')}}</h4>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-4">
                            <div class="tp-blog-button text-md-end">
                                <a class="tp-btn-theme" href="{{LaravelLocalization::localizeUrl('/blogs')}}"><span>{{_t('View All')}}</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($data['news'] as $news)
                        <div class="col-xl-3 col-lg-3 col-md-6 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                            <div class="tp-blog-item">
                                <div class="tp-blog-thumb fix p-relative mb-35">
                                    <a href="{{LaravelLocalization::localizeUrl('/blogs/'.$news->slug)}}">
                                    <img src="{{$news->getFirstMediaUrl('list_image')}}" alt="{{$news->title}}">
                                    </a>
                                    @if($news->author)
                                        <div class="tp-blog-tag">
                                            <span>{{_t('By')}}: {{$news->author}}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="tp-blog-content">
                                    <h4 class="tp-blog-title mb-15">
                                        <a class="text-anim" href="{{LaravelLocalization::localizeUrl('/blogs/'.$news->slug)}}">{{$news->title}}</a>
                                    </h4>
                                    <div class="tp-blog-meta d-flex align-items-center">
                                        <span>{{\Carbon\Carbon::parse($news->date)->translatedFormat('d M Y')}}</span>
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
<!-- blog area end -->
