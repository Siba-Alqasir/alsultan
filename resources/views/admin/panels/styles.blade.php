@if($configData['direction'] === 'rtl' && isset($configData['direction']))
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/vendors/css/vendors-rtl.min.css')) }}"/>
@else
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/vendors/css/vendors.min.css')) }}"/>
@endif
@yield('vendor-style')
<link rel="stylesheet" href="{{ asset(mix('admin-assets/css/core.css')) }}"/>
@php $configData = Helper::applClasses(); @endphp
@if($configData['mainLayoutType'] === 'horizontal')
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/css/base/core/menu/menu-types/horizontal-menu.css')) }}"/>
@else
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/css/base/core/menu/menu-types/vertical-menu.css')) }}"/>
@endif
<link rel="stylesheet" href="{{ asset(mix('admin-assets/css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
<link rel="stylesheet" href="{{ asset(mix('admin-assets/vendors/css/extensions/toastr.min.css'))}}">
<link rel="stylesheet" href="{{ asset(mix('admin-assets/css/base/plugins/extensions/ext-component-toastr.css'))}}">
@yield('page-style')
<link rel="stylesheet" href="{{ asset(mix('admin-assets/css/overrides.css')) }}"/>
@if($configData['direction'] === 'rtl' && isset($configData['direction']))
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/css-rtl/custom-rtl.css')) }}"/>
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/css-rtl/style-rtl.css')) }}"/>
@else
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/css/style.css')) }}"/>
@endif
<link rel="stylesheet" href="{{ asset('admin-assets/summernote/summernote-lite.min.css')}}">
<link href="{{asset('admin-assets/css/base/plugins/forms/select2.min.css')}}" rel="stylesheet" />