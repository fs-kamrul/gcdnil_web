<?php

namespace Modules\KamrulDashboard\Forms\Fields;

use Assets;
use Kris\LaravelFormBuilder\Fields\FormField;

class ColorField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        Assets::addScripts(['colorpicker'])
            ->addStyles(['colorpicker']);

        return 'kamruldashboard::forms.fields.color';
    }
}
