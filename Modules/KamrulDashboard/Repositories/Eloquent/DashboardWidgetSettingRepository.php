<?php

namespace Modules\KamrulDashboard\Repositories\Eloquent;

use Illuminate\Support\Facades\Auth;
use Modules\KamrulDashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;

class DashboardWidgetSettingRepository extends RepositoriesAbstract implements DashboardWidgetSettingInterface
{
    /**
     * {@inheritDoc}
     */
    public function getListWidget()
    {
        $data = $this->model
            ->select([
                'id',
                'order',
                'settings',
                'widget_id',
            ])
            ->with('widget')
            ->orderBy('order')
            ->where('user_id', Auth::id())
            ->get();

        $this->resetModel();

        return $data;
    }
}
