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
@section('title', __( 'kamruldashboard::lang.' . $title))
@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">@lang('kamruldashboard::lang.kamruldashboard_create')</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                @if(isset($record))
                    @php
                        $button = 'update';
                    @endphp
                    <form name="formKamrulDashboard" method="POST" action="{{ route('kamruldashboard.update', $record->id) }}" novalidate=""  enctype="multipart/form-data">
                        {{ method_field("PATCH") }}
                @else
                    @php
                        $button = 'save';
                    @endphp
                            <form method="POST" action="{{ route('kamruldashboard.store') }}"  enctype="multipart/form-data">
                @endif
                @csrf

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>@lang('kamruldashboard::lang.name')</label>
                            <input type="text" id="name" name="name" value="@isset($record){{$record->name}}@else{{ old('name') }}@endisset" class="form-control" placeholder="@lang('kamruldashboard::lang.name')">
                            @error('name')
                            {!! getValidationMessage()!!}
                            @enderror
                        </div>

{{--                        @isset($record){!! input_design_html('per_commission',$record,3) !!} @else{!! input_design_html('per_commission',null,3) !!} @endisset--}}
{{--                        @error('per_commission')--}}
{{--                        {!! getValidationMessage()!!}--}}
{{--                        @enderror--}}
{{--                        @php echo  '</div>'; @endphp--}}

                        @isset($record){!! input_design_html('photo',$record,6,'file', __('kamruldashboard::lang.photo')) !!} @else{!! input_design_html('photo',null,6,'file', __('kamruldashboard::lang.photo')) !!} @endisset

                        @error('photo')
                        {!! getValidationMessage()!!}
                        @enderror
                        @php echo  '</div>'; @endphp

                        @isset($record){!! status_design_html($record->status,6, __('kamruldashboard::lang.status')) !!} @else{!! status_design_html(1,6, __('kamruldashboard::lang.status')) !!} @endisset

                        <div class="col-xl-12 col-xxl-12">
                            <label><strong>@lang('kamruldashboard::lang.description')</strong></label>
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
