@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
{{--    <link href="{{ url('vendor/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">--}}
<link href="{{ url('vendor/kamruldashboard/vendor/summernote/summernote.css') }}" rel="stylesheet">


@endsection
@section('javascript')

    <!-- Summernote -->
    <script src="{{ url('vendor/kamruldashboard/vendor/summernote/js/summernote.min.js') }}"></script>
    <!-- Summernote init -->
    <script src="{{ url('vendor/kamruldashboard/js/plugins-init/summernote-init.js') }}"></script>

@endsection
@section('title', __( 'kamruldashboard::all_lang.' . $title))
@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">@lang('kamruldashboard::all_lang.' . $title)</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                @if(isset($record))
                    @php
                        $button = 'update';
                    @endphp
                    <form name="formKamruldashboard" method="POST" action="{{ url('systemsettings/settings/edit', $record->slug) }}" novalidate=""  enctype="multipart/form-data">
                        {{ method_field("PATCH") }}
                @else
                    @php
                        $button = 'save';
                    @endphp
                            <form method="POST" action="{{ url('systemsettings/settings/add') }}"  enctype="multipart/form-data">
                @endif
                @csrf

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>@lang('kamruldashboard::all_lang.title')</label>
                            <input type="text" id="title" name="title" value="@isset($record){{$record->title}}@else{{ old('title') }}@endisset" class="form-control" placeholder="@lang('kamruldashboard::all_lang.title')">
                            @error('title')
                            {!! getValidationMessage()!!}
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label>@lang('kamruldashboard::all_lang.key')</label>
                            <input type="text" id="key" name="key" value="@isset($record){{$record->key}}@else{{ old('key') }}@endisset" class="form-control" placeholder="@lang('kamruldashboard::all_lang.key')">
                            @error('key')
                            {!! getValidationMessage()!!}
                            @enderror
                        </div>

{{--                        @isset($record){!! input_design_html('per_commission',$record,3) !!} @else{!! input_design_html('per_commission',null,3) !!} @endisset--}}
{{--                        @error('per_commission')--}}
{{--                        {!! getValidationMessage()!!}--}}
{{--                        @enderror--}}
{{--                        @php echo  '</div>'; @endphp--}}

                        @isset($record){!! input_design_html('photo',$record,12,'file', __('kamruldashboard::lang.photo')) !!} @else{!! input_design_html('photo',null,12,'file', __('kamruldashboard::lang.photo')) !!} @endisset

                        @error('photo')
                        {!! getValidationMessage()!!}
                        @enderror
                        @php echo  '</div>'; @endphp

                        <div class="col-xl-12 col-xxl-12">
                            <label><strong>@lang('kamruldashboard::all_lang.description')</strong></label>
                            <textarea class="summernote" id="description" name="description">@isset($record){{$record->description}}@else{{ old('description') }}@endisset</textarea>
                            @error('description')
                            {!! getValidationMessage()!!}
                            @enderror
                        </div>


                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('kamruldashboard::lang.'.$button) }}</button>
                    </form>
            </div>
        </div>
    </div>
@endsection
