@php
    $configData = Helper::applClasses();
@endphp
@extends('admin.layouts.fullLayoutMaster')

@section('title', 'Not Authorized')

@section('page-style')
    <link rel="stylesheet" href="{{asset(mix('admin-assets/css/base/pages/page-misc.css'))}}">
@endsection

@section('content')
    <div class="misc-wrapper">
        <div class="misc-inner p-2 p-sm-3">
            <div class="w-100 text-center">
                <h2 class="mb-1">Sorry! You are not authorized! 🔐</h2>
                <a class="btn btn-primary mb-1 btn-sm-block" href="{{url('/admin')}}">Back to home</a>
                @if($configData['theme'] === 'dark')
                    <img class="img-fluid" src="{{asset('admin-assets/images/pages/not-authorized-dark.svg')}}" alt="Not authorized page" />
                @else
                    <img class="img-fluid" src="{{asset('admin-assets/images/pages/not-authorized.svg')}}" alt="Not authorized page" />
                @endif
            </div>
        </div>
    </div>
@endsection
