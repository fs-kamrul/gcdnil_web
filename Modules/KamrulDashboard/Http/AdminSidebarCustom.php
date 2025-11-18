<?php

namespace Modules\KamrulDashboard\Http;

use Nwidart\Menus\MenuItem;
use Nwidart\Menus\Presenters\Presenter;

class AdminSidebarCustom extends Presenter
{
    /**
     * {@inheritdoc }.
     */
    public function getOpenTagWrapper()
    {
        return PHP_EOL . '<ul class="metismenu" id="menu">' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getCloseTagWrapper()
    {
        return PHP_EOL . '</ul>' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getMenuWithoutDropdownWrapper($item)
    {
        return '<li' . $this->getActiveState($item) . '><a href="' . $item->getUrl() . '" ' . $item->getAttributes() . '>' . $item->getIcon() . ' <span class="nav-text">' . $item->title . '</span></a></li>' . PHP_EOL;
    }
    public function getMenuWithoutDropdownWrapperSpane($item)
    {
        return '<li' . $this->getActiveState($item) . '><a href="' . $item->getUrl() . '" ' . $item->getAttributes() . '>' . $item->getIcon() . ' ' . $item->title . '</a></li>' . PHP_EOL;
    }
    public function getChildMenuItemsSpane(MenuItem $item)
    {
        $results = '';
        foreach ($item->getChilds() as $child) {
            if ($child->hidden()) {
                continue;
            }

            if ($child->hasSubMenu()) {
                $results .= $this->getMultiLevelDropdownWrapper($child);
            } elseif ($child->isHeader()) {
                $results .= $this->getHeaderWrapper($child);
            } elseif ($child->isDivider()) {
                $results .= $this->getDividerWrapper();
            } else {
                $results .= $this->getMenuWithoutDropdownWrapperSpane($child);
            }
        }

        return $results;
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
        return '<li class="nav-label">' . $item->title . '</li>';
    }

    /**
     * {@inheritdoc }.
     */
    public function getMenuWithDropDownWrapper($item)
    {
//        <span class="pull-right-container">
//                      <i class="fa fa-angle-right pull-right"></i>
//                    </span>
        return '<li class="' . $this->getActiveStateOnChild($item, ' active') . '" ' . $item->getAttributes() . '>
		          <a class="has-arrow" href="javascript:void()" aria-expanded="false">
					' . $item->getIcon() . ' <span class="nav-text">' . $item->title . '</span>
			      </a>
			      <ul class="" aria-expanded="false">
			      	' . $this->getChildMenuItemsSpane($item) . '
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
