<?php

namespace Modules\AdminBoard\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Http\Models\User;

class AdminGallery extends DboardModel
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
