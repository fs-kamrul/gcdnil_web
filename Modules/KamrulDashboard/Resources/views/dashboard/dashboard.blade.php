@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
        <link href="{{ url('vendor/kamruldashboard/vendor/morris/morris.css') }}" rel="stylesheet">
@endsection
@section('javascript')
    <script src="{{ url('vendor/kamruldashboard/vendor/jquery.blockUI.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/vendor/stickytableheaders/jquery.stickytableheaders.min.js') }}"></script>
@endsection

@section('title', __( 'kamruldashboard::all_lang.' . $title ))
@section('content')

    <div class="row">
        @foreach ($statWidgets as $widget)
            {!! $widget !!}
        @endforeach
        <div class="clearfix"></div>
    </div>
            {!! Dboard::render('main-dashboard'); !!}
            <div id="list_widgets" class="row">
                @foreach ($userWidgets as $widget)
                    {!! $widget !!}
                @endforeach
                <div class="clearfix"></div>
            </div>
@endsection
