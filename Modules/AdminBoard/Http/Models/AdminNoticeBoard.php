<?php

namespace Modules\AdminBoard\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\AdminBoard\Enums\AdminNoticeBoardStatusEnum;
use Modules\KamrulDashboard\Casts\SafeContent;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Http\Models\User;

class AdminNoticeBoard extends DboardModel
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
        'short_description',
        'document',
        'photo',
        'order',
        'slug',
        'status',
        'user_id',
    ];
    protected $casts = [
        'status' => AdminNoticeBoardStatusEnum::class,
        'name' => SafeContent::class,
    ];
    protected static function booted(): void
    {
        static::deleting(function (AdminNoticeBoard $notice_board) {
            $notice_board->categories()->detach();
            $notice_board->metadata()->delete();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function AdminGalleryParameter(): BelongsToMany
    {
        return $this->belongsToMany(AdminGallery::class, 'admin_gallery_parameters', 'reference_id', 'gallery_id')
            ->wherePivot('reference_type', AdminNoticeBoard::class);
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(AdminCategory::class, 'admin_notice_board_categories', 'notice_board_id', 'category_id');
    }
    public function active()
    {
        return $this->where('status', 'active');
//        return rtrim(url($this->url), '/') == rtrim(Request::url(), '/');
    }
}
