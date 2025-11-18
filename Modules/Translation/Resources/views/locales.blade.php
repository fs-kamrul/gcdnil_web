@extends('kamruldashboard::layouts.app_master')
@section('stylesheet')
    <link rel="stylesheet" href="{{ url('vendor/kamruldashboard/vendor/toastr/css/toastr.min.css') }}">

@endsection
@section('javascript')
    <script type="text/javascript">
        var csrf_token = "{{ csrf_token() }}";
    </script>
    <script src="{{ url('vendor/kamruldashboard/vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/js/toastr_script.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/translation/js/locales.js') }}"></script>

@endsection
@section('title', __( 'translation::lang.' . $title))
@section('content')
    <div class="widget meta-boxes">
        <div class="widget-title">
            <h4>&nbsp; {{ trans('translation::lang.locales') }}</h4>
        </div>
        <div class="widget-body box-translation">
            <div class="row">
                <div class="col-md-5">
                    <div class="main-form">
                        <div class="form-wrap">
                            <form class="add-locale-form" action="{{ route('translations.locales') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="locale_id" class="control-label">{{ trans('translation::lang.locale') }}</label>
                                    <div class="ui-select-wrapper form-group">
                                        <select id="locale_id" name="locale" class="form-control select-search-full">
                                            <option value="">{{ trans('translation::lang.select_language') }}</option>
                                            @foreach ($locales as $key => $name)
                                                <option value="{{ $key }}"> {{ $name }} - {{ $key }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <p class="submit">
                                    <button class="btn btn-primary" type="submit">{{ trans('translation::lang.add_new_language') }}</button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="table-responsive">
                        <table class="table table-hover table-language table-header-color" style="background: #f1f1f1;">
                            <thead>
                            <tr>
                                <th class="text-start"><span>{{ trans('translation::lang.name') }}</span></th>
                                <th class="text-center"><span>{{ trans('translation::lang.locale') }}</span></th>
                                <th class="text-center"><span>{{ trans('translation::lang.actions') }}</span></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($existingLocales as $item)
                                    @include('translation::partials.locale-item', compact('item'))
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    @include('kamruldashboard::partials.modal-item', [
        'type'        => 'danger',
        'name'        => 'modal-confirm-delete',
        'title'       => trans('kamruldashboard::lang.confirm_delete'),
        'content'     => trans('translation::lang.confirm_delete_message'),
        'action_name' => trans('kamruldashboard::lang.delete'),
        'action_button_attributes' => [
            'class' => 'delete-crud-entry',
        ],
    ])
@stop
