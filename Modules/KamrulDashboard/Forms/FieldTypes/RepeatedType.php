<?php

namespace Modules\KamrulDashboard\Forms\FieldTypes;

use Modules\KamrulDashboard\Traits\Forms\CanSpanColumns;

class RepeatedType extends \Kris\LaravelFormBuilder\Fields\RepeatedType
{
    use CanSpanColumns;
}
