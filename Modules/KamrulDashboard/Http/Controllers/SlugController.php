<?php

namespace Modules\KamrulDashboard\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\KamrulDashboard\Http\Requests\SlugRequest;
use Modules\KamrulDashboard\Repositories\Interfaces\SlugInterface;
use Modules\KamrulDashboard\Services\SlugService;

class SlugController extends Controller
{
    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * @var SlugService
     */
    protected $slugService;

    /**
     * SlugController constructor.
     * @param SlugInterface $slugRepository
     * @param SlugService $slugService
     */
    public function __construct(SlugInterface $slugRepository, SlugService $slugService)
    {
        $this->slugRepository = $slugRepository;
        $this->slugService = $slugService;
    }

    /**
     * @param SlugRequest $request
     * @return int|string
     */
    public function store(SlugRequest $request)
    {
        return $this->slugService->create(
            $request->input('name'),
            $request->input('slug_id'),
            $request->input('model')
        );
    }
}
