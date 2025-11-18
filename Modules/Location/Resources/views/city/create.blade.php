@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
<link href="{{ url('vendor/kamruldashboard/vendor/summernote/summernote.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ url('vendor/kamruldashboard/slug/slug.css') }}" type="text/css"/>


@endsection
@section('javascript')

    <!-- Summernote -->
    <script src="{{ url('vendor/kamruldashboard/vendor/summernote/js/summernote.min.js') }}"></script>
    <!-- Summernote init -->
    <script src="{{ url('vendor/kamruldashboard/js/plugins-init/summernote-init.js') }}"></script>

    <script type="text/javascript">
        var csrf_token = "{{ csrf_token() }}";
    </script>
    <script src="{{ url('vendor/kamruldashboard/slug/slug.js') }}"></script>

@endsection
@section('title', __( 'location::lang.' . $title))
@section('content')

@if(isset($record))
    @php
        $button = 'update';
        $language = getLanguageUrlPost($record->id , 'city');
    @endphp
    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
        <input type="hidden" name="model" value="{{ \Modules\Location\Http\Models\City::class }}">
        <input type="hidden" name="language" value="{{ $language['code'] }}">
@else
    @php
        $button = 'save';
    @endphp
    <form method="POST" action="{{ route('city.createcity.store') }}"  enctype="multipart/form-data">
@endif
@csrf
        @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), \Modules\Location\Http\Models\City::class) @endphp

    <div class="row">
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('location::lang.'.$title)</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <div class="form-row">

                            {!! Form::textField('name', isset($record) ? $record->name : null, 'location', '12', ['placeholder'=> __('location::lang.name')]) !!}

                            @isset($record) @if($language['code_edit']){!! status_design_html($record->status,4, __('location::lang.status')) !!} @endif @else{!! status_design_html(1,4, __('location::lang.status')) !!} @endisset

                            @if(isset($record) ? $language['code_edit'] : 1)
                                <div class="form-group col-md-4">
                                    <label>{{ __('Country') }}</label>
                                    {!! Form::customSelect('country_id', $country, isset($record) ? $record->country_id : 0, ['class' => 'form-control select-full']) !!}
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="widget_menu">{{ __('State') }}</label>
                                    {!! Form::customSelect('state_id', $state, isset($record) ? $record->state_id : 0, ['class' => 'form-control select-full']) !!}
                                </div>
                                {!! Form::numberField('order', isset($record) ? $record->order : 0, 'location', '12', ['placeholder'=>__('Order Id')]) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-md-3">
            {!! Form::formActions(__('location::lang.publish'), '') !!}
            @if(isset($record) ? $language['code_edit'] : 1)
                {!! Form::onOff('is_default', isset($record) ? $record->is_default : false) !!}
            @endif

            @isset($record)
                @php do_action(BASE_ACTION_META_BOXES, 'top', \Modules\Location\Http\Models\City::where('id',$record->id)->first()) @endphp
            @endisset
        </div>
    </div>
    </form>
@endsection
