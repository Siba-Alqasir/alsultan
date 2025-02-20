@php
    $configData = Helper::applClasses();
@endphp
<div class="main-menu menu-fixed {{(($configData['theme'] === 'dark') || ($configData['theme'] === 'semi-dark')) ? 'menu-dark' : 'menu-light'}} menu-accordion menu-shadow"
    data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row mb-1">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{url('/admin')}}">
                    <img class="round" src="{{asset('admin-assets/images/logo/logo-white.png')}}" height="50" width="50">
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @if(isset($menuData[0]))
                @foreach($menuData[0]->menu as $menu)
                    @if(isset($menu->navheader))
                        @php
                            $permissions = explode(',', $menu->permission);
                        @endphp
                        @if(\Illuminate\Support\Facades\Auth::user()->canAny($permissions) || empty($menu->permission))
                            <li class="navigation-header">
                                <span>{{ __('locale.'.$menu->navheader) }}</span>
                                <i data-feather="more-horizontal"></i>
                            </li>
                        @endif
                    @else
                        @php
                            $custom_classes = "";
                            if(isset($menu->classlist)) {
                            $custom_classes = $menu->classlist;
                            }
                            if(\Illuminate\Support\Facades\Request::getQueryString() != null)
                            $path = \Illuminate\Support\Facades\Request::path().'?'.\Illuminate\Support\Facades\Request::getQueryString();
                            else
                            $path = \Illuminate\Support\Facades\Request::path();

                            $permissions = explode(',', $menu->permission);
                        @endphp

                        <li class="nav-item {{ $custom_classes }} {{( $path === $menu->slug) || Route::currentRouteName() === $menu->slug  ? 'active' : ''}}">
                            @if(\Illuminate\Support\Facades\Auth::user()->canAny($permissions) || empty($menu->permission))
                            <a href="{{isset($menu->url)? url($menu->url):'javascript:void(0)'}}" class="d-flex align-items-center" target="{{isset($menu->newTab) ? '_blank':'_self'}}">
                                <i data-feather="{{ $menu->icon }}"></i>
                                <span class="menu-title text-truncate">{{ __('locale.'.$menu->name) }}</span>
                                @if (isset($menu->badge))
                                        <?php $badgeClasses = "badge rounded-pill badge-light-primary ms-auto me-1" ?>
                                    <span class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }}">{{$menu->badge}}</span>
                                @endif
                            </a>
                            @endif
                            @if(isset($menu->submenu))
                                @include('admin.panels.submenu', ['menu' => $menu->submenu , 'path' => $path])
                            @endif
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
</div>
