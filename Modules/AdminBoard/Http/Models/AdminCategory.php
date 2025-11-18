<?php

namespace Modules\AdminBoard\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\HtmlString;
use Modules\AdminBoard\Enums\AdminCategoryStatusEnum;
use Modules\KamrulDashboard\Casts\SafeContent;
use Modules\KamrulDashboard\Contracts\HasTreeCategory as HasTreeCategoryContract;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Http\Models\User;
use Modules\KamrulDashboard\Traits\HasTreeCategory;
use DboardHelper;

class AdminCategory extends DboardModel implements HasTreeCategoryContract
{
    use HasTreeCategory;
    use HasFactory;
    protected $table = 'admin_categories';
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
        'name',
        'description',
        'status',
        'adminboard',
        'order',
        'is_default',
        'parent_id',
        'user_id',
    ];
    protected $casts = [
        'status' => AdminCategoryStatusEnum::class,
        'name' => SafeContent::class,
        'description' => SafeContent::class,
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
//    public function AdminGalleryParameter(): BelongsToMany
//    {
//        return $this->belongsToMany(AdminGallery::class, 'admin_gallery_parameters', 'reference_id', 'gallery_id')
//            ->wherePivot('reference_type', AdminCategory::class);
//    }
//    public function active()
//    {
//        return $this->where('status', 'published');
////        return rtrim(url($this->url), '/') == rtrim(Request::url(), '/');
//    }

    public function adminworkshops(): BelongsToMany
    {
        return $this->belongsToMany(AdminWorkshop::class, 'admin_workshop_categories','category_id', 'workshop_id')->with('slugable');
    }
    public function adminnews(): BelongsToMany
    {
        return $this->belongsToMany(AdminNews::class, 'admin_new_categories','category_id', 'news_id')->with('slugable');
    }
    public function adminnoticeboards(): BelongsToMany
    {
        return $this->belongsToMany(AdminNoticeBoard::class, 'admin_notice_board_categories','category_id', 'notice_board_id')->with('slugable');
    }

    public function adminevents(): BelongsToMany
    {
        return $this->belongsToMany(AdminEvent::class, 'admin_event_categories','category_id', 'event_id')->with('slugable');
    }

    public function adminteams(): BelongsToMany
    {
        return $this->belongsToMany(AdminTeam::class, 'admin_team_categories','category_id', 'team_id')->with('slugable');
    }


    public function parent(): BelongsTo
    {
        return $this->belongsTo(AdminCategory::class, 'parent_id')->withDefault();
    }

    public function children(): HasMany
    {
        return $this->hasMany(AdminCategory::class, 'parent_id');
    }

    protected function badgeWithCount(): Attribute
    {
        return Attribute::get(function (): HtmlString {
            $html = '';

            if ($this->is_default) {
                $html .= sprintf(
                    '<span class="text-success" data-bs-toggle="tooltip" title="%s">%s</span>',
                    trans('adminboard::category.is_default'),
                    DboardHelper::renderIcon('ti ti-check', 'sm')
                );
            }

//            dd( $this->adminworkshops);
            $html .= DboardHelper::renderBadge(
                $this->adminworkshops_count,
                'info',
                [
                    'data-bs-toggle' => 'tooltip',
                    'title' => trans('adminboard::category.total_workshops', ['total' => $this->adminworkshops_count]),
                ]
            );

//            dd( $this->adminnews_count);
            $count = $this->adminnews_count;
            $html .= DboardHelper::renderBadge(
                $count,
                'primary',
                [
                    'data-bs-toggle' => 'tooltip',
                    'title' => trans('adminboard::category.total_news', ['total' => $count]),
                ]
            );
//            dd($this->adminteams_count);
            $teams_count = $this->adminteams_count;
            $html .= DboardHelper::renderBadge(
                $teams_count,
                'warning',
                [
                    'data-bs-toggle' => 'tooltip',
                    'title' => trans('adminboard::category.total_teams', ['total' => $teams_count]),
                ]
            );
            $adminnoticeboards_count = $this->adminnoticeboards_count;
            $html .= DboardHelper::renderBadge(
                $adminnoticeboards_count,
                'success',
                [
                    'data-bs-toggle' => 'tooltip',
                    'title' => trans('adminboard::category.total_notice_boards', ['total' => $adminnoticeboards_count]),
                ]
            );

            $adminevents_count = $this->adminevents_count;
            $html .= DboardHelper::renderBadge(
                $adminevents_count,
                'danger',
                [
                    'data-bs-toggle' => 'tooltip',
                    'title' => trans('adminboard::category.total_events', ['total' => $adminevents_count]),
                ]
            );

            return new HtmlString($html);
        });
    }

    protected static function booted(): void
    {
        self::deleting(function (AdminCategory $category) {
            foreach ($category->children()->get() as $child) {
                $child->parent_id = $category->parent_id;
                $child->save();
            }

            $category->adminworkshops()->detach();
            $category->adminnews()->detach();
            $category->adminevents()->detach();
            $category->adminteams()->detach();
        });
    }
}
