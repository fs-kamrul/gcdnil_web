@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
{{--    <link href="{{ url('vendor/kamruldashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">--}}
<link href="{{ url('vendor/kamruldashboard/vendor/summernote/summernote.css') }}" rel="stylesheet">


@endsection
@section('javascript')

    <!-- Summernote -->
    <script src="{{ url('vendor/kamruldashboard/vendor/summernote/js/summernote.min.js') }}"></script>
    <!-- Summernote init -->
    <script src="{{ url('vendor/kamruldashboard/js/plugins-init/summernote-init.js') }}"></script>

@endsection
@section('title', __( 'themeicon::lang.' . $title))
@section('content')

@if(isset($record))
    @php
        $button = 'update';
    @endphp
    <form name="formThemeIcon" method="POST" action="{{ route('themeicon.update', $record->id) }}" novalidate=""  enctype="multipart/form-data">
        {{ method_field("PATCH") }}
@else
    @php
        $button = 'save';
    @endphp
    <form method="POST" action="{{ route('themeicon.store') }}"  enctype="multipart/form-data">
@endif
@csrf
    <div class="row">
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('themeicon::lang.themeicon_create')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>@lang('themeicon::lang.name')</label>
                                <input type="text" id="name" name="name" value="@isset($record){{$record->name}}@else{{ old('name') }}@endisset" class="form-control" placeholder="@lang('themeicon::lang.name')">
                                @error('name')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>
                            @isset($record){!! input_design_html('photo',$record,6,'file', __('themeicon::lang.photo')) !!} @else{!! input_design_html('photo',null,6,'file', __('themeicon::lang.photo')) !!} @endisset

                            @error('photo')
                            {!! getValidationMessage()!!}
                            @enderror
                            @php echo  '</div>'; @endphp

                            @isset($record){!! status_design_html($record->status,6, __('themeicon::lang.status')) !!} @else{!! status_design_html(1,6, __('themeicon::lang.status')) !!} @endisset

                            <div class="col-xl-12 col-xxl-12">
                                <label><strong>@lang('themeicon::lang.description')</strong></label>
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
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('themeicon::lang.publish')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                        <div class="form-row">
                            <div class="form-row">
                                <button type="submit" class="btn btn-primary">{{ __('themeicon::lang.'.$button) }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection
