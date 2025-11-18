@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
{{--    <link href="{{ url('vendor/kamruldashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">--}}
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
@section('title', __( 'captcha::lang.' . $title))
@section('content')

@if(isset($record))
    @php
        $button = 'update';
        $language = getLanguageUrlPost($record->id , 'captcha');
    @endphp
    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
        <input type="hidden" name="model" value="{{ \Modules\Captcha\Http\Models\Captcha::class }}">
        <input type="hidden" name="language" value="{{ $language['code'] }}">
@else
    @php
        $button = 'save';
    @endphp
    <form method="POST" action="{{ route('captcha.createcaptcha.store') }}"  enctype="multipart/form-data">
@endif
@csrf
        @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), \Modules\Captcha\Http\Models\Captcha::class) @endphp
    <div class="row">
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('captcha::lang.captcha_create')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <div class="form-row">
                            {!! Form::textField('name', isset($record) ? $record->name : null, 'captcha', '12', ['placeholder'=> __('captcha::lang.name')]) !!}

                            @php
                                if(isset($record)){
                                    $slug = get_slug_table_data(null, \Modules\Captcha\Http\Models\Captcha::class,$record->id, \Modules\Captcha\Http\Models\Captcha::class);
                                }
                            @endphp
                            {!! Form::permalink('slug', isset($slug) ? $slug->key : null, isset($slug) ? $slug->reference_id : null, isset($slug) ? $slug->prefix : null) !!}

                            @isset($record) @if($language['code_edit']){!! input_design_html('photo',$record,6,'file', __('captcha::lang.photo')) !!} @endif @else{!! input_design_html('photo',null,6,'file', __('captcha::lang.photo')) !!} @endisset

                            @isset($record) @if($language['code_edit']){!! status_design_html($record->status,6, __('captcha::lang.status')) !!} @endif @else{!! status_design_html(1,6, __('captcha::lang.status')) !!} @endisset

                            <div class="col-xl-12 col-xxl-12">
                                <label><strong>@lang('captcha::lang.description')</strong></label>
                                <textarea class="summernote" id="description" name="description">@isset($record){{$record->description}}@else{{ old('description') }}@endisset</textarea>
                                @error('description')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-md-3">
            {!! Form::formActions(__('captcha::lang.publish'), '') !!}

            @isset($record)
                @php do_action(BASE_ACTION_META_BOXES, 'top', \Modules\Captcha\Http\Models\Captcha::where('id',$record->id)->first()) @endphp
            @endisset
        </div>
    </div>
    </form>
@endsection
