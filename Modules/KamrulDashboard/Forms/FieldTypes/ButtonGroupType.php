<?php

namespace Modules\KamrulDashboard\Forms\FieldTypes;


use Modules\KamrulDashboard\Traits\Forms\CanSpanColumns;

class ButtonGroupType extends \Kris\LaravelFormBuilder\Fields\ButtonGroupType
{
    use CanSpanColumns;
}
