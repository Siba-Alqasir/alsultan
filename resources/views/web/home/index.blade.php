@extends('web.layouts')
@section('content')
@include('web.home.home-sliders')
<div id="page_wrapper" class="wrapper">
    @include('web.home.home-categories')
    @include('web.home.home-about')
    @include('web.home.home-companies')
    @include('web.home.home-news')
</div>
@endsection
