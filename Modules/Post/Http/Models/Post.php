<?php

namespace Modules\Post\Http\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Modules\Branch\Http\Models\Branch;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Http\Models\Slug;
use Modules\KamrulDashboard\Http\Models\User;

class Post extends DboardModel
{
//    use RevisionableTrait;
    use HasFactory;
    protected $table = 'posts';


    protected $fillable = [
        'uuid',
        'name',
        'description',
        'content',
        'image',
        'is_featured',
        'format_type',
        'status',
        'user_id',

        'header_title',
        'icon_set',
        'check_design',
        'tag_line',
        'start_date',
        'set_time',
        'slug',
        'short_description',
        'document_file',
        'photo',
        'post_types_id',
        'designation',
    ];

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'post_categories');
    }
    protected function firstCategory(): Attribute
    {
        $self = $this;

        return new Attribute(function () use ($self) {
            $self->loadMissing('categories');

            return $self->categories->first();
        });
    }
    /**
     * @return BelongsToMany
     */
    public function branch(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'post_branches');
    }
    public function branch2()
    {
        return $this->belongsToMany(Branch::class, 'post_branches');
    }

    /**
     * @return BelongsToMany
     */
    public function PostGalleryParameter(): BelongsToMany
    {
        return $this->belongsToMany(PostGallery::class, 'post_gallery_parameters');
    }
    public function post_types()
    {
        return $this->belongsTo(PostType::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Post $post) {
            $post->categories()->detach();
        });
    }
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
