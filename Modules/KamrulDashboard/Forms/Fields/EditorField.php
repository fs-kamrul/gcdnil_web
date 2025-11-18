<?php

namespace Modules\KamrulDashboard\Forms\Fields;

use Assets;
use Illuminate\Support\Arr;
use Modules\KamrulDashboard\Forms\FormField;


class EditorField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        Assets::addScriptsDirectly('vendor/Modules/KamrulDashboard/js/ckeditor/editor.js');

        return 'kamruldashboard::forms.fields.editor';
    }

    /**
     *{@inheritDoc}
     */
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $options['with-short-code'] = Arr::get($options, 'with-short-code', false);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
