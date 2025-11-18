<?php

namespace Modules\Menus\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\KamrulDashboard\Casts\SafeContent;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Http\Models\User;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;

class Menus extends DboardModel
{
    use HasFactory;
//    protected $table = 'menus';

    protected $guarded = [];


    /**
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'status',
    ];
    protected $casts = [
        'status' => DboardStatus::class,
        'name' => SafeContent::class,
    ];
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Menus $menus) {
            MenusNode::where('menus_id', $menus->id)->delete();
        });
    }
    /**
     * @return HasMany
     */
    public function menuNodes()
    {
        return $this->hasMany(MenusNode::class, 'menus_id');
    }

//    /**
//     * @return BelongsToMany
//     */
//    public function categories(): BelongsToMany
//    {
//        return $this->belongsToMany(Category::class, 'post_categories');
//    }
    /**
     * @return HasMany
     */
    public function locations()
    {
        return $this->hasMany(MenusLocation::class, 'menus_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
