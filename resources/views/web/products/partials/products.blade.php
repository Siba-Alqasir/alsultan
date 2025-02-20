@foreach($products as $product)
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-30">
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