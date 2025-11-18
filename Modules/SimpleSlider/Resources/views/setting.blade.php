<div class="flexbox-annotated-section">
    <div class="flexbox-annotated-section-annotation">
        <div class="annotated-section-title pd-all-20">
            <h2>{{ trans('simpleslider::simple-slider.settings.title') }}</h2>
        </div>
        <div class="annotated-section-description pd-all-20 p-none-t">
            <p class="color-note">{{ trans('simpleslider::simple-slider.settings.description') }}</p>
        </div>
    </div>

    <div class="flexbox-annotated-section-content">
        <div class="wrapper-content pd-all-20">
            <div class="form-group mb-3">
                <label class="text-title-field"
                       for="simple_slider_using_assets">{{ trans('simpleslider::simple-slider.settings.using_assets') }}
                </label>
                <label class="me-2">
                    <input type="radio" name="simple_slider_using_assets"
                           value="1"
                           @if (setting('simple_slider_using_assets', true)) checked @endif>{{ trans('kamruldashboard::setting.general.yes') }}
                </label>
                <label>
                    <input type="radio" name="simple_slider_using_assets"
                           value="0"
                           @if (!setting('simple_slider_using_assets', true)) checked @endif>{{ trans('kamruldashboard::setting.general.no') }}
                </label>
            </div>
            <div class="form-group mb-3">
                <p>{{ trans('simpleslider::simple-slider.settings.using_assets_description') }}</p>
                <pre><strong>
/vendor/Modules/SimpleSlider/lib/owl-carousel/owl.carousel.css
/vendor/Modules/SimpleSlider/css/simple-slider.css
/vendor/Modules/SimpleSlider/lib/owl-carousel/owl.carousel.js
/vendor/Modules/SimpleSlider/js/simple-slider.js
                </strong></pre>
            </div>
        </div>
    </div>
</div>
