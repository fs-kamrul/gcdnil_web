<?php

namespace Modules\KamrulDashboard\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class DashboardWidget extends Model
{

    /**
     * @var string
     */
    protected $table = 'dashboard_widgets';

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @return hasMany
     */
    public function settings()
    {
        return $this->hasMany(DashboardWidgetSetting::class, 'widget_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (DashboardWidget $widget) {
            DashboardWidgetSetting::where('widget_id', $widget->id)->delete();
        });
    }
}
