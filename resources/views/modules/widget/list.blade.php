
@section('title', $title)

@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')

    <link rel="stylesheet" href="{{ url('vendor/kamruldashboard/vendor/toastr/css/toastr.min.css') }}">
    <link href="{{ url('vendor/kamruldashboard/vendor/Scrollbar/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
    <link href="{{ url('vendor/kamruldashboard/vendor/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ url('vendor/kamruldashboard/vendor/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('vendor/kamruldashboard/widget/widget.css') }}" rel="stylesheet">
@endsection
@section('javascript')

    <script src="{{ url('vendor/kamruldashboard/vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/js/dashboard/Sortable.min.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/vendor/Scrollbar/jquery.mCustomScrollbar.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/vendor/stickytableheaders/jquery.stickytableheaders.min.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/vendor/select2/js/select2.min.js') }}"></script>
    <script>
        'use strict';
        var csrf_token = "{{ csrf_token() }}";
        var KDWidget = KDWidget || {};
        KDWidget.routes = {
            'delete': '{{ route('widgets.destroy', ['ref_lang' => request()->input('ref_lang')]) }}',
            'save_widgets_sidebar': '{{ route('widgets.save_widgets_sidebar', ['ref_lang' => request()->input('ref_lang')]) }}'
        };
    </script>
    <script src="{{ url('vendor/kamruldashboard/js/toastr_script.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/widget/widget.js') }}"></script>
@endsection
@section('content')
    @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), WIDGET_MANAGER_MODULE_SCREEN_NAME) @endphp
    <div class="widget-main" id="wrap-widgets">
        <div class="row page-content">
            <div class="col-sm-6">
                <h2>{{ trans('widget::lang.available') }}</h2>
                <p>{{ trans('widget::lang.instruction') }}</p>
                <ul id="wrap-widget-1">
                    @foreach (Widget::getWidgets() as $widget)
                        <li data-id="{{ $widget->getId() }}">
                            <div class="widget-handle">
                                <p class="widget-name">{{ $widget->getConfig()['name'] }} <span class="text-end"><i class="fa fa-caret-up"></i></span>
                                </p>
                            </div>
                            <div class="widget-content">
                                <form method="post">
                                    <input type="hidden" name="id" value="{{ $widget->getId() }}">
                                    {!! $widget->form() !!}
                                    <div class="widget-control-actions">
                                        <div class="float-start">
                                            <button class="btn btn-danger widget-control-delete">{{ trans('widget::lang.delete') }}</button>
                                        </div>
                                        <div class="float-end text-end">
                                            <button class="btn btn-primary widget_save">{{ trans('kamruldashboard::lang.save') }}</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="widget-description">
                                <p>{{ $widget->getConfig()['description'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="col-sm-6" id="added-widget">
                {!! apply_filters(WIDGET_TOP_META_BOXES, null, WIDGET_MANAGER_MODULE_SCREEN_NAME) !!}
                <div class="row">
                    @foreach (WidgetGroup::getGroups() as $group)
                        <div class="col-sm-6 sidebar-item" data-id="{{ $group->getId() }}">
                            <div class="sidebar-area">
                                <div class="sidebar-header">
                                    <h3>{{ $group->getName() }}</h3>
                                    <p>{{ $group->getDescription() }}</p>
                                </div>
                                <ul id="wrap-widget-{{ ($loop->index + 2) }}">
                                    @include('widget::item', ['widgetAreas' => $group->getWidgets()])
                                    <div class="clearfix"></div>
                                </ul>
                            </div>
                        </div>
                        @if ($loop->index % 2 != 0)
                            <div class="clearfix"></div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
