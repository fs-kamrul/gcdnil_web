<div class="flexbox-annotated-section">
    <div class="flexbox-annotated-section-annotation">
        <div class="annotated-section-title pd-all-20">
            <h2>{{ trans('admission::lang.settings.title') }}</h2>
        </div>
        <div class="annotated-section-description pd-all-20 p-none-t">
            <p class="color-note">{{ trans('admission::lang.settings.description') }}</p>
        </div>
    </div>

    <div class="flexbox-annotated-section-content">
        <div class="wrapper-content pd-all-20">
            <div class="form-group mb-3">
                <label class="text-title-field"
                       for="principal_name">{{ trans('admission::lang.settings.principal_name') }}</label>
                <input data-counter="120" type="text" class="next-input" name="principal_name" id="principal_name"
                       value="{{ setting('principal_name') }}" placeholder="{{ trans('admission::lang.settings.principal_name') }}">
            </div>
        </div>
    </div>
</div>
