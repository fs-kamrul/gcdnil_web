<?php

namespace Modules\KamrulDashboard\Forms\FieldTypes;

use Modules\KamrulDashboard\Traits\Forms\CanSpanColumns;

abstract class ParentType extends \Kris\LaravelFormBuilder\Fields\ParentType
{
    use CanSpanColumns;
}
