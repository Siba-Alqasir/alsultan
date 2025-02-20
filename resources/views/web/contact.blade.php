@extends('web.layouts')
@section('content')
@include('web.components.breadcrumb')
<!-- contact area start -->
<div class="tp-contact-area pt-65 pb-120">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xl-5 col-lg-6 pt-40">
                        <div class="tp-contact-wrapper mb-60">
                            <div class="tp-contact-inner">
                                <h4 class="tp-contact-inner-title">{{$data['contact_page_get_contact']['title']}}</h4>
                                <p>{!! $data['contact_page_get_contact']['description'] !!}</p>
                            </div>
                            <div class="tp-contact-box">
                                <div class="row">
                                    <div class="col-xxl-12 col-xl-5 col-lg-6 col-md-4">
                                        <div class="tp-contact-item mb-30">
                                            <span>{{_t('Address')}}</span>
                                            <a href="{{$data['footer']['map']}}" target="_blank">{{$data['footer']['address']}}</a>
                                        </div><div class="tp-contact-item mb-30">
                                            <span>{{_t('Phone')}}</span>
                                            <a href="tel:{{$data['footer']['phone']}}">{{$data['footer']['phone']}}</a>
                                        </div>

                                        <div class="tp-contact-item mb-30">
                                            <span>{{_t('Email')}}</span>
                                            <a href="mailto:{{$data['footer']['email']}}">{{$data['footer']['email']}}</a>
                                        </div>
                                        <div class="tp-contact-item tp-contact-social mt-50">
                                            <span>{{_t('Follow')}}</span>
                                            <div class="tp-contact-social-box">
                                                @if($data['footer']['facebook'])<a target="_blank" href="{{$data['footer']['facebook']}}"><i class="fa-brands fa-facebook-f"></i></a>@endif
                                                @if($data['footer']['instagram'])<a target="_blank" href="{{$data['footer']['instagram']}}"><i class="fa-brands fa-instagram"></i></a>@endif
                                                @if($data['footer']['linkedin'])<a target="_blank" href="{{$data['footer']['linkedin']}}"><i class="fa-brands fa-linkedin"></i></a>@endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 offset-xl-1 col-lg-6">
                        <div class="tp-contact-form">
                            <div class="tp-contact-form-content">
                                <h4 class="tp-contact-form-title">{{_t('Send Us A Message')}}</h4>
                            </div>
                            <div class="tp-contact-form-wrap">
                                <form action="{{LaravelLocalization::localizeUrl('contact-us')}}" method="POST">
                                    @csrf
                                    <input class="d-none" type="text" name="honeypot">
                                    <input class="d-none" type="text" name="type" value="contact">
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
                                        <button class="tp-btn-theme" type="submit"><i class="fa-light fa-paper-plane"></i>
                                            {{_t('Get In Touch')}}</button>
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
<div class="tp-map-area fix">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-xl-12">
                <div class="tp-map-box">
                    <iframe src="{{$data['footer']['iframe']}}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endpush
