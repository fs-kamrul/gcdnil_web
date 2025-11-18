<?php

namespace Modules\KamrulDashboard\Forms\Fields;

use Assets;
use Kris\LaravelFormBuilder\Fields\FormField;

class TagField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        Assets::addStylesDirectly('vendor/Modules/KamrulDashboard/vendor2/tagify/tagify.css')
            ->addScriptsDirectly([
                'vendor/Modules/KamrulDashboard/vendor2/tagify/tagify.js',
                'vendor/Modules/KamrulDashboard/js/ckeditor/tags.js',
            ]);

        return 'kamruldashboard::forms.fields.tags';
    }
}
