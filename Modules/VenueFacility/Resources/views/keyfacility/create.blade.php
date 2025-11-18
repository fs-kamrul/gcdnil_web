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
@section('title', __( 'venuefacility::lang.' . $title))
@section('content')

@if(isset($record))
    @php
        $button = 'update';
        $language = getLanguageUrlPost($record->id , 'keyfacility');
    @endphp
    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
        <input type="hidden" name="model" value="{{ \Modules\VenueFacility\Http\Models\KeyFacility::class }}">
        <input type="hidden" name="language" value="{{ $language['code'] }}">
@else
    @php
        $button = 'save';
    @endphp
    <form method="POST" action="{{ route('keyfacility.createkeyfacility.store') }}"  enctype="multipart/form-data">
@endif
@csrf
        @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), \Modules\VenueFacility\Http\Models\KeyFacility::class) @endphp

    <div class="row">
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('venuefacility::lang.keyfacility_create')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <div class="form-row">

                            {!! Form::textField('name', isset($record) ? $record->name : null, 'venuefacility', '12', ['placeholder'=> __('venuefacility::lang.name')]) !!}

                            @php
                                if(isset($record)){
                                    $slug = get_slug_table_data(null, \Modules\VenueFacility\Http\Models\KeyFacility::class,$record->id, \Modules\VenueFacility\Http\Models\KeyFacility::class);
                                }
                            @endphp
                            {!! Form::permalink('slug', isset($slug) ? $slug->key : null, isset($slug) ? $slug->reference_id : null, isset($slug) ? $slug->prefix : null) !!}

{{--                            @isset($record) @if($language['code_edit']){!! input_design_html('photo',$record,6,'file', __('venuefacility::lang.photo')) !!} @endif @else{!! input_design_html('photo',null,6,'file', __('venuefacility::lang.photo')) !!} @endisset--}}

                            @isset($record) @if($language['code_edit']){!! status_design_html($record->status,6, __('venuefacility::lang.status')) !!} @endif @else{!! status_design_html(1,6, __('venuefacility::lang.status')) !!} @endisset

{{--                            <div class="col-xl-12 col-xxl-12">--}}
{{--                                <label><strong>@lang('venuefacility::lang.description')</strong></label>--}}
{{--                                <textarea class="summernote" id="description" name="description">@isset($record){{$record->description}}@else{{ old('description') }}@endisset</textarea>--}}
{{--                                @error('description')--}}
{{--                                {!! getValidationMessage()!!}--}}
{{--                                @enderror--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-md-3">
            {!! Form::formActions(__('venuefacility::lang.publish'), '') !!}

            @isset($record)
                @php do_action(BASE_ACTION_META_BOXES, 'top', \Modules\VenueFacility\Http\Models\KeyFacility::where('id',$record->id)->first()) @endphp
            @endisset
        </div>
    </div>
    </form>
@endsection
