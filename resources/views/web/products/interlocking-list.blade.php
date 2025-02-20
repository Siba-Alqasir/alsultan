@extends('web.layouts')
@section('content')
@include('web.components.breadcrumb')

<div class="tp-product-details-area tp-product-style-2 pt-120 pb-90">
    <div class="container-fluid">
       <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-xl-3 col-lg-3">
                        <div class="sidebar_mobile d-md-none d-block">
                            <div class="text-center">
                                <button class="tp-btn-grey rq-top-btn fs-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop">
                                    <i class="fa-light fa-list"></i> {{_t('Filter Products By')}} :
                                </button>
                            </div>

                            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel">
                                <div class="offcanvas-header offcanvas-header p-0 mt-20 mr-20 justify-content-end">
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body p-0">
                                    <div class="sidebar__widget mb-25">
                                        <h3 class="sidebar__widget-title mb-30">{{_t('By Category')}}</h3>
                                        <div class="sidebar__widget-content">
                                            <ul>
                                                @foreach(\App\Models\Category::all() as $category)
                                                    <li><a href="{{LaravelLocalization::localizeUrl('/products/by-category/'.$category->slug)}}">{{$category->title}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="sidebar__widget mb-25">
                                        <h3 class="sidebar__widget-title mb-20">{{_t('By Size')}}</h3>
                                        <div class="sidebar__widget-content content-style-2">
                                            <ul id="size-filter">
                                                @foreach(\App\Models\Size::all() as $size)
                                                    <li><a href="#" data-size="{{ $size->id }}">{{$size->title}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>                           
                        </div>
                    
                        <div class="sidebar__wrapper d-md-block d-none">
                            <div class="sidebar__widget mb-25">
                                <h3 class="sidebar__widget-title mb-30">{{_t('By Category')}}</h3>
                                <div class="sidebar__widget-content">
                                    <ul>
                                        @foreach(\App\Models\Category::all() as $category)
                                            <li><a href="{{LaravelLocalization::localizeUrl('/products/by-category/'.$category->slug)}}">{{$category->title}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="sidebar__widget mb-25">
                                <h3 class="sidebar__widget-title mb-20">{{_t('By Size')}}</h3>
                                <div class="sidebar__widget-content content-style-2">
                                    <ul id="size-filter">
                                        @foreach(\App\Models\Size::all() as $size)
                                            <li><a href="#" data-size="{{ $size->id }}">{{$size->title}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9">
                        <div class="row mb-20">
                            <div class="col-12">
                                <div class="tp-product-top pb-15 d-md-block d-none">
                                    <div class="row align-items-center">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <div class="sidebar__widget p-1">
                                                <div class="sidebar__widget-content">
                                                    <div class="sidebar__search">
                                                        <div class="sidebar__search-input-2">
                                                            <input id="search-input" type="text" name="search" placeholder="{{ _t('What are you looking for?')}}">
                                                            <button type="button" id="search-button"><i class="far fa-search"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3" id="results">
                                            @include('web.products.partials.results', ['products' => $data['products']])
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                                            <div class="tp-product__filter d-flex justify-content-sm-end">
                                                <select name="filter" id="filter-select">
                                                    <option value="recent">{{_t('Recently Added')}}</option>
                                                    <option value="a-z">{{_t('Order (A-Z)')}}</option>
                                                    <option value="z-a">{{_t('Order (Z-A)')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="tp-product-wrap">
                            <div class="row" id="products-container">
                                @include('web.products.partials.products', ['products' => $data['products']])
                            </div>
                            <div id="pagination-container">
                                @include('web.products.partials.pagination', ['products' => $data['products']])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
<script>
$(document).ready(function() {
    let locale = "{{app()->getLocale()}}"
    let selectedSize = '';
    let currentPage = 1;
    function fetchProducts() {
        const slug = "{{ $data['page']['slug'] }}";
        const filterValue = $('#filter-select').val();
        const searchValue = $('#search-input').val();
        const sizeValue = selectedSize;
        const url = `/products/by-category/${slug}?filter=${filterValue}&search=${searchValue}&size=${selectedSize}&page=${currentPage}&locale=${locale}`;

        let productsContainer = document.getElementById('products-container');
        productsContainer.innerHTML = '<p>{{_t('Loading')}}...</p>';
        let resultsContainer = document.getElementById('results');
        resultsContainer.innerHTML = '';
        let paginationContainer = document.getElementById('pagination-container');
        paginationContainer.innerHTML = '';
        fetch(url)
            .then(response => response.json())
            .then(data => {
                
                if (data.html.trim() !== '') {
                    productsContainer.innerHTML = data.html;
                    paginationContainer.innerHTML = data.pagination;
                    resultsContainer.innerHTML = data.results;
                }
                else {
                    productsContainer.innerHTML = '<p>{{_t('No products found')}}.</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    $('#filter-select').on('change', () => {
        currentPage = 1;
        fetchProducts();
    });
    $('#search-button').on('click',  () => {
        currentPage = 1;
        fetchProducts();
    });
    $('#search-input').on('keypress', function (e) {
        if (e.which === 13) {
            currentPage = 1;
            fetchProducts();
        }
    });

    $('#size-filter a').on('click', function (e) {
        e.preventDefault();
        currentPage = 1;
        selectedSize = $(this).data('size');
        $('#size-filter a').removeClass('active');
        $(this).addClass('active');
        fetchProducts();
    });

    $(document).on('click', '.basic-pagination nav a', function (e) {
        e.preventDefault();
        currentPage = $(this).data('page');
        fetchProducts();
    });
});
</script>
@endpush