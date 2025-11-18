<?php

namespace Modules\KamrulDashboard\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Modules\KamrulDashboard\Http\Models\Slug;

class UpdatedSlugEvent extends Event
{
    use SerializesModels;

    /**
     * @var Model|false
     */
    public $data;

    /**
     * @var Slug
     */
    public $slug;

    /**
     * UpdatedSlugEvent constructor.
     * @param Model $data
     * @param Slug $slug
     */
    public function __construct($data, Slug $slug)
    {
        $this->data = $data;
        $this->slug = $slug;
    }
}
