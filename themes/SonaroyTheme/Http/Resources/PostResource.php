<?php

namespace Theme\HrdiTheme\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Post\Http\Models\Category;
use Modules\Post\Http\Resources\CategoryResource;

class PostResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'description' => $this->description,
            'image' => $this->image ? getImageUrlById($this->image, 'shortcodes') : null,
            'category' => $this->categories->count() > 0 ? new CategoryResource($this->categories->first()) : new CategoryResource(new Category()),
            'created_at' => $this->created_at->translatedFormat('M d, Y'),
            'views' => number_format($this->views),
        ];
    }
}
