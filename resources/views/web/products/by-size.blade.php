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
                         <img src="{{$data['is_mobile'] ? $data['by_size_page_main']->getFirstMediaUrl('mobile_images') : $data['by_size_page_main']->getFirstMediaUrl('images')}}" alt="{{$data['by_size_page_main']['title']}}" class="w-100">
                      </div>
                   </div>
                </div>
                <div class="col-xl-5 col-lg-5 order-0 order-lg-1 wow tpfadeRight" data-wow-duration=".9s"
                   data-wow-delay=".5s">
                   <div class="tp-about-right">
                      <div class="tp-about-title-box mb-50">
                         <h4 class="tp-section-title">{{$data['by_size_page_main']['title']}}</h4>
                      </div>
                      <div class="tp-about-text mb-45">
                         <p>{!! $data['by_size_page_main']['description'] !!}</p>
                      </div>
                      
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
</div>

<div class="bysize-main-table pt-120 pb-120 d-none d-lg-block">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12">
                        <table class="bysize-table">
                            <thead>
                                <tr>
                                  <th>{{('IMAGE')}}</th>
                                  <th>{{('DESCRIPTION')}}</th>
                                  <th>{{('COLORS')}}</th>
                                  <th>{{('FINISH')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['products'] as $product)
                                    <tr>
                                        <td>
                                        <img src="{{$product->getFirstMediaUrl('image')}}" alt="{{$product->description}}">
                                        </td>
                                        <td class="table-desc">{!! $product->description !!}</td>
                                        <td>
                                            <div class="product-colour-area pca-table">
                                                @foreach($product->colors as $color)
                                                    <div>
                                                        <img src="{{\App\Models\Color::find($color->attribute_id)->getFirstMediaUrl('images')}}" alt="{{\App\Models\Color::find($color->attribute_id)->title}}">
                                                        <p>{{\App\Models\Color::find($color->attribute_id)->title}}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <div class="product-colour-area pca-table">
                                                @foreach($product->finishes as $finish)
                                                    <div class="p-relative">
                                                        <img src="{{\App\Models\Finish::find($finish->attribute_id)->getFirstMediaUrl('images')}}" alt="{{\App\Models\Finish::find($finish->attribute_id)->title}}">
                                                        <p>{{\App\Models\Finish::find($finish->attribute_id)->title}}</p>
                                                    </div>
                                                @endforeach
                                            </div>
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
                    <div class="bysize-card">
                        <img src="{{$product->getFirstMediaUrl('image')}}" alt="{{$product->description}}">
                        <h3>{!! $product->description !!}</h3>
                        <div class="bysize-card-btns">
                            <div class="bysize-colors-btn"
                                data-product-desc="{{strip_tags($product->description)}}"
                                data-colors='@json($product->colors->map(function ($color) {
                                    return [
                                        "title" => $color->color->title,
                                        "image" => $color->color->getFirstMediaUrl("images"),
                                    ];
                                }))'>
                                {{_t('Colors')}}
                            </div>
                            <div class="bysize-finish-btn"
                                data-product-desc="{{strip_tags($product->description)}}"
                                data-finish='@json($product->finishes->map(function ($finish) {
                                    return [
                                        "title" => $finish->finish->title,
                                        "image" => $finish->finish->getFirstMediaUrl("images"),
                                    ];
                                }))'>
                                {{_t('Finish')}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
      </div>
   </div>
</div>

<div class="bysize-colors-popup">
    <div class="bysize-colors-popup-top">
        <p id="product-desc"></p>
        <div class="bysize-popup-close">
            <svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M6.75827 17.2426L12.0009 12M17.2435 6.75736L12.0009 12M12.0009 12L6.75827 6.75736M12.0009 12L17.2435 17.2426" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </div>
    </div>
    
    <div class="product-colour-area pca-table" id="color-list">

    </div>
</div>
 
<div class="bysize-finish-popup">
    <div class="bysize-finish-popup-top">
        <p id="product-desc2"></p>
        <div class="bysize-popup-close">
            <svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M6.75827 17.2426L12.0009 12M17.2435 6.75736L12.0009 12M12.0009 12L6.75827 6.75736M12.0009 12L17.2435 17.2426" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </div>
    </div>
    <div class="product-colour-area pca-table" id="finish-list">

    </div>
</div>
@endsection
@push('page-scripts')
<script>
    $(document).ready(function () {
        $(".bysize-colors-btn").click(function () {
            const productDesc = $(this).data("product-desc");
            $("#product-desc").text(productDesc);
            const colors = $(this).data("colors");
            console.log(colors)
            $("#color-list").empty();

            colors.forEach(function (color) {                
                const color_title = color.title;
                const color_img = color.image;
                $("#color-list").append(`
                    <div>
                        <img src="${color_img}" alt="${color_title}">
                        <p>${color_title}</p>
                    </div>
                `);
            });
            
            $(".bysize-colors-popup").fadeIn();
        });
    
        $(".bysize-finish-btn").click(function () {
            const productDesc = $(this).data("product-desc");
            $("#product-desc2").text(productDesc);
            const finishes = $(this).data("finish");
            console.log(finishes)
            $("#finish-list").empty();

            finishes.forEach(function (finish) {                
                const finish_title = finish.title;
                const finish_img = finish.image;
                $("#finish-list").append(`
                    <div>
                        <img src="${finish_img}" alt="${finish_title}">
                        <p>${finish_title}</p>
                    </div>
                `);
            });
            $(".bysize-finish-popup").fadeIn();
        });
    
        $(".bysize-popup-close").click(function () {
            $(".bysize-colors-popup, .bysize-finish-popup").fadeOut();
        });
    });
</script>
@endpush