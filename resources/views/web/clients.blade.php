@extends('web.layouts')
@section('content')
@include('web.components.breadcrumb')

<div class="tp-about-area grey-bg3 pt-120 pb-120">
    <div class="container-fluid">
       <div class="row align-items-center justify-content-center">
          <div class="col-md-10">
             <div class="row justify-content-between align-items-center">
                <div class="col-xl-12 col-lg-12 order-0 order-lg-1 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".5s">
                   <div class="tp-about-right">
                      <div class="tp-about-title-box mb-50">
                         <h4 class="tp-section-title">{{_t('Trusted By')}}</h4>
                      </div>
                   </div>
                </div>

                <div class="col-xl-12 col-lg-12 order-0 order-lg-2 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".6s">
                   <div class="row gap-y-30">
                        @foreach($data['clients_trusted'] as $client)
                            <div class="col-md-2">
                                <img src="{{$client->getFirstMediaUrl('logo')}}" alt="{{$client->name}}" class="w-100 rounded">
                            </div>
                        @endforeach
                   </div>
                </div>

             </div>
          </div>
       </div>
    </div>
</div>

<div class="tp-about-area pt-120 pb-120">
    <div class="container-fluid">
       <div class="row align-items-center justify-content-center">
          <div class="col-md-10">
             <div class="row justify-content-between align-items-center">
                <div class="col-xl-12 col-lg-12 order-0 order-lg-1 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".5s">
                   <div class="tp-about-right">
                      <div class="tp-about-title-box mb-50">
                         <h4 class="tp-section-title">{{_t('Contractors')}}</h4>
                      </div>
                   </div>
                </div>

                <div class="col-xl-12 col-lg-12 order-0 order-lg-2 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".6s">
                   <div class="row gap-y-30">
                        @foreach($data['clients_contractors'] as $client)
                            <div class="col-md-2">
                                <img src="{{$client->getFirstMediaUrl('logo')}}" alt="{{$client->name}}" class="w-100 rounded">
                            </div>
                        @endforeach
                   </div>
                </div>

             </div>
          </div>
       </div>
    </div>
</div>
@endsection
