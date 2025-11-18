<?php

namespace Modules\KamrulDashboard\Packages\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BadgeComponent extends Component
{
    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $color;

    /**
     * @var string|null
     */
    public $icon;

    /**
     * BadgeComponent constructor.
     *
     * @param string $label
     * @param string $color
     * @param string|null $icon
     */
    public function __construct(string $label, string $color = 'primary', ?string $icon = null)
    {
        $this->label = $label;
        $this->color = $color;
        $this->icon = $icon;
    }
    /**
     * Render the view.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('kamruldashboard::components.badge',[
            'label' => $this->label,
            'color' => $this->color,
            'icon' => $this->icon,
        ]);
    }

}
