<?php

namespace Modules\AdminBoard\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\AdminBoard\Enums\AdminNewsStatusEnum;
use Modules\KamrulDashboard\Casts\SafeContent;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Http\Models\User;

class AdminNews extends DboardModel
{
    use HasFactory;
    protected $table = 'admin_news';
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
        'short_description',
        'photo',
        'order',
        'slug',
        'status',
        'user_id',
    ];
    protected $casts = [
        'status' => AdminNewsStatusEnum::class,
        'name' => SafeContent::class,
    ];

    protected static function booted(): void
    {
        static::deleting(function (AdminNews $adminNews) {
            $adminNews->categories()->detach();
            $adminNews->metadata()->delete();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * @return BelongsToMany
     */
    public function AdminGalleryParameter(): BelongsToMany
    {
        return $this->belongsToMany(AdminGallery::class, 'admin_gallery_parameters', 'reference_id', 'gallery_id')
            ->wherePivot('reference_type', AdminNews::class);
    }
    public function admincategories(): BelongsToMany
    {
        return $this->belongsToMany(AdminCategory::class, 'admin_new_categories', 'news_id', 'category_id');
    }
    public function active()
    {
        return $this->where('status', 'active');
//        return rtrim(url($this->url), '/') == rtrim(Request::url(), '/');
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(AdminCategory::class, 'admin_new_categories', 'news_id', 'category_id');
    }
}
