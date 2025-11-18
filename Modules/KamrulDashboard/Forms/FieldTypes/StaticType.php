<?php

namespace Modules\KamrulDashboard\Forms\FieldTypes;

use Modules\KamrulDashboard\Traits\Forms\CanSpanColumns;

class StaticType extends \Kris\LaravelFormBuilder\Fields\StaticType
{
    use CanSpanColumns;
}
