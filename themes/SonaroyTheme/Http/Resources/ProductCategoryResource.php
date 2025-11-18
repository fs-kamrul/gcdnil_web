<?php

namespace Theme\HrdiTheme\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'image' => getImageUrlById($this->image, 'product-files'),
            'thumbnail' => getImageUrlById($this->image, 'product-files'),
        ];
    }
}
