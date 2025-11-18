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
            <h4 class="card-title">@lang( 'kamruldashboard::lang.' . $title)</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                @if(isset($record))
                    @php
                        $button = 'update';
                    @endphp
                    <form name="formUser" method="POST" action="{{ route('user.password_update', $record->id) }}" novalidate=""  enctype="multipart/form-data">
                        {{ method_field("PATCH") }}
                @else
                    @php
                        $button = 'save';
                    @endphp
                            <form method="POST" action="{{ route('user.change_password') }}"  enctype="multipart/form-data">
                @endif
                @csrf

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>@lang('kamruldashboard::lang.password')</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="@lang('kamruldashboard::lang.password')">
                            @error('password')
                            {!! getValidationError($message)!!}
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>@lang('kamruldashboard::lang.confirmation_password')</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="@lang('kamruldashboard::lang.confirmation_password')">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('kamruldashboard::lang.'.$button) }}</button>
                    </form>
            </div>
        </div>
    </div>
@endsection
