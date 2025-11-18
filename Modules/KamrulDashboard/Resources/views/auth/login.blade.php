@extends('kamruldashboard::layouts.app_login')

@section('stylesheet')

@endsection
@section('javascript')

@endsection

@section('title', __( 'kamruldashboard::lang.' . $title))
@section('content')
    <div class="auth-form">
        <h4 class="text-center mb-4">@lang('kamruldashboard::lang.sign_in_your_account')</h4>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label><strong>@lang('kamruldashboard::lang.email')</strong></label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label><strong>@lang('kamruldashboard::lang.password')</strong></label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-row d-flex justify-content-between mt-4 mb-2">
                <div class="form-group">
                    <div class="form-check ml-2">
                        <input class="form-check-input" type="checkbox" name="remember" id="basic_checkbox_1" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="basic_checkbox_1">@lang('kamruldashboard::lang.remember_me')</label>
                    </div>
                </div>
                <div class="form-group">
                    <a href="{{ route('password.request') }}">@lang('kamruldashboard::lang.forgot_password')?</a>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block">@lang('kamruldashboard::lang.sign_in')</button>
            </div>
        </form>
        @if(getSetting('registration_enable', 'site_setting'))
        <div class="new-account mt-3">
            <p>@lang('kamruldashboard::lang.dont_have_an_account') <a class="text-primary" href="{{ route('register') }}">@lang('kamruldashboard::lang.sign_up')</a></p>
        </div>
        @endif
    </div>
@endsection
