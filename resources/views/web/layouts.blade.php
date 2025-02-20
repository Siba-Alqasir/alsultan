<!DOCTYPE html>
<html class="no-js" lang="{{app()->getLocale()}}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{$data['page']->meta_title}}</title>
        <meta name="description" content="{{$data['page']->meta_description}}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="{{URL::asset('web-assets/img/logo/favicon.png')}}">
        <link rel="stylesheet" href="{{URL::asset('web-assets/css/bootstrap.css')}}">
        <link rel="stylesheet" href="{{URL::asset('web-assets/css/animate.css')}}">
        <link rel="stylesheet" href="{{URL::asset('web-assets/css/swiper-bundle.css')}}">
        <link rel="stylesheet" href="{{URL::asset('web-assets/css/slick.css')}}">
        <link rel="stylesheet" href="{{URL::asset('web-assets/css/magnific-popup.css')}}">
        <link rel="stylesheet" href="{{URL::asset('web-assets/css/flaticon_broadx.css')}}">
        <link rel="stylesheet" href="{{URL::asset('web-assets/css/font-awesome-pro.css')}}">
        <link rel="stylesheet" href="{{URL::asset('web-assets/css/spacing.css')}}">
        <link rel="stylesheet" href="{{URL::asset('web-assets/css/custom-animation.css')}}">
        @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{URL::asset('web-assets/css/main_ar.css')}}">
        @else
        <link rel="stylesheet" href="{{URL::asset('web-assets/css/main.css')}}">
        @endif
        <link rel="canonical" href="{{url()->current()}}"/>
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <link rel="alternate" href="{{LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" hreflang="{{$localeCode}}" />
        @endforeach
        <link rel="apple-touch-icon" href="{{URL::asset('web-assets/img/logo/favicon.png')}}">
        <link rel="shortcut icon" href="{{URL::asset('web-assets/img/logo/favicon.png')}}" />
        <link rel="apple-touch-icon-precomposed" href="{{URL::asset('web-assets/img/logo/favicon.png')}}" />
        @stack('page-styles')
     </head>
    <body>
        @include('web.components.loader')
        @include('web.components.header')
        <main>
            @yield('content')
        </main>
        @include('web.components.footer')
        @include('web.components.scripts')
        @stack('page-scripts')
    </body>
</html>
