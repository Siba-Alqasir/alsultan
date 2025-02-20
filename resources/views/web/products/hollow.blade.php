@extends('web.layouts')
@section('content')
@include('web.components.breadcrumb')

<div class="tp-product-details-area tp-product-style-2 pt-120 pb-90">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="row mb-20">
                            <div class="col-12">
                                <div class="tp-product-top pb-15">
                                    <div class="row align-items-center">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <div class="sidebar__widget p-1">
                                                <div class="sidebar__widget-content">
                                                    <div class="sidebar__search">
                                                        <div class="sidebar__search-input-2">
                                                            <input id="search-input" type="text" placeholder="{{_t('What are you looking for?')}}">
                                                            <button type="button" id="search-button"><i class="far fa-search"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3" id="results">
                                            @include('web.products.partials.results', ['products' => $data['products']])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tp-product-wrap">
                            <div class="row" id="products-container">
                                @include('web.products.partials.hollow-products', ['products' => $data['products'], 'page' => $data['page']])
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
    let selectedType = '';
    let currentPage = 1;
    function fetchProducts() {
        const slug = "{{ $data['page']['slug'] }}";
        const searchValue = $('#search-input').val();
        const url = `/products/by-category/${slug}?search=${searchValue}&page=${currentPage}&locale=${locale}`;

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
    $(document).on('click', '.basic-pagination nav a', function (e) {
        e.preventDefault();
        currentPage = $(this).data('page');
        fetchProducts();
    });
});
</script>
@endpush