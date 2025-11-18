@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ url('vendor/kamruldashboard/vendor/toastr/css/toastr.min.css') }}">
@endsection
@section('javascript')
    <script type="text/javascript">
        var url_theme_active = "{{ route('theme.active') }}";
        var url_theme_remove = "{{ route('theme.remove') }}";
        var csrf_token = "{{ csrf_token() }}";
    </script>
    <script src="{{ url('vendor/kamruldashboard/vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/js/toastr_script.js') }}"></script>

    <script src="{{ url('vendor/kamruldashboard/js/themes/theme.js') }}"></script>
@endsection

@section('title', __( 'theme::lang.' . $title))
@section('content')
<div class="row">
    @foreach(ThemeManager::getThemes() as $key => $theme)
    <div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6 ">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">{{ $theme['name'] }}</h5>
            </div>
            <div class="card-body">
{{--                <div class="img-thumbnail-wrap"--}}
{{--                     style="background-image: url('{{ config('theme.themeDir') }}/{{ Theme::getThemeName() == $key && Theme::getPublicThemeName() ? Theme::getPublicThemeName() : $key }}/screenshot.png')">--}}

                 <img width="100%" src="{{ url(config('theme.themeDir') . '/' . Arr::get($theme, 'name') . '/screenshot.png') }}">
                <div style="word-break: break-all">
                    <h4>{{ $theme['name'] }}</h4>
                    <p>{{ trans('theme::theme.author') }}: {{ Arr::get($theme, 'author') }}</p>
                    <p>{{ trans('theme::theme.version') }}: {{ Arr::get($theme, 'version') }}</p>
                    <p>{{ trans('theme::theme.description') }}: {{ Arr::get($theme, 'description') }}</p>
                </div>
            </div>
            <div class="card-footer d-sm-flex justify-content-between">
                @if (setting('theme') && Theme::getThemeName() == $key)
                    <a href="#" class="btn btn-info" disabled="disabled"><i class="fa fa-check"></i> {{ trans('theme::theme.activated') }}</a>
{{--                    <a href="#" class="btn btn-primary btn-trigger-clear-cache" data-theme="{{ $key }}" data-url="{{ route('theme.clear_cache') }}">{{ trans('theme::lang.clear_cache') }}</a>--}}
                @else
                    @if (auth()->user()->can('theme_access'))
                        <a href="#" class="btn btn-primary btn-trigger-active-theme" data-theme="{{ $key }}">{{ trans('theme::theme.active') }}</a>
                    @endif
                    @if (auth()->user()->can('theme_access'))
                        <a href="#" class="btn btn-danger btn-trigger-remove-theme" data-theme="{{ $key }}">{{ trans('theme::theme.remove') }}</a>
                    @endif
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
    {!! Form::modalAction('remove-theme-modal', trans('theme::theme.remove_theme'), 'danger', trans('theme::theme.remove_theme_confirm_message'), 'confirm-remove-theme-button', trans('theme::theme.remove_theme_confirm_yes')) !!}
@endsection
