<?php

namespace Modules\KamrulDashboard\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\KamrulDashboard\Forms\FormAbstract;

class FormRendering
{
    use Dispatchable;

    public function __construct(FormAbstract $form)
    {
    }
}
