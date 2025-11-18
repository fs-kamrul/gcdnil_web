<?php

namespace Modules\Admission\Packages\Support;

use Exception;
use Illuminate\Support\Arr;
use Modules\Admission\Repositories\Interfaces\AdmissionMeritInterface;
use Modules\Admission\Repositories\Interfaces\AdmissionSubjectInterface;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;

class Admissionoption
{
    /**
     * @var AdmissionSubjectInterface
     */
    protected $admissionSubjectRepository;
    /**
     * @var AdmissionMeritInterface
     */
    protected $admissionMeritRepository;

    public function __construct(
        AdmissionSubjectInterface $admissionSubjectRepository,
        AdmissionMeritInterface $admissionMeritRepository
    ){
        $this->admissionSubjectRepository = $admissionSubjectRepository;
        $this->admissionMeritRepository = $admissionMeritRepository;
    }

    public function getSubject(): array
    {
        $states = $this->admissionSubjectRepository->advancedGet([
            'condition' => [
                'status' => DboardStatus::PUBLISHED,
            ],
            'order_by' => ['order' => 'ASC', 'id' => 'ASC'],
        ]);

        return $states->pluck('name', 'id')->all();
    }
    public function getMerit(): array
    {
        $states = $this->admissionMeritRepository->advancedGet([
            'condition' => [
                'status' => DboardStatus::PUBLISHED,
            ],
            'order_by' => ['order' => 'ASC', 'id' => 'ASC'],
        ]);

        return $states->pluck('name', 'id')->all();
    }
    public function getSubjectObj(): array
    {
        $states = $this->admissionSubjectRepository->advancedGet([
            'condition' => [
                'status' => DboardStatus::PUBLISHED,
            ],
            'order_by' => ['order' => 'ASC', 'id' => 'ASC'],
        ]);

        return $states->all();
    }
    public function getSubjectNameById($subjectId): ?string
    {
        $state = $this->admissionSubjectRepository->getFirstBy([
            'id' => $subjectId,
            'status' => DboardStatus::PUBLISHED,
        ]);

        return $state ? $state->name : null;
    }
    public function getMeritNameById($meritId): ?string
    {
        $state = $this->admissionMeritRepository->getFirstBy([
            'id' => $meritId,
            'status' => DboardStatus::PUBLISHED,
        ]);

        return $state ? $state->name : null;
    }

    public function isSupported($model): bool
    {
        if (! $model) {
            return false;
        }

        if (is_object($model)) {
            $model = get_class($model);
        }

        return in_array($model, $this->supportedModels());
    }

    public function supportedModels(): array
    {
        return array_keys($this->getSupported());
    }

    public function getSupported($model = null): array
    {
        if (! $model) {
            return config('admission.supported', []);
        }

        if (is_object($model)) {
            $model = get_class($model);
        }

        return Arr::get(config('admission.supported', []), $model, []);
    }
}
