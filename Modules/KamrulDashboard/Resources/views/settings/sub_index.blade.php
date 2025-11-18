@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
{{--    <link href="{{ url('vendor/dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">--}}
<link href="{{ url('vendor/dashboard/vendor/summernote/summernote.css') }}" rel="stylesheet">


@endsection
@section('javascript')

    <!-- Summernote -->
    <script src="{{ url('vendor/dashboard/vendor/summernote/js/summernote.min.js') }}"></script>
    <!-- Summernote init -->
    <script src="{{ url('vendor/dashboard/js/plugins-init/summernote-init.js') }}"></script>

    <script>
        // $('#fieldType').on('change', function() {
        //     var value = $(this).val();
        //     // alert(value);
        //     console.log(value);
        // });
        function getMessage(value, field_s) {
            console.log(field_s);
            $.ajax({
                type:'POST',
                url:'/systemsettings/settings/add-ajax-data',
                data:{
                    "_token" : "<?php echo csrf_token() ?>",
                    "value" : value,
                },
                success:function(data) {
                    $(field_s).html(data);
                }
            });
        }
    </script>
@endsection
@section('title', __( 'kamruldashboard::all_lang.' . $title))
@section('content')

    <?php $field_types = array(
        '' => 'Select Type',
        'text' => 'Text',
        'number' => 'Number',
        'email' => 'Email',
        'password' => 'Password',
        'select' => 'Select',
        'checkbox' => 'Checkbox',
        'file' => 'Image(.png/.jpeg/.jpg)',
        'textarea' => 'Textarea',
    ); ?>
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
                    <form name="formKamruldashboard" method="POST" action="{{ url('systemsettings/settings/add-sub-settings', $record->slug) }}" novalidate=""  enctype="multipart/form-data">
{{--                        {{ method_field("PATCH") }}--}}
                @else
                    @php
                        $button = 'save';
                    @endphp
                            <form method="POST" action="{{ url('systemsettings/settings/add') }}"  enctype="multipart/form-data">
                @endif
                @csrf

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>@lang('kamruldashboard::all_lang.key')</label>
                            <input type="text" id="key" name="key" value="" class="form-control" placeholder="@lang('kamruldashboard::all_lang.key')">
                            @error('key')
                            {!! getValidationMessage()!!}
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label>@lang('kamruldashboard::all_lang.tool_tip')</label>
                            <input type="text" id="tool_tip" name="tool_tip" value="" class="form-control" placeholder="@lang('kamruldashboard::all_lang.tool_tip')">
                            @error('tool_tip')
                            {!! getValidationMessage()!!}
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label>@lang('kamruldashboard::all_lang.type')</label>
                            <select id="type" onchange="getMessage(this.value,'#fieldShow')" name="type" class="form-control">
                                @foreach($field_types as $key_a=>$value)
                                <option value="{{ $key_a }}"  >{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="form-row" id="fieldShow">

                    </div>
                    <div class="form-row" id="fieldShowSecond">

                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('kamruldashboard::lang.'.$button) }}</button>
                    </form>
            </div>
        </div>
    </div>
@endsection
