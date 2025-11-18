<?php

namespace Modules\KamrulDashboard\Listeners;

use Exception;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Repositories\Interfaces\SlugInterface;
use SlugHelper;

class SlugDeletedContentListener
{

    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * @param SlugInterface $slugRepository
     */
    public function __construct(SlugInterface $slugRepository)
    {
        $this->slugRepository = $slugRepository;
    }

    /**
     * Handle the event.
     *
     * @param DeletedContentEvent $event
     * @return void
     */
    public function handle(DeletedContentEvent $event)
    {
        if (SlugHelper::isSupportedModel(get_class($event->data))) {
            try {
                $this->slugRepository->deleteBy([
                    'reference_id'   => $event->data->id,
                    'reference_type' => get_class($event->data),
                ]);
            } catch (Exception $exception) {
                info($exception->getMessage());
            }
        }
    }
}
