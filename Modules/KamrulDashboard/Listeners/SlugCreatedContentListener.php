<?php

namespace Modules\KamrulDashboard\Listeners;

use Exception;
use Illuminate\Support\Str;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Repositories\Interfaces\SlugInterface;
use Modules\KamrulDashboard\Services\SlugService;
use SlugHelper;

class SlugCreatedContentListener
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
     * @param CreatedContentEvent $event
     * @param SlugService $slugService
     * @return void
     */
    public function handle(CreatedContentEvent $event)
    {
        if (SlugHelper::isSupportedModel(get_class($event->data)) && $event->request->input('is_slug_editable', 0)) {
            try {
                $slug = $event->request->input('slug');

                if (!$slug) {
                    $slug = $event->request->input('name');
                }

                if (!$slug && $event->data->name) {
                    if (!SlugHelper::turnOffAutomaticUrlTranslationIntoLatin()) {
                        $slug = Str::slug($event->data->name);
                    } else {
                        $slug = $event->data->name;
                    }
                }

                if (!$slug) {
                    $slug = time();
                }

                $slugService = new SlugService($this->slugRepository);

                $this->slugRepository->createOrUpdate([
                    'key'            => $slugService->create($slug, (int)$event->data->slug_id, get_class($event->data)),
                    'reference_type' => get_class($event->data),
                    'reference_id'   => $event->data->id,
                    'prefix'         => SlugHelper::getPrefix(get_class($event->data)),
                ]);
            } catch (Exception $exception) {
                info($exception->getMessage());
            }
        }
    }
}
