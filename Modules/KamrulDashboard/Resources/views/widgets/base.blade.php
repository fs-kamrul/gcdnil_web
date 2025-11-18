@if (empty($widgetSetting) || $widgetSetting->status == 1)
    <div class="{{ $widget->column }} widget_item" id="{{ $widget->name }}" data-url="{{ $widget->route }}">
        <div class="portlet light bordered portlet-no-padding card @if ($widget->hasLoadCallback) widget-load-has-callback @endif">
            <div class="portlet-title">
                <div class="caption card-header">

                    <h4 class="caption-subject font-dark card-title">
                        <i class="{{ $widget->icon }} font-dark fw-bold"></i>
                        {{ $widget->title }}
                    </h4>
                    @include('kamruldashboard::partials.tools')
                </div>
            </div>
            <div class="card-body">
{{--                <div class="ct-bar-chart mt-5"></div>--}}
                <div class="portlet-body @if ($widget->isEqualHeight) equal-height @endif widget-content {{ $widget->bodyClass }} {{ Arr::get($settings, 'state') }}">
                </div>
            </div>
        </div>
    </div>
@endif
