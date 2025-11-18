<?php

namespace Modules\Analytics\Exceptions;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class InvalidConfiguration extends Exception
{
    public static function propertyIdNotSpecified(): self
    {
        return new self(trans('analytics::analytics.property_id_not_specified'));
    }
    /**
     * @return static
     * @throws FileNotFoundException
     */
    public static function credentialsIsNotValid(): self
    {
        return new self(trans('analytics::analytics.credential_is_not_valid'));
    }

    public static function invalidPropertyId(): self
    {
        return new self(trans('analytics::analytics.property_id_is_invalid'));
    }
    /**
     * @return static
     * @throws FileNotFoundException
     */
    public static function viewIdNotSpecified()
    {
        return new static(trans('analytics::lang.view_id_not_specified'));
    }
}
