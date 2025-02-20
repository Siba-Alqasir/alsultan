@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
    <!DOCTYPE html>
@php
    $configData = Helper::applClasses();
@endphp
<html class="loading {{ ($configData['theme'] === 'light') ? '' : $configData['layoutTheme']}}"
      lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif"
      data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}"
      @if($configData['theme'] === 'dark') data-layout="dark-layout" @endif>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="First Commerce">
    <meta name="author" content="PlanA">
    <title>@yield('title') - @lang('locale.title')</title>
    <link rel="icon" href="{{url('admin-assets/images/logo/favicon.svg')}}" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
          rel="stylesheet">
    @include('admin.panels.styles')
</head>
@isset($configData["mainLayoutType"])
    @extends((( $configData["mainLayoutType"] === 'horizontal') ? 'admin.layouts.horizontalLayoutMaster' :
    'admin.layouts.verticalLayoutMaster' ))
@endisset
