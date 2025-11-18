<?php

namespace Modules\KamrulDashboard\Forms\FieldTypes;


use Modules\KamrulDashboard\Traits\Forms\CanSpanColumns;

class ChoiceType extends \Kris\LaravelFormBuilder\Fields\ChoiceType
{
    use CanSpanColumns;
}
