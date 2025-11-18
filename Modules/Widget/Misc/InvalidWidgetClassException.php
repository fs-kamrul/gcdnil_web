<?php

namespace Modules\Widget\Misc;

use Exception;
use Modules\Widget\Packages\Supports\AbstractWidget;

class InvalidWidgetClassException extends Exception
{
    /**
     * Exception message.
     *
     * @var string
     */
    protected $message = 'Widget class must extend class ' . AbstractWidget::class;
}
