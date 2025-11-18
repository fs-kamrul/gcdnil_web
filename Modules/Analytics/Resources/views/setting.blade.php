<div class="flexbox-annotated-section">
    <div class="flexbox-annotated-section-annotation">
        <div class="annotated-section-title pd-all-20">
            <h2>{{ trans('analytics::lang.settings.title') }}</h2>
        </div>
        <div class="annotated-section-description pd-all-20 p-none-t">
            <p class="color-note">{{ trans('analytics::lang.settings.description') }}</p>
        </div>
    </div>

    <div class="flexbox-annotated-section-content">
        <div class="wrapper-content pd-all-20">
            <div class="form-group mb-3">
                <label class="text-title-field"
                       for="google_analytics">{{ trans('analytics::analytics.settings.google_tag_id') }}</label>
                <input data-counter="120" type="text" class="next-input" name="google_analytics" id="google_analytics"
                       value="{{ setting('google_analytics') }}" placeholder="{{ trans('analytics::analytics.settings.google_tag_id_placeholder') }}">
            </div>
            <div class="form-group mb-3">
                <label class="text-title-field"
                       for="analytics_view_id">{{ trans('analytics::analytics.settings.analytics_property_id') }}</label>
                <input data-counter="120" type="text" class="next-input" name="analytics_property_id" id="analytics_property_id"
                       value="{{ setting('analytics_property_id', config('analytics.view_id')) }}" placeholder="{{ trans('analytics::analytics.settings.analytics_property_id_description') }}">
            </div>
            @if (!DboardHelper::hasDemoModeEnabled())
                <div class="form-group mb-3">
                    <label class="text-title-field"
                           for="analytics_service_account_credentials">{{ trans('analytics::analytics.settings.json_credential') }}</label>
                    <textarea class="next-input form-control" name="analytics_service_account_credentials" id="analytics_service_account_credentials" rows="5" placeholder="{{ trans('analytics::analytics.settings.json_credential_description') }}">{{ setting('analytics_service_account_credentials') }}</textarea>
                </div>
            @endif
        </div>
    </div>
</div>
