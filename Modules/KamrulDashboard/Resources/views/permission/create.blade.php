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
            <h4 class="card-title">@lang('kamruldashboard::lang.permission_create')</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                @if(isset($record))
                    @php
                        $button = 'update';
                        $language = getLanguageUrlPost($record->id , 'permission');
                //    dd($language['code']);
                    @endphp
                    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
                        <input type="hidden" name="model" value="{{ \Modules\Kamruldashboard\Http\Models\Permission::class }}">
                        <input type="hidden" name="language" value="{{ $language['code'] }}">
                @else
                    @php
                        $button = 'save';
                    @endphp
                            <form method="POST" action="{{ route('permission.createpermission.store') }}"  enctype="multipart/form-data">
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



                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('kamruldashboard::lang.'.$button) }}</button>
                    </form>
            </div>
        </div>
    </div>
@endsection
