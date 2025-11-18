<?php

namespace Modules\Admission\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Admission\Packages\Support\Admissionoption;

/**
 * @see Location
 */
class AdmissionoptionFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Admissionoption::class;
    }
}
