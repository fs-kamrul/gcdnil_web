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
@section('title', $title)
@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ $title }}</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                @if(isset($record))
                    @php
                        $button = 'update';
                    @endphp
                    <form name="formKamruldashboard" method="POST" action="{{ url('systemsettings/settings/add-sub-settings', $record->slug) }}" novalidate=""  enctype="multipart/form-data">
                        {{ method_field("PATCH") }}
                @else
                    @php
                        $button = 'save';
                    @endphp
                            <form method="POST" action="{{ url('systemsettings/settings/add-sub-settings') }}"  enctype="multipart/form-data">
                @endif
                @csrf

                                <div class="row">
                                    @if($record->photo)
                                        <img src="{{ url('uploads/settings/'.$record->photo) }}" width="100" height="100">
                                    @endif
                                </div>
                                    @if(count($settings_data))
                    <div class="form-row">
{{--                        <div class="form-group col-md-12">--}}
{{--                            <img src="rechaptcha.png" height="25px"><a href="https://www.google.com/recaptcha/admin#list" target="_blank" class="btn  btn-primary button" >--}}
{{--                                Manage your reCAPTCHA API keys</a>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-12">--}}
{{--                            <label>@lang('all_lang.title')</label>--}}
{{--                            <input type="text" id="title" name="title" value="@isset($record){{$record->title}}@else{{ old('title') }}@endisset" class="form-control" placeholder="@lang('all_lang.title')">--}}
{{--                            @error('title')--}}
{{--                            {!! getValidationMessage()!!}--}}
{{--                            @enderror--}}
{{--                        </div>--}}

                                @foreach($settings_data as $key=>$value)
                                    <?php
                                    $type_name = 'text';

                                    if($value->type == 'number' || $value->type == 'email' || $value->type=='password')
                                        $type_name = 'text';
                                    else
                                        $type_name = $value->type;
                                    ?>
                                    @include(
                                                'kamruldashboard::settings.sub-list-views.'.$type_name.'-type',
                                                array('key'=>$key, 'value'=>$value)
                                            )
                                @endforeach



{{--                        <div class="col-xl-12 col-xxl-12">--}}
{{--                            <label><strong>@lang('all_lang.description')</strong></label>--}}
{{--                            <textarea class="summernote" id="description" name="description">@isset($record){{$record->description}}@else{{ old('description') }}@endisset</textarea>--}}
{{--                            @error('description')--}}
{{--                            {!! getValidationMessage()!!}--}}
{{--                            @enderror--}}
{{--                        </div>--}}


                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('kamruldashboard::lang.'.$button) }}</button>

                                @else
                                                                    <li style="margin-top: 20px;" class="list-group-item">{{ __('kamruldashboard::all_lang.no_settings_available')}}</li>
                                @endif
                    </form>
            </div>
        </div>
    </div>
@endsection
