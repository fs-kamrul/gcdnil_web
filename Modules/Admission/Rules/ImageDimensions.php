<?php

namespace Modules\Admission\Rules;

use Illuminate\Contracts\Validation\Rule;
use Intervention\Image\Facades\Image;

class ImageDimensions implements Rule
{
    protected $maxWidth;
    protected $maxHeight;

    public function __construct($maxWidth, $maxHeight)
    {
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
    }

    public function passes($attribute, $value)
    {
        $image = Image::make($value);
        $width = $image->width();
        $height = $image->height();

        return $width <= $this->maxWidth && $height <= $this->maxHeight;
    }

    public function message()
    {
        return "The image dimensions must be less than or equal to {$this->maxWidth}x{$this->maxHeight} pixels.";
    }
}
