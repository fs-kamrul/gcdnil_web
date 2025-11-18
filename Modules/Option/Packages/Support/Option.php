<?php

namespace Modules\Option\Packages\Support;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Modules\KamrulDashboard\Http\Models\DboardQueryBuilder;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
//use Modules\Location\Http\Models\City;
//use Modules\Location\Http\Models\Country;
//use Modules\Location\Http\Models\State;
//use Modules\Location\Repositories\Interfaces\CityInterface;
//use Modules\Location\Repositories\Interfaces\CountryInterface;
//use Modules\Location\Repositories\Interfaces\StateInterface;
use Modules\Option\Enums\OptionBloodGroupStatusEnum;
use Modules\Option\Enums\OptionSetStatusEnum;
use Modules\Option\Repositories\Eloquent\OptionBloodGroupRepository;
use Modules\Option\Repositories\Interfaces\OptionBloodGroupInterface;
use Modules\Option\Repositories\Interfaces\OptionClassInterface;
use Modules\Option\Repositories\Interfaces\OptionGenderInterface;
use Modules\Option\Repositories\Interfaces\OptionGroupInterface;
use Modules\Option\Repositories\Interfaces\OptionReligionInterface;
use Modules\Option\Repositories\Interfaces\OptionSectionInterface;
use Modules\Option\Repositories\Interfaces\OptionSetInterface;
use Modules\Option\Repositories\Interfaces\OptionYearInterface;
use ZipArchive;

class Option
{
    /**
     * @var OptionClassInterface
     */
    protected $optionClassRepository;
    /**
     * @var OptionGenderInterface
     */
    protected $optionGenderRepository;

    /**
     * @var OptionGroupInterface
     */
    protected $optionGroupRepository;

    /**
     * @var OptionReligionInterface
     */
    protected $optionReligionRepository;
    /**
     * @var OptionSectionInterface
     */
    protected $optionSectionRepository;
    /**
     * @var OptionYearInterface
     */
    protected $optionYearRepository;
    /**
     * @var OptionBloodGroupInterface
     */
    protected $optionBloodGroupRepository;
    /**
     * @var OptionSetInterface
     */
    protected $optionSetRepository;

    public function __construct(
        OptionClassInterface $optionClassRepository,
        OptionGenderInterface $optionGenderRepository,
        OptionGroupInterface $optionGroupRepository,
        OptionReligionInterface $optionReligionRepository,
        OptionSectionInterface $optionSectionRepository,
        OptionYearInterface $optionYearRepository,
        OptionBloodGroupInterface $optionBloodGroupRepository,
        OptionSetInterface $optionSetRepository
    ){
        $this->optionClassRepository = $optionClassRepository;
        $this->optionGenderRepository = $optionGenderRepository;
        $this->optionGroupRepository = $optionGroupRepository;
        $this->optionReligionRepository = $optionReligionRepository;
        $this->optionSectionRepository = $optionSectionRepository;
        $this->optionYearRepository = $optionYearRepository;
        $this->optionBloodGroupRepository = $optionBloodGroupRepository;
        $this->optionSetRepository = $optionSetRepository;
    }

    public function getClass(): array
    {
        $states = $this->optionClassRepository->advancedGet([
            'condition' => [
                'status' => DboardStatus::PUBLISHED,
            ],
            'order_by' => ['order' => 'ASC', 'id' => 'ASC'],
        ]);

        return $states->pluck('name', 'id')->all();
    }
    public function getClassObj(): array
    {
        $states = $this->optionClassRepository->advancedGet([
            'condition' => [
                'status' => DboardStatus::PUBLISHED,
            ],
            'order_by' => ['order' => 'ASC', 'id' => 'ASC'],
        ]);

        return $states->all();
    }
    public function getGender(): array
    {
        $states = $this->optionGenderRepository->advancedGet([
            'condition' => [
                'status' => DboardStatus::PUBLISHED,
            ],
            'order_by' => ['order' => 'ASC', 'id' => 'ASC'],
        ]);

        return $states->pluck('name', 'id')->all();
    }
    public function getGroup(): array
    {
        $states = $this->optionGroupRepository->advancedGet([
            'condition' => [
                'status' => DboardStatus::PUBLISHED,
            ],
            'order_by' => ['order' => 'ASC', 'id' => 'ASC'],
        ]);

        return $states->pluck('name', 'id')->all();
    }
    public function getReligion(): array
    {
        $states = $this->optionReligionRepository->advancedGet([
            'condition' => [
                'status' => DboardStatus::PUBLISHED,
            ],
            'order_by' => ['order' => 'ASC', 'id' => 'ASC'],
        ]);

        return $states->pluck('name', 'id')->all();
    }
    public function getSection(): array
    {
        $states = $this->optionSectionRepository->advancedGet([
            'condition' => [
                'status' => DboardStatus::PUBLISHED,
            ],
            'order_by' => ['order' => 'ASC', 'id' => 'ASC'],
        ]);

        return $states->pluck('name', 'id')->all();
    }
    public function getYear(): array
    {
        $states = $this->optionYearRepository->advancedGet([
            'condition' => [
                'status' => DboardStatus::PUBLISHED,
            ],
            'order_by' => ['order' => 'ASC', 'id' => 'ASC'],
        ]);

        return $states->pluck('name', 'id')->all();
    }

    public function getBloodGroup(): array
    {
        $states = $this->optionBloodGroupRepository->advancedGet([
            'condition' => [
                'status' => OptionBloodGroupStatusEnum::ACTIVE,
            ],
            'order_by' => ['order' => 'ASC', 'id' => 'ASC'],
        ]);

        return $states->pluck('name', 'id')->all();
    }
    public function getSetSubject($class_id): array
    {
        $states = $this->optionSetRepository->advancedGet([
            'condition' => [
                'status' => OptionSetStatusEnum::ACTIVE,
                'class_id' => $class_id,
            ],
            'order_by' => ['order' => 'ASC', 'id' => 'ASC'],
        ]);

        return $states->pluck('name', 'id')->all();
    }
    public function getSetClassSubject($class_id, $groupId): array
    {
        $states = $this->optionSetRepository->advancedGet([
            'condition' => [
                'status' => OptionSetStatusEnum::ACTIVE,
                'class_id' => $class_id,
                'group_id' => $groupId,
            ],
            'order_by' => ['order' => 'ASC', 'id' => 'ASC'],
        ]);

        return $states->all();
//        return $states->pluck('name', 'id')->all();
    }
//    public function getCitiesByState($stateId): array
//    {
//        $cities = $this->cityRepository->advancedGet([
//            'condition' => [
//                'status' => DboardStatus::PUBLISHED,
//                'state_id' => $stateId,
//            ],
//            'order_by' => ['order' => 'ASC', 'name' => 'ASC'],
//        ]);
//
//        return $cities->pluck('name', 'id')->all();
//    }

//    public function getCityById($cityId): ?City
//    {
//        return $this->cityRepository->getFirstBy([
//            'id' => $cityId,
//            'status' => DboardStatus::PUBLISHED,
//        ]);
//    }

//    public function getCityNameById($cityId)
//    {
//        $city = $this->getCityById($cityId);
//
//        return $city->name;
//    }

    public function getBloodGroupNameById($blood_group_id): ?string
    {
        $state = $this->optionBloodGroupRepository->getFirstBy([
            'id' => $blood_group_id,
            'status' => OptionBloodGroupStatusEnum::ACTIVE,
        ]);

        return $state ? $state->name : null;
    }
    public function getClassNameById($classId): ?string
    {
        $state = $this->optionClassRepository->getFirstBy([
            'id' => $classId,
            'status' => DboardStatus::PUBLISHED,
        ]);

        return $state ? $state->name : null;
    }
    public function getGroupNameById($groupId): ?string
    {
        $state = $this->optionGroupRepository->getFirstBy([
            'id' => $groupId,
            'status' => DboardStatus::PUBLISHED,
        ]);

        return $state ? $state->name : null;
    }
    public function getReligionNameById($religionId): ?string
    {
        $state = $this->optionReligionRepository->getFirstBy([
            'id' => $religionId,
            'status' => DboardStatus::PUBLISHED,
        ]);

        return $state ? $state->name : null;
    }
    public function getGenderNameById($genderId): ?string
    {
        $state = $this->optionGenderRepository->getFirstBy([
            'id' => $genderId,
            'status' => DboardStatus::PUBLISHED,
        ]);

        return $state ? $state->name : null;
    }
    public function getYearNameById($yearId): ?string
    {
        $state = $this->optionYearRepository->getFirstBy([
            'id' => $yearId,
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
            return config('location.supported', []);
        }

        if (is_object($model)) {
            $model = get_class($model);
        }

        return Arr::get(config('location.supported', []), $model, []);
    }

    public function registerModule(string $model, array $keys = []): bool
    {
        $keys = array_filter(
            array_merge([
                'country' => 'country_id',
                'state' => 'state_id',
                'city' => 'city_id',
            ], $keys)
        );

        config([
            'plugins.location.general.supported' => array_merge($this->getSupported(), [$model => $keys]),
        ]);

        return true;
    }

    public function getRemoteAvailableLocations(): array
    {
        $client = new Client(['verify' => false]);

        try {
            $info = $client->request('GET', '', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
            ]);

            $info = json_decode($info->getBody()->getContents(), true);

            $availableLocations = [];

            foreach ($info['tree'] as $tree) {
                if (in_array($tree['path'], ['.gitignore', 'README.md'])) {
                    continue;
                }

                $availableLocations[] = $tree['path'];
            }
        } catch (Exception) {
            $availableLocations = ['us', 'ca', 'vn'];
        }

        return $availableLocations;
    }

    public function downloadRemoteLocation(string $countryCode): array
    {
        $repository = '';

        $destination = storage_path('app/location-files.zip');

        $client = new Client(['verify' => false]);

        $availableLocations = $this->getRemoteAvailableLocations();

        if (! in_array($countryCode, $availableLocations)) {
            return [
                'error' => true,
                'message' => 'This country locations data is not available on ' . $repository,
            ];
        }

        try {
            $client->request('GET', $repository . '/archive/refs/heads/master.zip', [
                'sink' => Utils::tryFopen($destination, 'w'),
            ]);
        } catch (Exception|GuzzleException $exception) {
            return [
                'error' => true,
                'message' => $exception->getMessage(),
            ];
        }

        if (class_exists('ZipArchive', false)) {
            $zip = new ZipArchive();
            $res = $zip->open($destination);
            if ($res === true) {
                $zip->extractTo(storage_path('app'));
                $zip->close();
            } else {
                return [
                    'error' => true,
                    'message' => 'Extract location files failed!',
                ];
            }
        } else {
            $archive = new Zip($destination);
            $archive->extract(PCLZIP_OPT_PATH, storage_path('app'));
        }

        if (File::exists($destination)) {
            unlink($destination);
        }

        $dataPath = storage_path('app/locations-master/' . $countryCode);

        if (! File::isDirectory($dataPath)) {
            abort(404);
        }

        $country = file_get_contents($dataPath . '/country.json');
        $country = json_decode($country, true);

        $country = Country::create($country);

        $states = file_get_contents($dataPath . '/states.json');
        $states = json_decode($states, true);
        foreach ($states as $state) {
            $state['country_id'] = $country->id;

            State::create($state);
        }

        $cities = file_get_contents($dataPath . '/cities.json');
        $cities = json_decode($cities, true);
        foreach ($cities as $item) {
            $state = State::where('name', $item['name'])->first();
            if (! $state) {
                continue;
            }

            foreach ($item['cities'] as $cityName) {
                $city = [
                    'name' => $cityName,
                    'state_id' => $state->id,
                    'country_id' => $country->id,
                ];

                City::create($city);
            }
        }

        File::deleteDirectory(storage_path('app/locations-master'));

        return [
            'error' => false,
            'message' => trans('location::bulk-import.imported_successfully'),
        ];
    }

    public function filter($model, int $cityId = null, string $location = null)
    {
        $className = get_class($model);
        if ($className == DboardQueryBuilder::class) {
            $className = get_class($model->getModel());
        }

        if ($this->isSupported($className)) {
            if ($cityId) {
                $model = $model->where('city_id', $cityId);
            } elseif ($location) {
                $locationData = explode(',', $location);

                if (count($locationData) > 1) {
                    $model = $model
                        ->whereHas('city', function ($query) use ($locationData) {
                            $query->where('name', 'LIKE', '%' . trim($locationData[0]) . '%');
                        })
                        ->whereHas('state', function ($query) use ($locationData) {
                            $query->where('name', 'LIKE', '%' . trim($locationData[1]) . '%');
                        });
                } else {
                    $model = $model
                        ->where(function (Builder $query) use ($location) {
                            $query->whereHas('city', function ($q) use ($location) {
                                $q->where('name', 'LIKE', '%' . $location . '%');
                            })->orWhereHas('state', function ($q) use ($location) {
                                $q->where('name', 'LIKE', '%' . $location . '%');
                            });
                        });
                }
            }
        }

        return $model;
    }
}
