<?php

namespace Modules\KamrulDashboard\Packages\dboard;

use Countable;
use Illuminate\Contracts\Config\Repository;
use Illuminate\View\Factory as ViewFactory;

class DboardBuilder implements Countable
{
    /**
     * Menu name.
     *
     * @var string
     */
    protected $menu;

    /**
     * Array menu items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Default presenter class.
     *
     * @var string
     */
    protected $presenter = \Modules\KamrulDashboard\Http\DashboardSidebarCustom::class;

    /**
     * Style name for each presenter.
     *
     * @var array
     */
    protected $styles = [];

    /**
     * Prefix URL.
     *
     * @var string|null
     */
    protected $prefixUrl;

    /**
     * The name of view presenter.
     *
     * @var string
     */
    protected $view;

    /**
     * The laravel view factory instance.
     *
     * @var \Illuminate\View\Factory
     */
    protected $views;

    /**
     * Determine whether the ordering feature is enabled or not.
     *
     * @var boolean
     */
    protected $ordering = false;

    /**
     * Resolved item binding map.
     *
     * @var array
     */
    protected $bindings = [];
    /**
     * @var Repository
     */
    private $config;

    /**
     * Constructor.
     *
     * @param string $menu
     * @param Repository $config
     */
    public function __construct($menu, Repository $config)
    {
        $this->menu = $menu;
        $this->config = $config;
    }
    /**
     * Set view factory instance.
     *
     * @param ViewFactory $views
     *
     * @return $this
     */
    public function setViewFactory(ViewFactory $views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Add new header item.
     *
     * @return \Nwidart\Menus\MenuItem
     */
    public function addHeader($title, $values = 0, $order = null)
    {
        $this->items[] = array(
            'name' => 'header',
            'title' => $title,
            'values' => $values,
            'order' => $order,
        );

        return $this;
    }

    /**
     * Get menu name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->menu;
    }
    /**
     * Alias for "addHeader" method.
     *
     * @param string $title
     *
     * @return $this
     */
    public function header($title, $values)
    {
        return $this->addHeader($title, $values);
    }
    /**
     * Set the resolved item bindings
     *
     * @param array $bindings
     * @return $this
     */
    public function setBindings(array $bindings)
    {
        $this->bindings = $bindings;

        return $this;
    }

    /**
     * Render the menu to HTML tag.
     *
     * @param string $presenter
     *
     * @return string
     */
    public function render($presenter = null)
    {
//        $this->resolveItems($this->items);
//
//        if (!is_null($this->view)) {
//            return $this->renderView($presenter);
//        }
//
//        if ($this->hasStyle($presenter)) {
//            $this->setPresenterFromStyle($presenter);
//        }
//
//        if (!is_null($presenter) && !$this->hasStyle($presenter)) {
//            $this->setPresenter($presenter);
//        }
//
        return $this->renderMenu();

//        return $presenter;
    }
    /**
     * Get presenter instance.
     *
     */
    public function getPresenter()
    {
        return new $this->presenter();
    }

    /**
     * Get menu items and order it by 'order' key.
     *
     * @return array
     */
    public function getOrderedItems()
    {
//        if (config('menus.ordering') || $this->ordering) {
//            return $this->toCollection()->sortBy(function ($item) {
//                return $item->order;
//            })->all();
//        }

        return $this->items;
    }
    /**
     * Render the menu.
     *
     * @return string
     */
    protected function renderMenu()
    {
        $presenter = $this->getPresenter();
        $menu = $presenter->getOpenTagWrapper();

//        return $this->getOrderedItems();
        foreach ($this->getOrderedItems() as $item) {
//            return (object)$item;
//            if ($item->hidden()) {
//                continue;
//            }
//
//            if ($item->hasSubMenu()) {
//                $menu .= $presenter->getMenuWithDropDownWrapper($item);
//            } elseif ($item->isHeader()) {
                $menu .= $presenter->getHeaderWrapper((object)$item);
//            } elseif ($item->isDivider()) {
//                $menu .= $presenter->getDividerWrapper();
//            } else {
//                $menu .= $presenter->getMenuWithoutDropdownWrapper($item);
//            }
        }

        $menu .= $presenter->getCloseTagWrapper();

        return $menu;
    }
    /**
     * Get items count.
     *
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Empty the current menu items.
     */
    public function destroy()
    {
        $this->items = array();

        return $this;
    }

}
