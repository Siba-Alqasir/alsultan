<body
    class="vertical-layout vertical-menu-modern {{ $configData['verticalMenuNavbarType'] }} {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }} {{ $configData['sidebarClass'] }} {{ $configData['footerType'] }} {{$configData['contentLayout']}}"
    data-open="click"
    data-menu="vertical-menu-modern"
    data-col="{{$configData['showMenu'] ? $configData['contentLayout'] : '1-column' }}"
    data-framework="laravel"
    data-asset-path="{{ asset('/')}}">
@include('admin.panels.navbar')
@if((isset($configData['showMenu']) && $configData['showMenu'] === true))
    @include('admin.panels.sidebar')
@endif
<div class="app-content content {{ $configData['pageClass'] }}">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    @if(($configData['contentLayout']!=='default') && isset($configData['contentLayout']))
        <div class="content-area-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : '' }}">
            <div class="{{ $configData['sidebarPositionClass'] }}">
                <div class="sidebar">
                    @yield('content-sidebar')
                </div>
            </div>
            <div class="{{ $configData['contentsidebarClass'] }}">
                <div class="content-wrapper">
                    <div class="content-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="content-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : '' }}">
            @if($configData['pageHeader'] === true && isset($configData['pageHeader']))
                @include('admin.panels.breadcrumb')
            @endif
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    @endif

</div>
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>
@include('admin.panels.footer')
@include('admin.panels.scripts')
<script type="text/javascript">
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14, height: 14
            });
        }
    })
</script>
</body>
</html>
