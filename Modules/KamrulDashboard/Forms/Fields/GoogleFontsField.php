<?php

namespace Modules\KamrulDashboard\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\SelectType;

class GoogleFontsField extends SelectType
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        return 'kamruldashboard::forms.fields.google-fonts';
    }
}
