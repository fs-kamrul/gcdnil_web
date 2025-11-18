<?php

namespace Modules\Theme\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
//use Theme;
use Form;

class FormServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     */
    public function boot()
    {
        Form::macro('seoImage', function ($name, $value = null, $attributes = []) {
            $data = '';
            $data .= '<div class="form-group">
                        <input name="' . $name . '" type="hidden" id="' . $name . '_image" value="' . $value . '" class="form-control" />
                        <label class="control-label"><?php echo __(\'Image\'); ?></label>
                        <div id="' . $name . '" class="dropzone">
                            <div class="dz-default dz-message">
                                <h3 class="sbold">' . __('Drop files here to upload') . '</h3>
                                <span>' . __('You can also click to open file browser') . '</span><br/>
                                <span class="note needsclick">' . __('theme::lang.upload_file_image') . '</span>
                            </div>
                        </div>
                    </div>';

            return $data;
        });

        Form::macro('faviconImage', function ($name, $value = null, $attributes = []) {
            $data = '';
            $data .= '<div class="form-group">
                        <input name="' . $name . '" type="hidden" id="' . $name . '_image" value="' . $value . '" class="form-control" />
                        <label class="control-label"><?php echo __(\'Image\'); ?></label>
                        <div id="' . $name . '" class="dropzone">
                            <div class="dz-default dz-message">
                                <h3 class="sbold">' . __('Drop files here to upload') . '</h3>
                                <span>' . __('You can also click to open file browser') . '</span><br/>
                                <span class="note needsclick">' . __('theme::lang.upload_file_image') . '</span>
                            </div>
                        </div>
                    </div>';

            return $data;
        });
        Form::macro('logoImage', function ($name, $value = null, $attributes = []) {
            $data = '';
            $data .= '<div class="form-group">
                        <input name="' . $name . '" type="hidden" id="' . $name . '_image" value="' . $value . '" class="form-control" />
                        <label class="control-label"><?php echo __(\'Image\'); ?></label>
                        <div id="' . $name . '" class="dropzone">
                            <div class="dz-default dz-message">
                                <h3 class="sbold">' . __('Drop files here to upload') . '</h3>
                                <span>' . __('You can also click to open file browser') . '</span><br/>
                                <span class="note needsclick">' . __('theme::lang.upload_file_image') . '</span>
                            </div>
                        </div>
                    </div>';

            return $data;
        });
        Form::macro('customColor', function ($name, $value = null, $attributes = []) {
            $data = '';
            $data .= '<div class="form-group">
                        <input type="text" name="' . $name . '" class="as_colorpicker form-control" value="'. $value . '">
                    </div>';

            return $data;
        });
    }
}
