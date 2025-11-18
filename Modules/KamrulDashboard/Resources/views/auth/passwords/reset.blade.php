@extends('kamruldashboard::layouts.app_login')

@section('stylesheet')

@endsection
@section('javascript')

@endsection

@section('title', __( 'kamruldashboard::lang.' . $title))
@section('content')

    <div class="auth-form">
        <h4 class="text-center mb-4">Sign up your account</h4>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="form-group">
                <label><strong>Email</strong></label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label><strong>Password</strong></label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label><strong>Confirm Password</strong></label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-block">{{ __('Reset Password') }}</button>
            </div>
        </form>
        <div class="new-account mt-3">
            <p>@lang('kamruldashboard::lang.already_have_an_account') <a class="text-primary" href="{{ route('login') }}">@lang('kamruldashboard::lang.sign_in')</a></p>
        </div>
    </div>
@endsection
