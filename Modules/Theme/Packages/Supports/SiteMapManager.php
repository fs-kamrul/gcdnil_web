<?php

namespace Modules\Theme\Packages\Supports;

//use AdminBar;
use Carbon\Carbon;
use DboardHelper;
use Illuminate\Contracts\Container\BindingResolutionException;
use Modules\Sitemap\Http\Sitemap;

class SiteMapManager
{
    /**
     * @var Sitemap
     */
    protected $siteMap;

    /**
     * SiteMapManager constructor.
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        // create new site map object
        $this->siteMap = app('sitemap');
//        $this->siteMap = app()->make('sitemap');

        // set cache (key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean))
        // by default cache is disabled
        $this->siteMap->setCache('cache_site_map_key', setting('cache_time_site_map', 60), setting('enable_cache_site_map', true));
//        $this->siteMap->setCache('public.sitemap', config('kamruldashboard.cache_site_map'));

        if (!DboardHelper::getHomepageId()) {
            $this->siteMap->add(route('public.index'), Carbon::now()->toDateTimeString(), '1.0', 'daily');
        }

//        AdminBar::setIsDisplay(false);
    }

    /**
     * @param string $url
     * @param string $date
     * @param string $priority
     * @param string $sequence
     * @return $this
     */
    public function add($url, $date, $priority = '1.0', $sequence = 'daily')
    {
        if (!$this->siteMap->isCached()) {
            $this->siteMap->add($url, $date, $priority, $sequence);
        }

        return $this;
    }

    /**
     * @param string $type
     * @return string
     */
    public function render($type = 'xml')
    {
        // show your site map (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $this->siteMap->render($type);
    }
}
