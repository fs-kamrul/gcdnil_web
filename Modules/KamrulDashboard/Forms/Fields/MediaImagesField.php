<?php

namespace Modules\KamrulDashboard\Forms\Fields;

use Assets;
use Kris\LaravelFormBuilder\Fields\FormField;

class MediaImagesField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        Assets::addScripts(['jquery-ui']);

        return 'kamruldashboard::forms.fields.media-images';
    }
}
