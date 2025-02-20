@foreach ($products as $product)
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-30">
        <div class="tp-product-item p-relative">
            <div class="tp-product-thumb-box p-relative mb-15">
                <div>
                    <img class="image-1" src="{{$product->getFirstMediaUrl('image')}}" alt="{{$page['title']}}">
                    <img class="image-2" src="{{$product->getFirstMediaUrl('image')}}" alt="{{$page['title']}}">
                </div>
            </div>
            <div class="tp-product-content">
                <p class="tp-product-title text-sm-start">
                    <span >{!! $product->description !!}</span>
                </p>
            </div>
        </div>
    </div>
@endforeach