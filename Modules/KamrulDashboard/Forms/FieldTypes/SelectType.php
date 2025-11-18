<?php

namespace Modules\KamrulDashboard\Forms\FieldTypes;

use Modules\KamrulDashboard\Traits\Forms\CanSpanColumns;

class SelectType extends \Kris\LaravelFormBuilder\Fields\SelectType
{
    use CanSpanColumns;
}
