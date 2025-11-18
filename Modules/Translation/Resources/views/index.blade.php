@extends('kamruldashboard::layouts.app_master')
@section('stylesheet')
    <link rel="stylesheet" href="{{ url('vendor/kamruldashboard/vendor/toastr/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ url('vendor/kamruldashboard/vendor/bootstrap3-editable/css/bootstrap-editable.css') }}">
    <link rel="stylesheet" href="{{ url('vendor/kamruldashboard/translation/css/translation.css') }}">

@endsection
@section('javascript')
    <script type="text/javascript">
        var csrf_token = "{{ csrf_token() }}";
        var translations_index = "{{ route('translations.index') }}";
    </script>
    <script src="{{ url('vendor/kamruldashboard/vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/js/toastr_script.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/vendor/bootstrap3-editable/js/bootstrap-editable.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/translation/js/translation.js') }}"></script>

@endsection
@section('title', __( 'translation::lang.' . $title))
@section('content')
    <div class="widget meta-boxes">
        <div class="widget-title">
            <h4>&nbsp; {{ trans('translation::lang.translations') }}</h4>
        </div>
        <div class="widget-body box-translation">
            @if (empty($group))
                {!! Form::open(['route' => 'translations.import', 'class' => 'form-inline', 'role' => 'form']) !!}
                    <div class="ui-select-wrapper d-inline-block">
                        <select name="replace" class="form-control ui-select">
                            <option value="0">{{ trans('translation::lang.append_translation') }}</option>
                            <option value="1">{{ trans('translation::lang.replace_translation') }}</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary button-import-groups">{{ trans('translation::lang.import_group') }}</button>
                {!! Form::close() !!}
                <br>
            @endif
            @if (!empty($group))
                <form method="POST" action="{{ route('translations.group.publish', compact('group')) }}" class="form-inline" role="form">
                    @csrf
                    <button type="submit" class="btn btn-info button-publish-groups">{{ trans('translation::lang.publish_translations') }}</button>
                    <a href="{{ route('translations.index') }}" class="btn btn-secondary translation-back">{{ trans('translation::lang.back') }}</a>
                </form>
                <p class="text-info">{{ trans('translation::lang.export_warning') }}</p>
            @endif
            {!! Form::open(['role' => 'form']) !!}
                <div class="ui-select-wrapper">
                    <select name="group" id="group" class="form-control ui-select group-select select-search-full">
                        @foreach($groups as $key => $value)
                            <option value="{{ $key }}"{{ $key == $group ? ' selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <br>
            {!! Form::close() !!}
            @if (!empty($group))
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            @foreach($locales as $locale)
                                <th>{{ $locale }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($translations as $key => $translation)
                            <tr id="{{ $key }}">
                                @foreach($locales as $locale)
                                    @php $item = isset($translation[$locale]) ? $translation[$locale] : null @endphp
                                    <td class="text-start">
                                        <a href="#edit" class="editable status-{{ $item ? $item->status : 0 }} locale-{{ $locale }}"
                                           data-locale="{{ $locale }}" data-name="{{ $locale . '|' . $key }}"
                                           data-type="textarea" data-pk="{{ $item ? $item->id : 0 }}" data-url="{{ $editUrl }}"
                                           data-title="{{ trans('translation::lang.edit_title') }}">{!! ($item ? htmlentities($item->value, ENT_QUOTES, 'UTF-8', false) : '') !!}</a>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-info">{{ trans('translation::lang.choose_group_msg') }}</p>
            @endif
        </div>
        <div class="clearfix"></div>
    </div>
    @if (!empty($group))
        {!! Form::modalAction('confirm-publish-modal', trans('translation::lang.publish_translations'), 'warning', trans('translation::lang.confirm_publish_group', ['group' => $group]), 'button-confirm-publish-groups', trans('kamruldashboard::lang.yes')) !!}
    @endif
@stop
