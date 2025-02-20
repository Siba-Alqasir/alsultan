@extends('web.layouts')
@section('content')
    @include('web.components.breadcrumb')
    <div id="about-one-page" class="tp-about-area tp-about-wrapper fix pt-110 pb-120">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-10">
                    <div class="row justify-content-between align-items-center">
                        @if(count($data['search_categories']) > 0)
                            <div class="col-xl-6 col-lg-6 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".5s">
                                <div class="tp-about-right">
                                    <div class="tp-about-title-box mb-50">
                                        <h4 class="tp-section-title">{{_t('Categories')}}:</h4>
                                    </div>
                                    <div class="tp-about-text mb-45">
                                        @foreach($data['search_categories'] as $category)
                                            <li>
                                                <a href="{{LaravelLocalization::localizeUrl('/products/by-category/'.$category->slug)}}">{{$category->title}}</a>
                                            </li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(count($data['search_products']) > 0)
                            <div class="col-xl-6 col-lg-6 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".5s">
                                <div class="tp-about-right">
                                    <div class="tp-about-title-box mb-50">
                                        <h4 class="tp-section-title">{{_t('Products')}}:</h4>
                                    </div>
                                    <div class="tp-about-text mb-45">
                                        @foreach($data['search_products'] as $product)
                                            <li>
                                                <a href="{{$product->title ? LaravelLocalization::localizeUrl('/products/'.$product->slug) : LaravelLocalization::localizeUrl('/products/by-category/'.$product->category->slug)}}">{{$product->title ? $product->title : strip_tags($product->description)}}</a>
                                            </li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(count($data['search_products']) === 0 && count($data['search_categories']) === 0)
                            <img src="{{URL::asset('web-assets/img/no-results.svg')}}" alt="{{$data['page']['title']}}" width="400" height="400">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
