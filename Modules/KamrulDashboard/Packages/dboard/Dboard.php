<?php

namespace Modules\KamrulDashboard\Packages\dboard;

use Closure;
use Countable;
use Illuminate\Contracts\Config\Repository;
use Illuminate\View\Factory;

class Dboard implements Countable
{
    /**
     * The menus collections.
     *
     * @var array
     */
    protected $menus = array();
    /**
     * @var Repository
     */
    private $config;
    /**
     * @var Factory
     */
    private $views;

    /**
     * The constructor.
     *
     * @param Factory    $views
     * @param Repository $config
     */
    public function __construct(Factory $views, Repository $config)
    {
//        $this->menus = $menus;
        $this->views = $views;
        $this->config = $config;
    }
    public static function collection_data($data)
    {
        $data = collect($data);
        return $data;
    }
    public  function get_collection($name)
    {
//        $data = collect($data);
        return $name;
//        return $this->sayHi();
    }
    public function sayHi()
    {
        return "Hi from class!";
    }
    /**
     * Make new menu.
     *
     * @param string $name
     * @param Closure $callback
     *
     */
    public function make($name, \Closure $callback)
    {
        return $this->create($name, $callback);
    }

    /**
     * Create new menu.
     *
     * @param string   $name
     * @param Callable $resolver
     *
     */
    public function create($name, Closure $resolver)
    {
//        return 'create function';
        $builder = new DboardBuilder($name, $this->config);

        $builder->setViewFactory($this->views);

        $this->menus[$name] = $builder;

        $thiss = $resolver($builder);
        return $thiss;
    }

    /**
     * Check if the menu exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->menus);
    }

    /**
     * Render the menu tag by given name.
     *
     * @param string $name
     * @param string $presenter
     *
     * @return string|null
     */
    public function get($name, $presenter = null, $bindings = array())
    {
//        return $this->menus[$name];
        return $this->has($name) ?
            $this->menus[$name]->setBindings($bindings)->render($presenter) : null;
    }
    /**
     * Modify a specific menu.
     *
     * @param  string   $name
     * @param  Closure  $callback
     * @return void
     */
    public function modify($name, Closure $callback)
    {
        $menu = collect($this->menus)->filter(function ($menu) use ($name) {
            return $menu->getName() == $name;
        })->first();
        $callback($menu);
    }
    /**
     * Render the menu tag by given name.
     *
     * @param $name
     * @param null $presenter
     *
     * @return string
     */
    public function render($name, $presenter = null, $bindings = array())
    {
        return $this->get($name, $presenter, $bindings);
    }

    /**
     * Get all menus.
     *
     * @return array
     */
    public function all()
    {
        return $this->menus;
    }

    /**
     * Get count from all menus.
     *
     * @return int
     */
    public function count()
    {
        return count($this->menus);
    }

    /**
     * Empty the current menus.
     */
    public function destroy()
    {
        $this->menus = array();
    }
}
