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
                    <span >{{_t('Size')}}: {{$product->size}}</span>
                </p>
                <p class="tp-product-title text-sm-start">
                    <span>{{_t('Weight')}}: {{$product->weight}} {{_t('kg/kerb')}}</span>
                </p>
                <p class="tp-product-title text-sm-start">
                    <span>{{_t('Finish')}}: {{\App\Models\Finish::find($product->finishes[0]->attribute_id)->title}}</span>
                </p>
                <p class="tp-product-title text-sm-start">
                    <span>{{_t('Type')}}: {{\App\Models\Type::find($product->types[0]->attribute_id)->title}}</span>
                </p>
                <hr>
                <p class="tp-product-title">
                @if($product->getFirstMedia('data_sheet'))
                    <a href="{{route('download.product.file', ['file' => $product->getFirstMedia('data_sheet')])}}" class="text-anim">{{_t('Download Data Sheet')}}</a>
                @else
                    <p class="tp-product-title text-sm-start">
                        <span>{{'No file found'}}</span>
                    </p>
                @endif
                </p>
            </div>
        </div>
    </div>
@endforeach