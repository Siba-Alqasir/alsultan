@if($configData["mainLayoutType"] === 'horizontal' && isset($configData["mainLayoutType"]))
    <nav
        class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center {{ $configData['navbarColor'] }}"
        data-nav="brand-center">
        <div class="navbar-header d-xl-block d-none">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="navbar-brand" href="{{url('/')}}">
                        <h2 class="brand-text mb-0">@lang('locale.title')</h2>
                    </a>
                </li>
            </ul>
        </div>
        @else
        <nav
            class="header-navbar navbar navbar-expand-lg align-items-center {{ $configData['navbarClass'] }} navbar-light navbar-shadow {{ $configData['navbarColor'] }} {{ ($configData['layoutWidth'] === 'boxed' && $configData['verticalMenuNavbarType']  === 'navbar-floating') ? 'container-xxl' : '' }}">
            @endif
            <div class="navbar-container d-flex content">
                <div class="bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav d-xl-none">
                        <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i
                                    class="ficon" data-feather="menu"></i></a></li>
                    </ul>
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name fw-bolder">Welcome, {{Auth::user()->name}}</span>
                    </div>
                </div>
                <ul class="nav navbar-nav align-items-center ms-auto">
                    <li class="nav-item dropdown dropdown-use"r>
                        <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user"
                           href="javascript:void(0);" data-bs-toggle="dropdown" aria-haspopup="true">
                            <span class="">
                                <i class="ficon" data-feather="menu"></i>
                              <span class="avatar-status-online"></span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                <i class="me-50" data-feather="user"></i> Profile
                            </a>
                            <a class="" href="{{ route('users.edit',Auth::id()) }}">
                                <form action="{{Route('logout')}}" method="POST">
                                    @csrf
                                    <button class="dropdown-item" type="submit">
                                        <i class="me-50" data-feather="power"></i> Logout
                                    </button>
                                </form>
                            </a>

                        </div>
                    </li>

                </ul>
            </div>
        </nav>
