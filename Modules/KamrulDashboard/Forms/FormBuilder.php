<?php

namespace Modules\KamrulDashboard\Forms;

use Kris\LaravelFormBuilder\FormBuilder as DboardFormBuilder;

class FormBuilder extends DboardFormBuilder
{
    /**
     * {@inheritDoc}
     */
    public function create($formClass, array $options = [], array $data = [])
    {
        $form = parent::create($formClass, $options, $data);
        return apply_filters(BASE_FILTER_AFTER_FORM_CREATED, $form, $form->getModel());
    }
}
