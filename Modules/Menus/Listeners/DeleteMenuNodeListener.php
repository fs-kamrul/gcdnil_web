<?php

namespace Modules\Menus\Listeners;

use Exception;
use Menus;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\Menus\Repositories\Interfaces\MenusNodeInterface;

class DeleteMenuNodeListener
{
    protected $menuNodeRepository;

    public function __construct(MenusNodeInterface $menuNodeRepository)
    {
        $this->menuNodeRepository = $menuNodeRepository;
    }

    public function handle(DeletedContentEvent $event): void
    {
        if (in_array(get_class($event->data), Menus::getMenuOptionModels())) {
            try {
                $this->menuNodeRepository->deleteBy([
                    'reference_id' => $event->data->id,
                    'reference_type' => get_class($event->data),
                ]);
            } catch (Exception $exception) {
                info($exception->getMessage());
            }
        }
    }
}
