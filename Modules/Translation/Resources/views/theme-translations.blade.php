@extends('kamruldashboard::layouts.app_master')
@section('stylesheet')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ url('vendor/kamruldashboard/vendor/toastr/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ url('vendor/kamruldashboard/vendor/bootstrap3-editable/css/bootstrap-editable.css') }}">
    <link rel="stylesheet" href="{{ url('vendor/kamruldashboard/translation/css/theme-translations.css') }}">

@endsection
@section('javascript')
    <script src="{{ url('vendor/kamruldashboard/vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/js/toastr_script.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/vendor/bootstrap3-editable/js/bootstrap-editable.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/translation/js/theme-translations.js') }}"></script>

@endsection
@section('title', __( 'translation::lang.' . $title))
@section('content')
    <div class="widget meta-boxes">
        <div class="widget-title">
            <h4>&nbsp; {{ trans('translation::lang.theme-translations') }}</h4>
        </div>
        <div class="widget-body box-translation">
            @if (count(\Modules\KamrulDashboard\Packages\Supports\Language::getAvailableLocales()) > 0)
                {!! Form::open(['role' => 'form', 'route' => 'translations.theme-translations', 'method' => 'POST']) !!}
                    <input type="hidden" name="locale" value="{{ $group['locale'] }}">
                    <div class="row">
                        <div class="col-md-6">
                            <p>{{ trans('translation::lang.translate_from') }} <strong class="text-info">{{ $defaultLanguage ? $defaultLanguage['name'] : 'en' }}</strong> {{ trans('translation::lang.to') }} <strong class="text-info">{{ $group['name'] }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                @include('translation::partials.list-theme-languages-to-translate', compact('groups', 'group'))
                            </div>
                        </div>
                    </div>
                    <p class="note note-warning">{{ trans('translation::lang.theme_translations_instruction') }}</p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>{{ $defaultLanguage ? $defaultLanguage['name'] : 'en' }}</th>
                                <th>{{ $group['name'] }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($translations as $key => $translation)
                                <tr>
                                    <td class="text-start" style="width: 50%">
                                        {!! htmlentities($key, ENT_QUOTES, 'UTF-8', false) !!}
                                    </td>
                                    <td class="text-start" style="width: 50%">
                                        <a href="#" class="editable"
                                           data-name="{{ $key }}"
                                           data-type="textarea" data-pk="{{ $group['locale'] }}" data-url="{{ route('translations.theme-translations') }}"
                                           data-title="{{ trans('translation::lang.edit_title') }}">{!! htmlentities($translation, ENT_QUOTES, 'UTF-8', false) !!}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-info button-save-theme-translations">{{ trans('kamruldashboard::lang.save') }}</button>
                    </div>
                {!! Form::close() !!}
            @else
                <p class="text-warning">{{ trans('translation::lang.no_other_languages') }}</p>
            @endif
        </div>
        <div class="clearfix"></div>
    </div>
@stop
