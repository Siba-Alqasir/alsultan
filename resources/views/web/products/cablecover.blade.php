@extends('web.layouts')
@section('content')
@include('web.components.breadcrumb')
<div class="tp-about-area grey-bg3 pt-120 pb-120">
    <div class="container-fluid">
       <div class="row align-items-center justify-content-center">
          <div class="col-md-10">
             <div class="row justify-content-between align-items-center">
                <div class="col-xl-6 col-lg-6 order-1 order-lg-0">
                   <div class="p-relative">
                      <div class="tp-about-main-thumb">
                         <img src="{{$data['is_mobile'] ? $data['page']->getFirstMediaUrl('mobile_images') : $data['page']->getFirstMediaUrl('images')}}" alt="{{$data['page']['title']}}" class="w-100">
                      </div>
                   </div>
                </div>
                <div class="col-xl-5 col-lg-5 order-0 order-lg-1 wow tpfadeRight" data-wow-duration=".9s"
                   data-wow-delay=".5s">
                    <div class="tp-about-right">
                        <div class="tp-about-title-box mb-50">
                            <h4 class="tp-section-title">{{$data['page']['title']}}</h4>
                        </div>
                        <div class="tp-about-text mb-45">
                                <p>{!! $data['page']['description'] !!}</p>
                        </div>                      
                    </div>
                </div>
             </div>
          </div>
       </div>
    </div>
</div>

<div class="bysize-main-table cablecover-table pt-120 pb-120  d-none d-lg-block">
    <div class="container-fluid">
       <div class="row justify-content-center">
          <div class="col-md-10">
             <div class="row">
                <div class="col-md-12">
                    <table class="bysize-table">
                        <thead>
                            <tr>
                                <th>{{_t('IMAGE')}}</th>
                                <th>{{_t('SN')}}</th>
                                <th>{{_t('DESCRIPTION')}}</th>
                                <th>{{_t('SIZE')}}</th>
                                <th>{{_t('DATA SHEET')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['products'] as $product)
                                <tr>
                                    <td>
                                        <img src="{{$product->getFirstMediaUrl('image')}}" alt="{{$product->description}}">
                                    </td>
                                    <td>{{$product->serial_number}}</td>
                                    <td>{!! $product->description !!}</td>
                                    <td>{{$product->size}}</td>
                                    <td>
                                        @if($product->getFirstMedia('data_sheet')) <a href="{{route('download.product.file', ['file' => $product->getFirstMedia('data_sheet')])}}">{{_t('Download Data Sheet')}} <i class="fa fa-download ms-2"></i> </a>
                                        @else
                                            {{_t('No file found')}}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
             </div>
          </div>
       </div>
    </div>
</div>
<div class="pt-20 pb-20 d-block d-lg-none">
    <div class="container">
        <div class="row justify-content-center">
            @foreach($data['products'] as $product)
                <div class="col-md-3">
                    <div class="cablecover-card">
                        <img src="{{$product->getFirstMediaUrl('image')}}" alt="{{$product->description}}">
                        <p><span>{{_t('SN')}} :</span><br>{{$product->serial_number}}</p>
                        <p><span>{{_t('Description')}} :</span><br>{!! $product->description !!}</p>
                        <p><span>{{_t('Size')}} :</span><br>{{$product->size}}</p>
                        @if($product->getFirstMedia('data_sheet'))
                            <div class="cablecover-download-btn">
                                <a href="{{route('download.product.file', ['file' => $product->getFirstMedia('data_sheet')])}}">{{_t('Download Data Sheet')}}
                                <i class="fa fa-download ms-2"></i></a>
                            </div>
                        @else
                            <p><span>{{'No file found'}}</span></p>
                        @endif
                    </div>
                </div>
            @endforeach   
        </div>
   </div>
</div>
@endsection