<?php

namespace Modules\Menu\Listeners;

use Exception;
use Menus;
use Modules\KamrulDashboard\Events\UpdatedSlugEvent;
use Modules\Menus\Repositories\Interfaces\MenusNodeInterface;

class UpdateMenuNodeUrlListener
{
    protected $menuNodeRepository;

    public function __construct(MenusNodeInterface $menuNodeRepository)
    {
        $this->menuNodeRepository = $menuNodeRepository;
    }

    public function handle(UpdatedSlugEvent $event): void
    {
        try {
            if (in_array(get_class($event->data), Menus::getMenuOptionModels())) {
                $nodes = $this->menuNodeRepository->allBy([
                    'reference_id' => $event->data->id,
                    'reference_type' => get_class($event->data),
                ]);

                foreach ($nodes as $node) {
                    $newUrl = str_replace(url(''), '', $node->reference->url);
                    if ($node->url != $newUrl) {
                        $node->url = $newUrl;
                        $node->save();
                    }
                }
            }
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
