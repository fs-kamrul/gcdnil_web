<?php

namespace Modules\KamrulDashboard\Forms\FieldTypes;


use Modules\KamrulDashboard\Traits\Forms\CanSpanColumns;

class ChildFormType extends \Kris\LaravelFormBuilder\Fields\ChildFormType
{
    use CanSpanColumns;
}
