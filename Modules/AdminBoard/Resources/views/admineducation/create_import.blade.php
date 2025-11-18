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
@section('title', __( 'adminboard::lang.' . $title))
@section('content')

<div class="card">
    <div class="card-header">
        <h4 class="card-title">@lang('adminboard::lang.admineducation_create')</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
            @if(isset($record))
            @php
            $button = 'update';
            @endphp
            <form name="formadmineducation" method="POST" action="{{ url('adminboard/admineducation/store_import', $record->id) }}" novalidate=""  enctype="multipart/form-data">
                {{ method_field("PATCH") }}
                @else
                @php
                $button = 'save';
                @endphp
                <form method="POST" action="{{ url('adminboard/admineducation/store_import') }}"  enctype="multipart/form-data">
                    @endif
                    @csrf

                    <div class="form-row">

                        @isset($record){!! input_design_html('photo',$record,6,'file', __('adminboard::lang.import')) !!} @else{!! input_design_html('photo',null,6,'file', __('adminboard::lang.import')) !!} @endisset

                        @error('photo')
                        {!! getValidationMessage()!!}
                        @enderror
                        @php echo  '</div>'; @endphp



        </div>

        <button type="submit" class="btn btn-primary">{{ __('adminboard::lang.'.$button) }}</button>
        </form>
    </div>
</div>
</div>
@endsection
