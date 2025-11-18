<?php

namespace Modules\KamrulDashboard\Forms\Fields;

use Assets;
use Kris\LaravelFormBuilder\Fields\FormField;

class PermalinkField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        Assets::addScripts(['slug'])
            ->addStyles(['slug']);

        return 'kamruldashboard::forms.fields.permalink';
    }
}
