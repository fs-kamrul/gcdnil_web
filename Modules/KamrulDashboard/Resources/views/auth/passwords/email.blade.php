@extends('kamruldashboard::layouts.app_login')

@section('stylesheet')

@endsection
@section('javascript')

@endsection

@section('title', __( 'kamruldashboard::lang.' . $title))
@section('content')
    <div class="auth-form">
        <h4 class="text-center mb-4">@lang('kamruldashboard::lang.reset_password')</h4>
        <form method="POST" action="{{ route('password.email') }}">
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
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block">{{ __('Send Password Reset Link') }}</button>
            </div>
        </form>
        @if(getSetting('registration_enable', 'site_setting'))
        <div class="new-account mt-3">
            <p>@lang('kamruldashboard::lang.dont_have_an_account') <a class="text-primary" href="{{ route('register') }}">@lang('kamruldashboard::lang.sign_up')</a></p>
        </div>
        @endif
    </div>
@endsection
