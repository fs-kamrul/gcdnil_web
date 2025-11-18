<?php

namespace Modules\Post\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\KamrulDashboard\Http\Models\DboardModel;

class PostGalleryParameter extends DboardModel
{
    use HasFactory;
    protected $guarded = [];

    public function PostGallery()
    {
        return $this->belongsTo(PostGallery::class);
    }
}
