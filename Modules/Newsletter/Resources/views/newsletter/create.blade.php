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
@section('title', __( 'newsletter::lang.' . $title))
@section('content')

@if(isset($record))
    @php
        $button = 'update';
        $language = getLanguageUrlPost($record->id , 'user');
    @endphp
    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
        <input type="hidden" name="model" value="{{ \Modules\Newsletter\Http\Models\Newsletter::class }}">
        <input type="hidden" name="language" value="{{ $language['code'] }}">
        @else
            @php
                $button = 'save';
            @endphp
            <form method="POST" action="{{ route('newsletter.createnewsletter.store') }}"  enctype="multipart/form-data">
@endif
@csrf
    <div class="row">
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('newsletter::lang.newsletter_create')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>@lang('newsletter::lang.name')</label>
                                <input type="text" id="name" name="name" value="@isset($record){{$record->name}}@else{{ old('name') }}@endisset" class="form-control" placeholder="@lang('newsletter::lang.name')">
                                @error('name')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label>@lang('newsletter::lang.email')</label>
                                <input type="text" id="email" name="email" value="@isset($record){{$record->email}}@else{{ old('email') }}@endisset" class="form-control" placeholder="@lang('newsletter::lang.email')">
                                @error('email')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>

{{--                            @isset($record){!! status_design_html($record->status,6, __('newsletter::lang.status')) !!} @else{!! status_design_html(1,6, __('newsletter::lang.status')) !!} @endisset--}}

{{--                            <div class="col-xl-12 col-xxl-12">--}}
{{--                                <label><strong>@lang('newsletter::lang.description')</strong></label>--}}
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
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('newsletter::lang.publish')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                        <div class="form-row">
                            <div class="form-row">
                                <button type="submit" class="btn btn-primary">{{ __('newsletter::lang.'.$button) }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection
