<?php

namespace Modules\Menus\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Request;

class MenusNode extends DboardModel
{
    use HasFactory;
    protected $guarded = [];

    /**
     * @var array
     */
    protected $fillable = [
        'menus_id',
        'parent_id',
        'sort',
        'depth',
        'reference_id',
        'reference_type',
        'url',
        'icon_font',
        'position',
        'title',
        'css_class',
        'target',
        'has_child',
    ];
//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }

    public static function getNextSortRoot($menus)
    {
        return self::where('menus_id', $menus)->max('sort') + 1;
    }

    /**
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(MenusNode::class, 'parent_id');
    }
    public function parent_menu()
    {
        return $this->belongsTo(Menus::class, 'menus_id');
    }
    /**
     * @return HasMany
     */
    public function child()
    {
        return $this->hasMany(MenusNode::class, 'parent_id')->orderBy('sort', 'ASC');
    }
    /**
     * @param string $value
     * @return string
     */
    public function getUrlAttribute($value)
    {
        if ($value) {
            return apply_filters(MENU_FILTER_NODE_URL, $value);
        }

        if (!$this->reference_type) {
            return $value ? (string)$value : '/';
        }

        if (!$this->reference) {
            return '/';
        }

        return (string)$this->reference->url;
    }
    /**
     * @param string $value
     */
    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = $value;
    }
    /**
     * @param string $value
     * @return string
     */
    public function getTitleAttribute($value)
    {
        if ($value) {
            return $value;
        }

        if (!$this->reference_type || !$this->reference) {
            return $value;
        }

        return $this->reference->name;
    }
    /**
     * @return bool
     */
    public function getActiveAttribute()
    {
        return rtrim(url($this->url), '/') == rtrim(Request::url(), '/');
    }
    /**
     * @return mixed
     * @deprecated
     */
    public function hasChild()
    {
        return $this->has_child;
    }

    /**
     * @return $this
     * @deprecated
     */
    public function getRelated()
    {
        return $this;
    }

    /**
     * @return mixed
     * @deprecated
     */
    public function getNameAttribute()
    {
        return $this->title;
    }
}
