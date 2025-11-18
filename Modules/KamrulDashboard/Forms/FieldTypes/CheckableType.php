<?php

namespace Modules\KamrulDashboard\Forms\FieldTypes;


use Modules\KamrulDashboard\Traits\Forms\CanSpanColumns;

class CheckableType extends \Kris\LaravelFormBuilder\Fields\CheckableType
{
    use CanSpanColumns;
}
