<?php

namespace Modules\Post\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Modules\KamrulDashboard\Casts\SafeContent;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Http\Models\Slug;
use Modules\KamrulDashboard\Http\Models\User;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;

class Page extends DboardModel
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
     * @var array
     */
    protected $casts = [
        'status' => DboardStatus::class,
        'content' => SafeContent::class,
        'name' => SafeContent::class,
        'description' => SafeContent::class,
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
        'short_description',
        'photo',
        'slug',
        'page_templates_id',
        'status',
        'user_id',
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function page_templates()
    {
        return $this->belongsTo(PageTemplate::class);
    }
//    public function slugable()
//    {
//        return $this->morphOne(Slug::class, 'reference');
//    }
    public function createSlug($name)
    {
        $slug = Str::slug($name);
        $index = 1;
        $baseSlug = $slug;
        while (Slug::where('key', $slug)->count() > 0) {
            $slug = $baseSlug . '-' . $index++;
        }
        if (empty($slug)) {
            $slug = time();
        }
        return $slug;
    }
}
