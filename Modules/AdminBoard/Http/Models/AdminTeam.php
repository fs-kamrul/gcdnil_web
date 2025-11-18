<?php

namespace Modules\AdminBoard\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\AdminBoard\Enums\AdminTeamStatusEnum;
use Modules\KamrulDashboard\Casts\SafeContent;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Http\Models\User;

class AdminTeam extends DboardModel
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
        'photo',
        'phone',
        'designation',
        'email',
        'father_name',
        'mother_name',
        'dob',
        'office_address',
        'index_no',
        'facebook_id',
        'google_site',
        'linkedin_id',
        'order',
        'slug',
        'status',
        'user_id',
    ];
    protected $casts = [
        'status' => AdminTeamStatusEnum::class,
        'name' => SafeContent::class,
    ];

    protected static function booted(): void
    {
        static::deleting(function (AdminTeam $project) {
            $project->categories()->detach();
            $project->admin_educations()->detach();
            $project->metadata()->delete();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function AdminGalleryParameter(): BelongsToMany
    {
        return $this->belongsToMany(AdminGallery::class, 'admin_gallery_parameters', 'reference_id', 'gallery_id')
            ->wherePivot('reference_type', AdminTeam::class);
    }
    public function active()
    {
        return $this->where('status', 'active');
//        return rtrim(url($this->url), '/') == rtrim(Request::url(), '/');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(AdminCategory::class, 'admin_team_categories', 'team_id', 'category_id');
    }

    public function admin_educations(): MorphToMany
    {
        return $this->morphToMany(AdminEducation::class, 'reference', 'admin_educations_names','educations_id','reference_id')->withPivot('name_title');
    }
}
