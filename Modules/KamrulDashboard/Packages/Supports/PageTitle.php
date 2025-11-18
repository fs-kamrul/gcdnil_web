<?php

namespace Modules\KamrulDashboard\Packages\Supports;

class PageTitle
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @param bool $full
     * @return string
     */
    public function getTitle(bool $full = true)
    {
//        if (empty($this->title)) {
////            return setting('site_name', config('kamruldashboard.site_name'));
//            return getSetting('site_name', 'site_setting', config('kamruldashboard.site_name'));
//        }
//
//        if (!$full) {
//            return $this->title;
//        }
//
//        return $this->title . ' | ' .getSetting('site_name', 'site_setting', config('kamruldashboard.site_name'));

        $baseTitle = theme_option('site_title', config('kamruldashboard.site_name'));

        if (empty($this->title)) {
            return $baseTitle;
        }

        if (! $full) {
            return $this->title;
        }

        return $this->title . ' | ' . $baseTitle;
    }
}
