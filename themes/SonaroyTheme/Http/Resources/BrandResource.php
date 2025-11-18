<?php

namespace Theme\HrdiTheme\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'website' => $this->website,
            'logo' => getImageUrlById($this->logo, 'shortcodes'),
        ];
    }
}
