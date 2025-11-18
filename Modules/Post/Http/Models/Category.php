<?php

namespace Modules\Post\Http\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Http\Models\Slug;
use Modules\KamrulDashboard\Http\Models\User;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;

class Category extends DboardModel
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
        'parent_id',
        'order',
        'photo',
        'status',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function post(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_categories')->with('slugable');
//        return $this->belongsToMany(Post::class, 'categories')->with('slugable');
//        return $this->belongsToMany(Post::class, 'post_categories');
    }

    /**
     * @return BelongsToMany
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_categories')->with('slugable');
    }
    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id')->withDefault();
    }
    /**
     * @return Collection
     */
    public function getParentsAttribute(): Collection
    {
        $parents = collect([]);

        $parent = $this->parent;

        while($parent->id) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }
    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    protected function parents(): Attribute
    {
        $self = $this;

        return new Attribute(function () use ($self) {
            $parents = collect();

            $parent = $self->parent;

            while ($parent->id) {
                $parents->push($parent);
                $parent = $parent->parent;
            }

            return $parents;
        });
    }
    /**
     * @return array
     */
    public function getChildrenIds($category, $childrenIds = []): array
    {
        $children = $category->children()->select('id')->get();

        foreach ($children as $child) {
            $childrenIds[] = $child->id;

            $childrenIds = array_merge($childrenIds, $this->getChildrenIds($child, $childrenIds));
        }

        return array_unique($childrenIds);
    }
    public function activeChildren(): HasMany
    {
        return $this
            ->children()
            ->where('status', DboardStatus::PUBLISHED)
            ->with(['slugable', 'activeChildren']);
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (Category $category) {
            foreach ($category->children()->get() as $child) {
                $child->delete();
            }

            $category->posts()->detach();
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
