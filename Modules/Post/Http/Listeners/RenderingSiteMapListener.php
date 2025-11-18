<?php

namespace Modules\Post\Http\Listeners;

use Modules\Post\Repositories\Interfaces\CategoryInterface;
use Modules\Post\Repositories\Interfaces\PageInterface;
use Modules\Post\Repositories\Interfaces\PostInterface;
use SiteMapManager;

class RenderingSiteMapListener
{
    /**
     * @var PageInterface
     */
    protected $pageRepository;

    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;
    /**
     * @var PostInterface
     */
    protected $postRepository;
    /**
     * RenderingSiteMapListener constructor.
     * @param PageInterface $pageRepository
     * @param CategoryInterface $categoryRepository
     * @param PostInterface $postRepository
     */
    public function __construct(
        PageInterface $pageRepository,
        CategoryInterface $categoryRepository,
        PostInterface $postRepository
    ) {
        $this->pageRepository = $pageRepository;
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        $pages = $this->pageRepository->getDataSiteMap();
        foreach ($pages as $page) {
            SiteMapManager::add(url($page->slug), $page->updated_at, '0.8');
        }
        $categories = $this->categoryRepository->getDataSiteMap();
        foreach ($categories as $category) {
            SiteMapManager::add(url($category->slug), $category->updated_at, '0.8');
        }
        $posts = $this->postRepository->getDataSiteMap();
        foreach ($posts as $post) {
            SiteMapManager::add(url($post->slug), $post->updated_at, '0.8');
        }
    }
}
