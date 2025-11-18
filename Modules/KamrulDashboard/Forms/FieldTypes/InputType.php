<?php

namespace Modules\KamrulDashboard\Forms\FieldTypes;

use Modules\KamrulDashboard\Traits\Forms\CanSpanColumns;

class InputType extends \Kris\LaravelFormBuilder\Fields\InputType
{
    use CanSpanColumns;
}
