@extends('admin.layouts.fullLayoutMaster')
@section('title', 'Login')
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('admin-assets/css/base/pages/page-auth.css')) }}">
@endsection
@section('content')
    <div class="auth-wrapper auth-cover">
        <div class="auth-inner row m-0">
            <div class="d-none d-lg-flex col-lg-8 align-items-center p-5" style="background-color: #BDBDBD;">
                <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                    <img src="{{url('admin-assets/images/logo/logo-black.png')}}" alt="E G R Holding L.L.C" class="logo-img" style="width: 50%;">
                </div>
            </div>
            <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                    <div class="login-rs-title">
                        <h2 class="card-title fw-bolder mb-1 btitle1">Login to admin panel</h2>
                    </div>
                    <p class="card-text mb-2">Please sign-in to your account</p>
                    <form class="auth-login-form mt-2" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-1">
                            <label class="form-label" for="login-email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror p-1" id="login-email" type="text" name="email"
                                   placeholder="john@example.com" aria-describedby="login-email" tabindex="1"
                                   value="{{ old('credential') }}"
                                   required autocomplete="email" autofocus />
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <label class="form-label " for="login-password">Password</label>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input class="form-control form-control-merge  p-1 mb-0" id="login-password" type="password"
                                       name="password" placeholder="············" aria-describedby="login-password"
                                       tabindex="2"
                                       required autocomplete="current-password" />
                                <span class="input-group-text cursor-pointer "><i data-feather="eye"></i></span>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="form-check">
                                <input class="form-check-input" name="remember" id="remember" type="checkbox"
                                       tabindex="3" {{ old('remember') ? 'checked' : '' }} />
                                <label class="form-check-label " for="remember-me">Remember Me</label>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100 p-1 mt-2" tabindex="4">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
