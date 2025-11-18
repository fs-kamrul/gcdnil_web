<?php

namespace Modules\KamrulDashboard\Traits\Forms;


use Modules\KamrulDashboard\Forms\FormCollapse;

trait HasCollapsible
{
    public function addCollapsible(FormCollapse $form)
    {
        $form->build($this);

        return $this;
    }
}
