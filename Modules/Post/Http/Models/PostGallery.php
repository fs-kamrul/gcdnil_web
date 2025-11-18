<?php

namespace Modules\Post\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Http\Models\User;

class PostGallery extends DboardModel
{
    use HasFactory;
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
