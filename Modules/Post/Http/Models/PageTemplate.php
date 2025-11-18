<?php

namespace Modules\Post\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Http\Models\User;

class PageTemplate extends DboardModel
{
    use HasFactory;
    protected $guarded = [];

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'description',
        'slug',
        'status',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function page()
    {
        return $this->hasMany(Page::class,'page_templates_id');
    }
    public function createSlug($name)
    {
        $slug = Str::slug($name);
        $index = 1;
        $baseSlug = $slug;
        while ($this->where('slug', $slug)->count() > 0) {
            $slug = $baseSlug . '-' . $index++;
        }
        if (empty($slug)) {
            $slug = time();
        }
        return $slug;
    }
}
