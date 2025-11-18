<?php

namespace Modules\AdminBoard\Forms\Fields;


use Modules\KamrulDashboard\Forms\FormField;

class CategoryMultiField extends FormField
{
    protected function getTemplate(): string
    {
        return 'adminboard::categories.categories-multi';
    }
}
