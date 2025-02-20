<body
    class="vertical-layout vertical-menu-modern {{$configData['contentLayout']}} {{$configData['blankPageClass']}} {{ $configData['bodyClass']}} {{$configData['verticalMenuNavbarType']}} {{$configData['sidebarClass']}} {{$configData['footerType']}}"
    data-open="click"
    data-menu="vertical-menu-modern"
    data-col="{{$configData['showMenu'] ? $configData['contentLayout'] : '1-column' }}"
    data-framework="laravel"
    data-asset-path="{{ asset('/')}}">
@if((isset($configData['showMenu']) && $configData['showMenu'] === true))
    @include('admin.panels.sidebar')
@endif
@include('admin.panels.navbar')
<div class="app-content content {{ $configData['pageClass'] }}">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : '' }}">
        @if($configData['pageHeader'] == true) @include('admin.panels.breadcrumb') @endif
        <div class="{{ $configData['contentsidebarClass'] }}">
            <div class="content-body">
                @yield('content')
            </div>
        </div>
        <div class="{{ $configData['sidebarPositionClass'] }}">
            <div class="sidebar">
                @yield('content-sidebar')
            </div>
        </div>
    </div>
</div>
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>
@include('admin.panels.footer')
@include('admin.panels.scripts')
<script type="text/javascript">
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            })
        }
    })
</script>
</body>
</html>
