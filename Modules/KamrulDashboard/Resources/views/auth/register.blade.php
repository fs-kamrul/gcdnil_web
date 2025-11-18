@extends('kamruldashboard::layouts.app_login')

@section('stylesheet')

@endsection
@section('javascript')

@endsection

@section('title', __( 'kamruldashboard::lang.' . $title))
@section('content')
    <div class="auth-form">
        <h4 class="text-center mb-4">@lang('kamruldashboard::lang.sign_up_your_account')</h4>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label><strong>@lang('kamruldashboard::lang.name')</strong></label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label><strong>@lang('kamruldashboard::lang.username')</strong></label>
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                @error('name')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label><strong>@lang('kamruldashboard::lang.email')</strong></label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label><strong>@lang('kamruldashboard::lang.password')</strong></label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label><strong>@lang('kamruldashboard::lang.confirmation_password')</strong></label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
            @if(getSetting('registration_user_role', 'site_setting'))
                @isset($record){!! select_design_html($record->role_id,$role,'role_id',0, __('kamruldashboard::lang.user_type')) !!} @else{!! select_design_html(1,$role,'role_id',0, __('kamruldashboard::lang.user_type')) !!} @endisset
            @endif
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-block">@lang('kamruldashboard::lang.sign_up')</button>
            </div>
        </form>
        <div class="new-account mt-3">
            <p>@lang('kamruldashboard::lang.already_have_an_account') <a class="text-primary" href="{{ route('login') }}">@lang('kamruldashboard::lang.sign_in')</a></p>
        </div>
    </div>
@endsection
