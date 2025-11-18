<?php

namespace Modules\KamrulDashboard\Forms\FieldTypes;


use Modules\KamrulDashboard\Traits\Forms\CanSpanColumns;

class ButtonType extends \Kris\LaravelFormBuilder\Fields\ButtonType
{
    use CanSpanColumns;
}
