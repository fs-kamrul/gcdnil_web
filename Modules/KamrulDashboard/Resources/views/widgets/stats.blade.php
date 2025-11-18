@if (empty($widgetSetting) || $widgetSetting->status == 1)
    <div class="col-lg-3 col-sm-6 col-md-3">
        <div class="card">
            <a class="stat-widget-one card-body" style="background-color: {{ $widget->color }}; color: #fff" href="{{ $widget->route }}">
                <div class="stat-icon d-inline-block">
                    <i class="{{ $widget->icon }}"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text text-white">{{ $widget->title }}</div>
                    <div class="stat-digit text-white">{{ $widget->statsTotal }}</div>
                </div>
            </a>
        </div>
    </div>
@endif
