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
@section('title', __( 'menus::lang.' . $title))
@section('content')

@if(isset($record))
    @php
        $button = 'update';
        $language = getLanguageUrlPost($record->id , 'menus');
    @endphp
    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
        <input type="hidden" name="model" value="{{ \Modules\Menus\Http\Models\Menus::class }}">
        <input type="hidden" name="language" value="{{ $language['code'] }}">
@else
    @php
        $button = 'save';
    @endphp
    <form method="POST" action="{{ route('menus.createmenus.store') }}"  enctype="multipart/form-data">
@endif
@csrf
    <div class="row">
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('menus::lang.menus_create')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>@lang('menus::lang.name')</label>
                                <input type="text" id="name" name="name" value="@isset($record){{$record->name}}@else{{ old('name') }}@endisset" class="form-control" placeholder="@lang('menus::lang.name')">
                                @error('name')
{{--                                {!! getValidationMessage()!!}--}}
                                @enderror
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-md-3">

            {!! Form::formActions(__('menus::lang.publish'), '') !!}

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('menus::lang.status')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                        <div class="form-row">
                            @isset($record){!! status_design_html($record->status,12, __('menus::lang.status')) !!} @else{!! status_design_html(1,12, __('menus::lang.status')) !!} @endisset

                        </div>
                    </div>
                </div>
            </div>

                @php do_action(BASE_ACTION_META_BOXES, 'top', new \Modules\Menus\Http\Models\Menus) @endphp
        </div>
    </div>
    </form>
@endsection
