@extends('web.layouts')
@section('content')
@include('web.components.breadcrumb')

@foreach($data['services'] as $service)
    @if($loop->odd)
    <div class="tp-about-area grey-bg3 pt-120 pb-120">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-10">
                    <div class="row justify-content-between align-items-center">
                    <div class="col-xl-6 col-lg-6 order-1 order-lg-0">
                        <div class="p-relative">
                            <div class="tp-about-main-thumb">
                                <img src="{{$data['is_mobile'] ? $service->getFirstMediaUrl('mobile_images') : $service->getFirstMediaUrl('images')}}" alt="{{$service->title}}" class="w-100">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 order-0 order-lg-1 wow tpfadeRight" data-wow-duration=".9s"
                        data-wow-delay=".5s">
                        <div class="tp-about-right">
                            <div class="tp-about-title-box mb-50">
                                <h4 class="tp-section-title">{{$service->title}}</h4>
                            </div>
                            <div class="tp-about-text mb-45">
                                <p> {!! $service->description !!} </p>
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
                                <h4 class="tp-section-title">{{$service->title}}</h4>
                            </div>
                            <div class="tp-about-text mb-45">
                                <p>{!! $service->description !!}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6">
                        <div class="p-relative">
                            <div class="tp-about-main-thumb">
                                <img src="{{$data['is_mobile'] ? $service->getFirstMediaUrl('mobile_images') : $service->getFirstMediaUrl('images')}}" alt="{{$service->title}}" class="w-100">
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
@endsection