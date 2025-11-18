<?php

namespace Modules\AdminBoard\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\KamrulDashboard\Http\Models\DboardModel;

class AdminGalleryParameter extends DboardModel
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    public function AdminGallery()
    {
        return $this->belongsTo(AdminGallery::class, 'gallery_id');
    }
}
