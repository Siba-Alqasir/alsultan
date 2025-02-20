<div class="whatsapp-chat">
    <a href="https://wa.me/{{str_replace(' ', '', $data['footer']['phone'])}}" target="blanck">
       <img src="{{URL::asset('web-assets/img/whatsapp.svg')}}">
    </a>
</div>

{{-- footer --}}
<footer>
    <!-- footer area start -->
    <div class="tp-footer-area black-bg-2 pt-85 pb-85">
       <div class="container">
          <div class="row">
             <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 wow tpfadeUp" data-wow-duration=".9s"
                data-wow-delay=".3s">
                <div class="tp-footer-widget footer-col-1">
                   <div class="tp-footer-logo w-50 pb-30">
                      <a href="{{LaravelLocalization::localizeUrl('/')}}"><img src="{{URL::asset('web-assets/img/logo/logo-white.png')}}" alt="{{_t('Al Sultan Cement')}}"></a>
                   </div>
                   <div class="tp-footer-text">
                      <p>{{$data['footer']['slogan']}}</p>
                   </div>
                </div>
             </div>
             <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 wow tpfadeUp" data-wow-duration=".9s"
                data-wow-delay=".5s">
                <div class="tp-footer-widget footer-col-2">
                   <h4 class="tp-footer-title">{{_t('Company')}}</h4>
                   <div class="tp-footer-list">
                      <ul>
                         <li><a href="{{LaravelLocalization::localizeUrl('/about-us')}}">{{_t('About Us')}}</a></li>
                         <li><a href="{{LaravelLocalization::localizeUrl('/services')}}">{{_t('Services')}}</a></li>
                         <li><a href="{{LaravelLocalization::localizeUrl('/projects')}}">{{_t('Projects')}}</a></li>
                         <li><a href="{{LaravelLocalization::localizeUrl('/treatments')}}">{{_t('Surface Treatment')}}</a></li>
                         <li><a href="{{LaravelLocalization::localizeUrl('/clients')}}">{{_t('Clients')}}</a></li>
                      </ul>
                   </div>
                </div>
             </div>
             <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 wow tpfadeUp" data-wow-duration=".9s"
                data-wow-delay=".7s">
                <div class="tp-footer-widget footer-col-3">
                   <h4 class="tp-footer-title">{{_t('Categories')}}</h4>
                   <div class="tp-footer-list">
                      <ul>
                        @foreach($data['categories'] as $category)
                            <li><a href="{{LaravelLocalization::localizeUrl('/products/by-category/'.$category->slug)}}">{{$category->title}}</a></li>
                        @endforeach
                      </ul>
                   </div>
                </div>
             </div>
             <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 wow tpfadeUp" data-wow-duration=".9s"
                data-wow-delay=".9s">
                <div class="tp-footer-widget footer-col-4">
                   <div class="tp-footer-contact">
                      <span>
                         <a class="text-anim-2" target="_blank" href="{{$data['footer']['map']}}">{{$data['footer']['address']}}</a>
                      </span>
                      <span class="mb-10 mt-10">
                         <a class="text-anim-2 text-anim-2" href="mailto:{{$data['footer']['email']}}">
                            {{$data['footer']['email']}}
                         </a>
                      </span>
                      <span>
                         <a class="text-anim-2" href="tel:{{$data['footer']['phone']}}">{{$data['footer']['phone']}}</a>
                      </span>
                   </div>
                   <div class="tp-footer-social mt-50">
                      @if($data['footer']['facebook'])<a target="_blank" href="{{$data['footer']['facebook']}}"><i class="fa-brands fa-facebook-f"></i></a>@endif
                      @if($data['footer']['instagram'])<a target="_blank" href="{{$data['footer']['instagram']}}"><i class="fa-brands fa-instagram"></i></a>@endif
                      @if($data['footer']['linkedin'])<a target="_blank" href="{{$data['footer']['linkedin']}}"><i class="fa-brands fa-linkedin"></i></a>@endif
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
    <!-- footer area end -->

    <!-- copy-right area start -->
    <div class="tp-copyright-area black-bg-2">
       <div class="container">
          <div class="tp-copyright-border tp-copyright-ptb">
             <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 order-2 order-lg-1 wow tpfadeUp" data-wow-duration=".9s"
                   data-wow-delay=".3s">
                   <div class="tp-copyright-left text-center text-md-start">
                      <p>&copy; {{date('Y')}} {{_t('Al Sultan Cement')}}. {{_t('All Rights Reserved')}} - {{_t('Powered By')}} <a href="https://plana.ae/" target="blanck">{{_t('PLAN A AGENCY')}}</a></p>
                   </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 order-1 order-lg-2 wow tpfadeUp" data-wow-duration=".9s"
                   data-wow-delay=".5s">
                   <div class="tp-copyright-right text-center text-md-end">
                      <a href="{{LaravelLocalization::localizeUrl('/blogs')}}">{{_t('Blogs')}}</a>
                      <a href="{{LaravelLocalization::localizeUrl('/contact-us')}}">{{_t('Contact')}} </a>
                      <a href="{{LaravelLocalization::localizeUrl('/privacy-policy')}}">{{_t('Privacy Policy')}}</a>
                      <a href="{{LaravelLocalization::localizeUrl('/terms-and-conditions')}}">{{_t('Terms and Conditions')}}</a>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
    <!-- copy-right area end -->

 </footer>
