@extends('web.layouts')
@section('content')
<!-- breadcrumb area start -->
<div class="breadcrumb__area breadcrumb__height grey-bg p-relative product-details-breadcrumb-height">
    <div class="container">
       <div class="row">
          <div class="col-xxl-12">
             <div class="breadcrumb__content text-center z-index product-details-breadcrumb">
                <div class="breadcrumb__list">
                   <span><a href="{{LaravelLocalization::localizeUrl('/')}}">{{_t('Home')}}</a></span>
                   <span class="dvdr">&nbsp;&bullet;&nbsp;</span>
                   <span><a href="{{LaravelLocalization::localizeUrl('/products/by-category/'.$data['page']['category']['slug'])}}">{{_t('Products')}}</a></span>
                   <span class="dvdr">&nbsp;&bullet;&nbsp;</span>
                   <span>{{$data['page']['title']}}</span>
                </div>
             </div>
          </div>
       </div>
    </div>
</div>
<!-- breadcrumb area end -->

<div class="product-details-area pt-100">
    <div class="tp-product-details-top pb-70">
       <div class="container-fluid">
          <div class="row justify-content-center">
             <div class="col-md-10">
                <div class="row justify-content-evenly">
                   <div class="col-xl-5 col-lg-5">
                      <div class="tp-product-details-thumb-wrapper tp-tab">
                         <div class="tab-content m-img" id="productDetailsNavContent">
                           @foreach ($data['page']->getMedia('gallery') as $image)
                              <div class="tab-pane fade {{$loop->iteration == 1 ? 'active show' : ''}}" id="nav-{{$loop->iteration}}" role="tabpanel" aria-labelledby="nav-{{$loop->iteration}}-tab"
                                 tabindex="0">
                                 <div class="tp-product-details-nav-main-thumb">
                                    <img src="{{$image->getUrl()}}" alt="">
                                 </div>
                              </div>

                              <div class="tab-pane fade" id="nav-{{$loop->iteration}}" role="tabpanel" aria-labelledby="nav-{{$loop->iteration}}-tab"
                                 tabindex="0">
                                 <div class="tp-product-details-nav-main-thumb">
                                    <img src="{{$image->getUrl()}}" alt="{{$data['page']['title']}}">
                                 </div>
                              </div>
                           @endforeach 
                         </div>
                         <nav>
                            <div class="nav nav-tabs d-flex justify-content-center justify-content-lg-start"
                               id="productDetailsNavThumb" role="tablist">
                               @foreach ($data['page']->getMedia('gallery') as $image)
                                 <button class="nav-link {{$loop->iteration == 1 ? 'active' : ''}}" id="nav-{{$loop->iteration}}-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-{{$loop->iteration}}" type="button" role="tab" aria-controls="nav-{{$loop->iteration}}"
                                    aria-selected="true">
                                    <img src="{{$image->getUrl()}}" alt="{{$data['page']['title']}}">
                                 </button>
                               @endforeach
                            </div>
                         </nav>
                      </div>
                   </div>
                   <!-- col end -->
                   <div class="col-xl-6 col-lg-6">
                      <div class="tp-product-details-wrapper">
                         <div class="tp-product-details-title-content">
                            <h3 class="single-product-title d-inline-block mb-20">{{$data['page']['title']}}</h3>
                            <!-- <span>On Sale</span> -->
                         </div>
                         <!-- inventory details -->
                         <div class="tp-product-details-inventory d-sm-flex flex-wrap align-items-center mb-20">
                            <div class="tp-product-details-stock">
                               <h4>{{_t('Category')}}: <span class="brand-type">{{$data['page']['category']['title']}}</span></h4>
                            </div>
                         </div>
                         <p class="tp-product-details-price-dsc mb-25">{!! $data['page']['description'] !!}</p>
                         <!-- model -->

                         <div class="tp-product-details-model mb-40">
                              <h4>{{_t('Colour Tiles')}}</h4>
                              
                              <div class="product-colour-area">
                                    @foreach ($data['page']->colors as $item)
                                       <div>
                                          <img src="{{\App\Models\Color::find($item->attribute_id)->getFirstMediaUrl('images')}}">
                                          <p>{{\App\Models\Color::find($item->attribute_id)->title}}</p>
                                       </div>
                                    @endforeach
                              </div>
                         </div>

                         <div class="tp-product-details-model mb-40">
                            <h4>{{_t('Finishes')}}</h4>
                            
                            <div class="product-colour-area">
                                 @foreach ($data['page']->finishes as $item)
                                    <div class="p-relative">
                                       <img src="{{\App\Models\Finish::find($item->attribute_id)->getFirstMediaUrl('images')}}">
                                       <p>{{\App\Models\Finish::find($item->attribute_id)->title}}</p>
                                       <div class="tp-product-icon finish-tooltip">
                                          <button>
                                             <i class="fa fa-info">
                                             </i>
                                             <span class="tp-product__tooltip p-relative">
                                                <div class="p-2 w-100 border-0">
                                                   {{ strip_tags(\App\Models\Finish::find($item->attribute_id)->description) }}
                                                   <br>
                                                   <a class="p-2" href="{{LaravelLocalization::localizeUrl('/treatments')}}">{{_t('Learn More')}}</a>
                                                </div>
                                             </span>
                                          </button>
                                       </div>
                                    </div>
                                 @endforeach
                            </div>

                         </div>

                         <div class="tp-product-details-model mb-40">
                              <h4>{{_t('Sizes')}}</h4>
                              
                              <div class="product-size-area">
                                    @foreach ($data['page']->sizes as $item)
                                       <div class="size-box">
                                             <img src="{{\App\Models\Size::find($item->attribute_id)->getFirstMediaUrl('images')}}">
                                             <div>
                                                <h3>{{\App\Models\Size::find($item->attribute_id)->title}}</h3>
                                                <p>{!! \App\Models\Size::find($item->attribute_id)->description !!}</p>
                                             </div>
                                       </div>
                                    @endforeach
                              </div>

                         </div>

                         <div class="tp-product-details-model mb-40">
                            <h4>{{_t('Patterns')}}</h4>
                            
                            <div class="product-colour-area">
                                 @foreach ($data['page']->patterns as $item)
                                    <div>
                                       <img src="{{\App\Models\Pattern::find($item->attribute_id)->getFirstMediaUrl('images')}}">
                                       <p>{{\App\Models\Pattern::find($item->attribute_id)->title}}</p>
                                    </div>
                                 @endforeach
                            </div>

                         </div>

                         <div class="tp-product-details-model mb-40">
                            <h4>{{_t('Downloads')}}</h4>

                            <div class="d-flex download-documents">
                                 @if($data['page']->getFirstMedia('data_sheet'))
                                    <a href="{{route('download.product.file', ['file' => $data['page']->getFirstMedia('data_sheet')])}}" class="product-download-btn me-3">
                                       <p>{{_t('Download Technical Data sheet')}}</p>
                                       <svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M12 13V22M12 22L15.5 18.5M12 22L8.5 18.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M20 17.6073C21.4937 17.0221 23 15.6889 23 13C23 9 19.6667 8 18 8C18 6 18 2 12 2C6 2 6 6 6 8C4.33333 8 1 9 1 13C1 15.6889 2.50628 17.0221 4 17.6073" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    </a>
                                 @endif
                                 @if($data['page']->getFirstMedia('catalogue'))
                                    <a href="{{route('download.product.file', ['file' => $data['page']->getFirstMedia('catalogue')])}}" class="product-download-btn me-3">
                                       <p>{{_t('Download Product Catalogue')}}</p>
                                       <svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M12 13V22M12 22L15.5 18.5M12 22L8.5 18.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M20 17.6073C21.4937 17.0221 23 15.6889 23 13C23 9 19.6667 8 18 8C18 6 18 2 12 2C6 2 6 6 6 8C4.33333 8 1 9 1 13C1 15.6889 2.50628 17.0221 4 17.6073" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    </a>
                                 @endif
                                 @if($data['page']->getFirstMedia('guide'))
                                    <a href="{{route('download.product.file', ['file' => $data['page']->getFirstMedia('guide')])}}" class="product-download-btn me-3">
                                       <p>{{_t('Installation Guide')}}</p>
                                       <svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M12 13V22M12 22L15.5 18.5M12 22L8.5 18.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M20 17.6073C21.4937 17.0221 23 15.6889 23 13C23 9 19.6667 8 18 8C18 6 18 2 12 2C6 2 6 6 6 8C4.33333 8 1 9 1 13C1 15.6889 2.50628 17.0221 4 17.6073" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    </a>
                                 @endif
                            </div>

                         </div>
                         <div class="tp-product-details-action-item-wrapper d-sm-flex flex-wrap align-items-center">
                            <div class="tp-product-details-add-to-cart w-100">
                               <a href="{{LaravelLocalization::localizeUrl('/inquiry')}}" class="tp-product-details-add-to-cart-btn w-100">{{_t('Inquire Now')}}</a>
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

<!-- product area start -->
@if(count($data['products']) > 0)
<div class="tp-product-area pt-100 pb-100 p-relative fix grey-bg3">
   <div class="container-fluid">
      <div class="row justify-content-center">
         <div class="col-md-10">
            <div class="row">
               <div class="col-xl-12">
                  <div class="tp-product-title-box mb-50">
                     <h3 class="tp-section-title">{{_t('Related Products')}}</h3>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-xl-12">
                  <div class="tp-prduct-wrapper">
                     <div class="swiper-container tp-product-active-3">
                        <div class="swiper-wrapper">
                           @foreach($data['products'] as $product)
                              <div class="swiper-slide">
                                 <div class="tp-product-item p-relative">
                                    <div class="tp-product-thumb-box p-relative mb-15">
                                       <a href="{{LaravelLocalization::localizeUrl('/products/'.$product->slug)}}">
                                          @foreach($product->getMedia('gallery')->take(2) as $image)
                                             <img class="image-{{$loop->iteration}}" src="{{$image->getUrl()}}" alt="{{$product->title}}">
                                          @endforeach
                                       </a>
                                    </div>
                                    <div class="tp-product-content">
                                       <h4 class="tp-product-title"><a href="{{LaravelLocalization::localizeUrl('/products/'.$product->slug)}}"
                                             class="text-anim">{{$product->title}}</a></h4>
                                       
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
   </div>
</div>
@endif
<!-- product area end -->


<!-- newsletter area start -->
<div class="tp-newsletter-area tp-newsletter-bg z-index" data-background="{{$data['is_mobile'] ? $data['tailor_made_design']->getFirstMediaUrl('mobile_images') : $data['tailor_made_design']->getFirstMediaUrl('images')}}">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-xl-8 col-lg-7 col-md-7">
            <div class="tp-newsletter-title-box">
               <span class="tp-section-subtitle text-white">{{$data['tailor_made_design']['sub_title']}}</span>
               <h4 class="tp-newsletter-title cta-title"> {!! $data['tailor_made_design']['title'] !!}
               </h4>
            </div>
         </div>
         <div class="col-xl-4 col-lg-5 col-md-5">
            <div class="tp-newsletter-button text-md-end">
               <a href="{{$data['tailor_made_design']['btn_link']}}"><button type="submit">
                  <span class="text-white">
                     {{$data['tailor_made_design']['btn_title']}}
                  </span>
               </button></a>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- newsletter area end -->

@endsection