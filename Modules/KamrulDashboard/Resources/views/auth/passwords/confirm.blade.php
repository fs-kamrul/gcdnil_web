@extends('kamruldashboard::layouts.app_login')

@section('stylesheet')

@endsection
@section('javascript')

@endsection

@section('title', __( 'kamruldashboard::lang.' . $title))
@section('content')

    <div class="auth-form">
        <h4 class="text-center mb-4">@lang('kamruldashboard::lang.confirm_password')</h4>
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            @lang('kamruldashboard::lang.please_confirm_your_password_before_continuing')
            <div class="form-group">
                <label><strong>@lang('kamruldashboard::lang.password')</strong></label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block">@lang('kamruldashboard::lang.confirm_password')</button>

                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>

            <div class="new-account mt-3">
                <p><a class="text-primary" href="{{ route('password.request') }}">@lang('kamruldashboard::lang.forgot_password')</a></p>
            </div>
        </form>
    </div>
@endsection
