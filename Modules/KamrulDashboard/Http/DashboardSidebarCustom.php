<?php

namespace Modules\KamrulDashboard\Http;

use Nwidart\Menus\Presenters\Presenter;

class DashboardSidebarCustom extends Presenter
{
    /**
     * {@inheritdoc }.
     */
    public function getOpenTagWrapper()
    {
        return PHP_EOL . '<div class="row">' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getCloseTagWrapper()
    {
        return PHP_EOL . '</div>' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getMenuWithoutDropdownWrapper($item)
    {
        return '<li' . $this->getActiveState($item) . '><a href="' . $item->getUrl() . '" ' . $item->getAttributes() . '>' . $item->getIcon() . ' <span class="nav-text">' . $item->title . '</span></a></li>' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getActiveState($item, $state = ' class="mm-active"')
    {
        return $item->isActive() ? $state : null;
    }

    /**
     * Get active state on child items.
     *
     * @param $item
     * @param string $state
     *
     * @return null|string
     */
    public function getActiveStateOnChild($item, $state = 'mm-active')
    {
        return $item->hasActiveOnChild() ? $state : null;
    }

    /**
     * {@inheritdoc }.
     */
    public function getDividerWrapper()
    {
        return '<li class="divider"></li>';
    }

    /**
     * {@inheritdoc }.
     */
    public function getHeaderWrapper($item)
    {
        return '<div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="stat-widget-two card-body">
                            <div class="stat-content">
                                <div class="stat-text">' . $item->title . '</div>
                                <div class="stat-digit"> <i class="icon-equalizer"></i>' . $item->values . '</div>
                            </div>
                        </div>
                    </div>
                </div>';
//        return '<li class="nav-label first">' . $item->title . '</li>';
    }

    /**
     * {@inheritdoc }.
     */
    public function getMenuWithDropDownWrapper($item)
    {
        return '<li class="' . $this->getActiveStateOnChild($item, ' active') . '" ' . $item->getAttributes() . '>
		          <a href="has-arrow" href="javascript:void()" aria-expanded="false">
					' . $item->getIcon() . ' <span class="nav-text">' . $item->title . '</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-right pull-right"></i>
                    </span>
			      </a>
			      <ul class="" aria-expanded="false">
			      	' . $this->getChildMenuItems($item) . '
			      </ul>
		      	</li>'
        . PHP_EOL;
    }

    /**
     * Get multilevel menu wrapper.
     *
     * @param \Nwidart\Menus\MenuItem $item
     *
     * @return string`
     */
    public function getMultiLevelDropdownWrapper($item)
    {
        return '<li class="treeview' . $this->getActiveStateOnChild($item, ' active') . '">
		          <a href="#">
					' . $item->getIcon() . ' <span>' . $item->title . '</span>
			      	<span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
			      </a>
			      <ul class="treeview-menu">
			      	' . $this->getChildMenuItems($item) . '
			      </ul>
		      	</li>'
        . PHP_EOL;
    }
}
