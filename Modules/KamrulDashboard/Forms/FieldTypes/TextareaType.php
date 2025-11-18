<?php

namespace Modules\KamrulDashboard\Forms\FieldTypes;

use Modules\KamrulDashboard\Traits\Forms\CanSpanColumns;

class TextareaType extends \Kris\LaravelFormBuilder\Fields\TextareaType
{
    use CanSpanColumns;
}
