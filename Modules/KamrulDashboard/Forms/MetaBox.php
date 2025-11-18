<?php

namespace Modules\KamrulDashboard\Forms;

use Closure;
use Illuminate\Contracts\Support\Arrayable;

class MetaBox implements Arrayable
{
    protected $title;

    protected $subtitle = null;

    protected $beforeWrapper = null;

    protected $afterWrapper = null;

    protected $hasWrapper = true;

    protected $hasTable = false;

    protected $content;

    protected $headerActionContent = null;

    protected $footerContent = null;

    protected $attributes = [];

    public function __construct(string $id)
    {
    }

    public static function make(string $id)
    {
        return new static($id);
    }

    public function title(string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function subtitle(string $subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function beforeWrapper(string $beforeWrapper)
    {
        $this->beforeWrapper = $beforeWrapper;

        return $this;
    }

    public function afterWrapper(string $afterWrapper)
    {
        $this->afterWrapper = $afterWrapper;

        return $this;
    }

    public function hasWrapper(bool $hasWrapper = true)
    {
        $this->hasWrapper = $hasWrapper;

        return $this;
    }

    public function hasTable(bool $hasTable = true)
    {
        $this->hasTable = $hasTable;

        return $this;
    }

    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    public function headerActionContent(string $headerActionContent)
    {
        $this->headerActionContent = $headerActionContent;

        return $this;
    }

    public function footerContent(?string $footerContent)
    {
        $this->footerContent = $footerContent;

        return $this;
    }

    public function attributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'before_wrapper' => $this->beforeWrapper,
            'after_wrapper' => $this->afterWrapper,
            'wrap' => $this->hasWrapper,
            'has_table' => $this->hasTable,
            'content' => $this->content,
            'header_actions' => $this->headerActionContent,
            'footer' => $this->footerContent,
            'attributes' => $this->attributes,
        ];
    }
}
