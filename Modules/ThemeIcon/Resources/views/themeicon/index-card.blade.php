@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ url('vendor/kamruldashboard/vendor/toastr/css/toastr.min.css') }}">

@endsection
@section('javascript')


{{--     <!-- Toastr -->--}}
    <script src="{{ url('vendor/kamruldashboard/vendor/toastr/js/toastr.min.js') }}"></script>
<script src="{{ url('vendor/kamruldashboard/js/toastr_script.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/js/themeIcon.js') }}"></script>

@endsection

@section('title', __( 'themeicon::lang.' . $title))
@section('content')
{{--    <div class="row">--}}
{{--        <div class="col-xl-12 col-xxl-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4 class="card-title">@lang('themeicon::lang.themeicon')</h4>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <h1>Hello World</h1>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
<div class="row">
    <div class="col-12">
        <div class="card pb-3">
            <div class="card-header">
                <h4 class="card-title">@lang('themeicon::lang.themeicon')</h4>
                @if(auth()->user()->can('themeicon_import'))
                    <a href="{{ url('themeicon/import') }}" type="button" class="btn btn-warning"><i class="icon-plus"></i> @lang('themeicon::lang.themeicon_import')</a>
                @endif
                @if(auth()->user()->can('themeicon_create'))
                    <a href="{{ route('themeicon.create') }}" type="button" class="btn btn-dark"><i class="icon-plus"></i> @lang('themeicon::lang.themeicon_create')</a>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    @foreach($themeicon as $key=>$value)
    <div class="col-xl-2 col-xxl-3 col-lg-4 col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title" id="icon_copy_{{ $key }}" style="color: #BDBDC7;">{{ $value->name }}</h5>
            </div>
            <div class="card-body" style="color: black;">
                <p class="card-text">
                    <i class="icon-3x {{ $value->name }}"></i>
{{--                    <input type="text" id="icon_copy_{{ $key }}" value="{{ $value->name }}">--}}
                </p>
            </div>
            <div class="card-footer" style="color: black;">
{{--                <p class="card-text d-inline">Card footer</p> toastr-info-top-right--}}
{{--                onclick="CopyToClick('{{ 'icon_copy_'.$key }}','{{ $value->name }}')"id="{{ 'icon_success_'.$key }}"--}}
                <a  class="card-link float-right copyToTxt" data-txt="{{ $value->name }}">
                    @lang('themeicon::lang.copy_icon')
                </a>
{{--                <button type="button" class="btn btn-info mb-2  mr-2 toastr-info-top-right" id="toastr-info-top-right">Info</button>--}}
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
