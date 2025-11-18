@extends('kamruldashboard::layouts.app_master')
@section('stylesheet')
    <link rel="stylesheet" href="{{ url('vendor/kamruldashboard/vendor/toastr/css/toastr.min.css') }}">

@endsection
@section('javascript')
    <script>
        var csrf_token = "{{ csrf_token() }}";
        var languages_set = "{{ route('languages.set.default') }}";
        var languages_get = "{{ route('languages.get') }}";
        var languages_store = "{{ route('languages.store') }}";
        var languages_edit = "{{ route('languages.edit') }}";
    </script>
    <script src="{{ url('vendor/kamruldashboard/vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/js/toastr_script.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/language/js/language.js') }}"></script>

@endsection
@section('title', __( 'theme::lang.' . $title))
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
{{--                    <h4 class="card-title">Default Tab</h4>--}}
                </div>
                <div class="card-body">
                    <div class="default-tab">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#tab_detail" class="nav-link active" data-toggle="tab">{{ trans('kamruldashboard::lang.detail') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab_settings" class="nav-link" data-toggle="tab">{{ trans('language::lang.settings') }}</a>
                            </li>
                            {!! apply_filters(BASE_FILTER_REGISTER_CONTENT_TABS, null, new \Modules\Language\Http\Models\Language) !!}
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab_detail">
                                <div class="row">
                                    <div class="col-md-5">
                                        @php do_action(BASE_ACTION_META_BOXES, 'top', new \Modules\Language\Http\Models\Language) @endphp
                                        <div class="main-form">
                                            <div class="form-wrap">
                                                <div class="form-group mb-3">
                                                    <input type="hidden" id="language_flag_path" value="{{ BASE_LANGUAGE_FLAG_PATH }}">
                                                    <label for="language_id" class="control-label">{{ trans('language::lang.choose_language') }}</label>
                                                    <select id="language_id" class="form-control select-search-full">
                                                        <option>{{ trans('language::lang.select_language') }}</option>
                                                        @foreach ($languages as $key => $language)
                                                            <option value="{{ $key }}" data-language="{{ json_encode($language) }}"> {{ $language[2] }} - {{ $language[1] }}</option>
                                                        @endforeach
                                                    </select>
                                                    {!! Form::helper(trans('language::lang.choose_language_helper')) !!}
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="lang_name" class="control-label required">{{ trans('language::lang.language_name') }}</label>
                                                    <input id="lang_name" type="text" class="form-control">
                                                    {!! Form::helper(trans('language::lang.language_name_helper')) !!}
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="lang_locale" class="control-label required">{{ trans('language::lang.locale') }}</label>
                                                    <input id="lang_locale" type="text" class="form-control">
                                                    {!! Form::helper(trans('language::lang.locale_helper')) !!}
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="lang_code" class="control-label">{{ trans('language::lang.language_code') }}</label>
                                                    <input id="lang_code" type="text" class="form-control">
                                                    {!! Form::helper(trans('language::lang.language_code_helper')) !!}
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="lang_text_direction" class="control-label">{{ trans('language::lang.text_direction') }}</label>
                                                    <p>
                                                        <label class="me-2">
                                                            <input name="lang_rtl" class="lang_is_ltr" type="radio" value="0" checked="checked"> {{ trans('language::lang.left_to_right') }}
                                                        </label>
                                                        <label>
                                                            <input name="lang_rtl" class="lang_is_rtl" type="radio" value="1"> {{ trans('language::lang.right_to_left') }}
                                                        </label>
                                                    </p>
                                                    {!! Form::helper(trans('language::lang.text_direction_helper')) !!}
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="flag_list" class="control-label">{{ trans('language::lang.flag') }}</label>
                                                    <select id="flag_list" class="form-control select-search-language">
                                                        <option>{{ trans('language::lang.select_flag') }}</option>
                                                        @foreach ($flags as $key => $flag)
                                                            <option value="{{ $key }}">{{ $flag }}</option>
                                                        @endforeach
                                                    </select>
                                                    {!! Form::helper(trans('language::lang.flag_helper')) !!}
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="lang_order" class="control-label">{{ trans('language::lang.order') }}</label>
                                                    <input id="lang_order" type="number" value="0" class="form-control">
                                                    {!! Form::helper(trans('language::lang.order_helper')) !!}
                                                </div>
                                                <input type="hidden" id="lang_id" value="0">
                                                <p class="submit">
                                                    <button class="btn btn-primary" id="btn-language-submit">{{ trans('language::lang.add_new_language') }}</button>
                                                </p>
                                            </div>
                                        </div>
                                        @php do_action(BASE_ACTION_META_BOXES, 'advanced', new \Modules\Language\Http\Models\Language) @endphp
                                    </div>
                                    <div class="col-md-7">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-language">
                                                <thead>
                                                <tr>
                                                    <th class="text-start"><span>{{ trans('language::lang.language_name') }}</span></th>
                                                    <th class="text-center"><span>{{ trans('language::lang.locale') }}</span></th>
                                                    <th class="text-center"><span>{{ trans('language::lang.code') }}</span></th>
                                                    <th class="text-center"><span>{{ trans('language::lang.default_language') }}</span></th>
                                                    <th class="text-center"><span>{{ trans('language::lang.order') }}</span></th>
                                                    <th class="text-center"><span>{{ trans('language::lang.flag') }}</span></th>
                                                    <th class="text-center"><span>{{ trans('language::lang.actions') }}</span></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($activeLanguages as $item)
                                                    @include('language::partials.language-item', compact('item'))
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_settings">
                                {!! Form::open(['route' => 'languages.settings']) !!}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <br>
                                            <div class="form-group mb-3 @if ($errors->has('language_hide_default')) has-error @endif">
                                                <label class="text-title-field"
                                                       for="language_hide_default">{{ trans('language::lang.language_hide_default') }}
                                                </label> </br>
                                                <label class="me-2">
                                                    <input type="radio" name="language_hide_default"
                                                           value="1"
                                                           @if (setting('language_hide_default', true)) checked @endif>{{ trans('kamruldashboard::lang.yes') }}
                                                </label>
                                                <label>
                                                    <input type="radio" name="language_hide_default"
                                                           value="0"
                                                           @if (!setting('language_hide_default', true)) checked @endif>{{ trans('kamruldashboard::lang.no') }}
                                                </label>
                                            </div>
                                            <div class="form-group mb-3 @if ($errors->has('language_display')) has-error @endif">
                                                <label for="language_display">{{ trans('language::lang.language_display') }}</label>
                                                <div class="ui-select-wrapper">
                                                    {!! Form::select('language_display', ['all' => trans('language::lang.language_display_all'), 'flag' => trans('language::lang.language_display_flag_only'), 'name' => trans('language::lang.language_display_name_only')], setting('language_display', 'all'), ['class' => 'form-control', 'id' => 'language_display']) !!}
                                                </div>
                                            </div>

                                            <div class="form-group mb-3 @if ($errors->has('language_switcher_display')) has-error @endif">
                                                <label for="language_switcher_display">{{ trans('language::lang.switcher_display') }}</label>
                                                <div class="ui-select-wrapper">
                                                    {!! Form::select('language_switcher_display', ['dropdown' => trans('language::lang.language_switcher_display_dropdown'), 'list' => trans('language::lang.language_switcher_display_list')], setting('language_switcher_display', 'dropdown'), ['class' => 'form-control', 'id' => 'language_switcher_display']) !!}
                                                </div>
                                            </div>

                                            <div class="form-group mb-3 @if ($errors->has('language_hide_languages')) has-error @endif">
                                                <label for="language_hide_languages">{{ trans('language::lang.hide_languages') }}</label>
                                                <p><span style="font-size: 90%;">{{ trans('language::lang.hide_languages_description') }}</span></p>
                                                <ul class="list-item-checkbox">
                                                    @foreach (Language::getActiveLanguage() as $language)
                                                        @if (!$language->lang_is_default)
                                                            <li style="padding-left: 10px;">
                                                                <input type="checkbox" name="language_hide_languages[]" value="{{ $language->lang_id }}" id="language_hide_languages_item-{{ $language->lang_code }}" @if (in_array($language->lang_id, json_decode(setting('language_hide_languages', '[]'), true))) checked="checked" @endif>
                                                                <label for="language_hide_languages_item-{{ $language->lang_code }}">{{ $language->lang_name }}</label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                                {!! Form::helper(trans_choice('language::lang.hide_languages_helper_display_hidden', count(json_decode(setting('language_hide_languages', '[]'), true)), ['language' => Language::getHiddenLanguageText()])) !!}
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="text-title-field"
                                                       for="language_show_default_item_if_current_version_not_existed">{{ trans('language::lang.language_show_default_item_if_current_version_not_existed') }}
                                                </label><br/>
                                                <label class="me-2">
                                                    <input type="radio" name="language_show_default_item_if_current_version_not_existed"
                                                           value="1"
                                                           @if (setting('language_show_default_item_if_current_version_not_existed', true)) checked @endif>{{ trans('kamruldashboard::lang.yes') }}
                                                </label>
                                                <label>
                                                    <input type="radio" name="language_show_default_item_if_current_version_not_existed"
                                                           value="0"
                                                           @if (!setting('language_show_default_item_if_current_version_not_existed', true)) checked @endif>{{ trans('kamruldashboard::lang.no') }}
                                                </label>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="text-title-field"
                                                       for="language_auto_detect_user_language">{{ trans('language::lang.language_auto_detect_user_language') }}
                                                </label><br/>
                                                <label class="me-2">
                                                    <input type="radio" name="language_auto_detect_user_language"
                                                           value="1"
                                                           @if (setting('language_auto_detect_user_language', false)) checked @endif>{{ trans('kamruldashboard::lang.yes') }}
                                                </label>
                                                <label>
                                                    <input type="radio" name="language_auto_detect_user_language"
                                                           value="0"
                                                           @if (!setting('language_auto_detect_user_language', false)) checked @endif>{{ trans('kamruldashboard::lang.no') }}
                                                </label>
                                            </div>

                                            <div class="text-start">
                                                <button type="submit" name="submit" value="save" class="btn btn-info button-save-language-settings">
                                                    <i class="fa fa-save"></i> {{ trans('kamruldashboard::lang.save') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('kamruldashboard::partials.modal-item', [
        'type'        => 'danger',
        'name'        => 'modal-confirm-delete',
        'title'       => trans('kamruldashboard::lang.confirm_delete'),
        'content'     => trans('language::lang.delete_confirmation_message'),
        'action_name' => trans('kamruldashboard::lang.delete'),
        'action_button_attributes' => [
            'class' => 'delete-crud-entry',
        ],
    ])
@stop
