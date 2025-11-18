<?php

namespace Modules\KamrulDashboard\Forms\FieldTypes;

use Modules\KamrulDashboard\Traits\Forms\CanSpanColumns;

class CollectionType extends \Kris\LaravelFormBuilder\Fields\CollectionType
{
    use CanSpanColumns;
}
