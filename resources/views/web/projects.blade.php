@extends('web.layouts')
@section('content')
@include('web.components.breadcrumb')
@foreach($data['projects'] as $project)
    @if($loop->odd)
        <div class="tp-about-area grey-bg3 pt-120 pb-120">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-10">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-xl-6 col-lg-6 order-1 order-lg-0">
                                <div class="p-relative">
                                    <div class="tp-about-main-thumb">
                                        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach($project->getMedia('gallery') as $key=>$item)
                                                    <div class="carousel-item {{$loop->first ? 'active' : ''}}">
                                                        <img src="{{$item->getUrl()}}" class="d-block w-100" alt="{{$project->title}}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if(count($project->getMedia('gallery')) > 1)
                                                <div class="tp-slider-arrow-box">
                                                    <button class="slider-prev" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                                                        <span>
                                                        <i class="fa-regular fa-arrow-left-long"></i>
                                                        </span>
                                                    </button>
                                                    <button class="slider-next" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                                                        <span>
                                                        <i class="fa-regular fa-arrow-right-long"></i>
                                                        </span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-5 order-0 order-lg-1 wow tpfadeRight" data-wow-duration=".9s"
                                data-wow-delay=".5s">
                                <div class="tp-about-right">
                                    <div class="tp-about-title-box mb-50">
                                        <h4 class="tp-section-title">{{$project->title}}</h4>
                                    </div>
                                    <div class="tp-about-text mb-45">
                                        <p> {!! $project->description !!} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="tp-about-area pt-110 pb-120">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-10">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-xl-5 col-lg-5 wow tpfadeRight" data-wow-duration=".9s"
                                data-wow-delay=".5s">
                                <div class="tp-about-right">
                                    <div class="tp-about-title-box mb-50">
                                        <h4 class="tp-section-title">{{$project->title}}</h4>
                                    </div>
                                    <div class="tp-about-text mb-45">
                                        <p> {!! $project->description !!} </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6">
                                <div class="p-relative">
                                    <div class="tp-about-main-thumb">
                                        <div id="carouselExampleFade2" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach($project->getMedia('gallery') as $key=>$item)
                                                    <div class="carousel-item {{$loop->first ? 'active' : ''}}">
                                                        <img src="{{$item->getUrl()}}" class="d-block w-100" alt="{{$project->title}}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if(count($project->getMedia('gallery')) > 1)
                                                <div class="tp-slider-arrow-box">
                                                    <button class="slider-prev" data-bs-target="#carouselExampleFade2" data-bs-slide="prev">
                                                        <span>
                                                        <i class="fa-regular fa-arrow-left-long"></i>
                                                        </span>
                                                    </button>
                                                    <button class="slider-next" data-bs-target="#carouselExampleFade2" data-bs-slide="next">
                                                        <span>
                                                        <i class="fa-regular fa-arrow-right-long"></i>
                                                        </span>
                                                    </button>
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
        </div>
    @endif
@endforeach

{{-- Gallery --}}
@if(count($data['gallery']) > 0)
    <div class="pt-120 pb-120 projects-gallery-area">
        <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row gallery projects-gallery" id="gallery-append">
                    @include('web.components.gallery', ['gallery' => $data['gallery']])
                </div>
                @if($data['hasMore'])
                    <div class="row justify-content-center" id="load-more-container">
                        <div class="col-md-10 text-center">
                            <div class="tp-about-button">
                                <button id="load-more" class="tp-btn-theme gallery-load-more"><span>{{_t('Load More')}}</span></button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        </div>
    </div>
@endif
@endsection
@push('page-scripts')
<script>
    $(document).ready(function () {
    $('.gallery').magnificPopup({
       delegate: 'a', // Selects the anchor tags inside the gallery
       type: 'image',
       gallery: {
          enabled: true, // Enables gallery mode
          navigateByImgClick: true, // Allows navigation by clicking on images
          preload: [0, 1] // Preloads previous and next images
       }
    });
    });
</script>

<script>
    let offset = {{ count($data['gallery']) }}; // Start with the number of initial loaded spotlights
    const limit = 4; // Items to load per request

    $('#load-more').on('click', function() {
        $.ajax({
            url: "{{ route('gallery.load-more') }}",
            type: 'GET',
            data: {
                offset: offset
            },
            success: function(response) {
                if(response.html) {
                    $('#gallery-append').append(response.html);
                    offset += limit;

                    // If there are no more items to load, hide the load more button
                    if (!response.hasMore) {
                        $('#load-more-container').hide();
                    }
                }
            }
        });
    });
</script>
@endpush
