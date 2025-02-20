@extends('web.layouts')
@section('content')
    @include('web.components.breadcrumb')

    <div class="tp-contact-area pt-120 pb-120">
        <div class="container-fluid">
           <div class="row justify-content-center">
              <div class="col-md-10">
                 <div class="row justify-content-between">
                    <div class="col-xl-5 col-lg-6">
                       <img src="{{$data['is_mobile'] ? $data['tailormade-page-main']->getFirstMediaUrl('mobile_images') :  $data['tailormade-page-main']->getFirstMediaUrl('images')}}" alt="{{$data['tailormade-page-main']['title']}}" class="w-100">
                    </div>
                    <div class="col-xl-6 offset-xl-1 col-lg-6">
                       <div class="tp-contact-form bg-white p-0">
                          <div class="tp-contact-form-wrap">
                              <div class="tailor_des">
                                 <h3 class="mb-25">{{$data['tailormade-page-main']['title']}}</h3>
                                  <p class="mb-25">
                                      {!! $data['tailormade-page-main']['description'] !!}
                                  </p>
                              </div>
                              
                              <form action="{{LaravelLocalization::localizeUrl('tailor-made-inquiry')}}" method="POST">
                                @csrf
                                <input class="d-none" type="text" name="honeypot">
                                <input class="d-none" type="text" name="type" value="tailormade">
                                <div class="tp-contact-form-input mb-45">
                                    <span><i class="fa-light fa-user"></i></span>
                                    <input value="{{old('name')}}" type="text" class="form-control" placeholder="{{_t('Name')}}" name="name" required oninvalid="this.setCustomValidity('{{_t('Please insert your name')}}')"  oninput="this.setCustomValidity('')">
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    </div>
                                    <div class="tp-contact-form-input mb-45">
                                        <span><i class="fa-light fa-phone-alt"></i></span>
                                        <input value="{{old('phone')}}" type="text" class="form-control" name="phone" pattern="[0-9]{6,13}" placeholder="e.g. 971 XXX XXX XXX" required oninvalid="this.setCustomValidity('{{_t('Please insert a valid mobile')}}')" oninput="this.setCustomValidity('')">
                                        @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tp-contact-form-input mb-45">
                                        <span><i class="fa-light fa-envelope"></i></span>
                                        <input value="{{old('email')}}" type="email" class="form-control" placeholder="{{_t('Email')}}" name="email" required oninvalid="this.setCustomValidity('{{_t('Please insert a valid email')}}')" oninput="this.setCustomValidity('')">
                                        @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tp-contact-form-input mb-45">
                                        <span><i class="fa-light fa-suitcase"></i></span>
                                        <input value="{{old('company')}}" type="text" class="form-control" placeholder="{{_t('Company')}}" name="company" required oninvalid="this.setCustomValidity('{{_t('Please insert company name')}}')" oninput="this.setCustomValidity('')">
                                        @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tp-contact-form-input mb-45">
                                        <span><i class="fa-light fa-list"></i></span>
                                        <div class="tp-checkout-input contact-select">
                                            <select name="category" required>
                                                 @foreach($data['categories'] as $category)
                                                     <option value="{{$category->title}}">{{$category->title}}</option>
                                                 @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="tp-contact-form-input tp-contact-form-textarea mb-45">
                                        <span><i class="fa-light fa-pen-to-square"></i></span>
                                        <textarea name="message" cols="30" rows="10" placeholder="{{_t('Message')}}"  required oninvalid="this.setCustomValidity('{{_t('Please Insert your message')}}')" oninput="this.setCustomValidity('')">{{old('message')}}</textarea>
                                        @error('message')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 mb-4">
                                        <div class="form-group orm-group">
                                            <div class="g-recaptcha" data-sitekey="{{ config('recaptcha_config.site_key') }}"></div>
                                            @if ($errors->has('g-recaptcha-response'))
                                                <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tp-contact-form-button">
                                        <button class="tp-btn-theme" type="submit">{{_t('Submit Your Inquiry')}}</button>
                                    </div>
                                    <p class="ajax-response error"></p>
                                </form>
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
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endpush