<?php

namespace Modules\KamrulDashboard\Packages\Supports;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Repositories\Interfaces\SlugInterface;
use Modules\Post\Http\Models\Page;

class SlugHelper
{
    /**
     * @var array
     */
    protected $canEmptyPrefixes = [Page::class];

    /**
     * @var SlugCompiler
     */
    protected $translator;
    public function __construct(SlugCompiler $translator)
    {
        $this->translator = $translator;
    }
    /**
     * @param string|array $model
     * @param string|null $name
     * @return $this
     */
    public function registerModule($model, ?string $name = null): self
    {
        $supported = $this->supportedModels();

        if (!is_array($model)) {
            $supported[$model] = $name ?: $model;
        } else {
            foreach ($model as $item) {
                $supported[$item] = $name ?: $item;
            }
        }

        config(['kamruldashboard.supported.slug' => $supported]);

        return $this;
    }
    /**
     * @param string|array $model
     * @return $this
     */
    public function removeModule($model): self
    {
        $supported = $this->supportedModels();

        Arr::forget($supported, $model);

        config(['kamruldashboard.supported.slug' => $supported]);

        return $this;
    }
    /**
     * @param string $model
     * @param string|null $prefix
     * @param bool $canEmptyPrefix
     * @return $this
     */
    public function setPrefix(string $model, ?string $prefix, bool $canEmptyPrefix = false): self
    {
        $prefixes = config('kamruldashboard.prefixes', []);
        $prefixes[$model] = $prefix;

        config(['kamruldashboard.prefixes' => $prefixes]);

        if ($canEmptyPrefix) {
            $this->canEmptyPrefixes[] = $model;
        }

        return $this;
    }
    /**
     * @param string|null $key
     * @param string $model
     * @return mixed
     */
    public function getSlug(
        ?string $key,
        ?string $prefix = null,
        ?string $model = null,
                $referenceId = null
    )
    {
        $condition = [];

        if ($key !== null) {
            $condition = ['key' => $key];
        }

        if ($model !== null) {
            $condition['reference_type'] = $model;
        }

        if ($referenceId !== null) {
            $condition['reference_id'] = $referenceId;
        }

        if ($prefix !== null) {
            $condition['prefix'] = $prefix;
        }
        return app(SlugInterface::class)->getFirstBy($condition);
    }

    /**
     * @param string $model
     * @param string $default
     * @return string|null
     */
    public function getPrefix(string $model, string $default = '', bool $translate = true): ?string
    {
        $prefix = setting($this->getPermalinkSettingKey($model));

        if ($prefix === null) {
            $prefix = Arr::get(config('kamruldashboard.prefixes', []), $model);
        }

        if ($prefix !== null) {
            if ($translate) {
                $prefix = $this->translator->compile($prefix, $model);
            }

            $default = $prefix;
        }

        return $default;
//        $permalink = setting($this->getPermalinkSettingKey($model));
//
//        if ($permalink !== null) {
//            return $permalink;
//        }
//
//        $config = Arr::get(config('kamruldashboard.prefixes', []), $model);
//
//        if ($config !== null) {
//            return (string)$config;
//        }
//
//        return $default;
    }

    /**
     * @return bool
     */
    public function turnOffAutomaticUrlTranslationIntoLatin(): bool
    {
        return setting('slug_turn_off_automatic_url_translation_into_bangla', 0) == 1;
    }
    /**
     * @param string $model
     * @return string
     */
    public function getPermalinkSettingKey(string $model): string
    {
        return 'permalink-' . Str::slug(str_replace('\\', '_', $model));
    }
    /**
     * @return bool
     */
    public function isSupportedModel(string $model): bool
    {
        return in_array($model, array_keys($this->supportedModels()));
    }

    /**
     * @param DboardModel|array $model
     * @return $this
     */
    public function disablePreview($model): self
    {
        if (!is_array($model)) {
            $model = [$model];
        }

        config([
            'kamruldashboard.slug.disable_preview' => array_merge(config('kamruldashboard.slug.disable_preview', []),
                $model),
        ]);

        return $this;
    }
    /**
     * @param string $model
     * @return bool
     */
    public function canPreview(string $model): bool
    {
        return !in_array($model, config('kamruldashboard.slug.disable_preview', []));
    }

    public function getPublicSingleEndingURL(): ?string
    {
        $endingURL = setting($this->getSettingKey('public_single_ending_url'), config('packages.theme.general.public_single_ending_url'));

        return ! empty($endingURL) ? '.' . $endingURL : null;
    }
    public function getSettingKey(string $key): string
    {
        return apply_filters('slug_helper_get_permalink_setting_key', $key);
    }
    /**
     * @return array
     */
    public function supportedModels(): array
    {
        return config('kamruldashboard.supported.slug', []);
    }

    public function setColumnUsedForSlugGenerator(string $model, string $column): self
    {
        $columns = config('kamruldashboard.slug.slug_generated_columns', []);
        $columns[$model] = $column;

        config(['kamruldashboard.slug.slug_generated_columns' => $columns]);

        return $this;
    }
    public function getColumnNameToGenerateSlug(string $model): ?string
    {
        if (is_object($model)) {
            $model = get_class($model);
        }

        $config = Arr::get(config('kamruldashboard.slug.slug_generated_columns', []), $model);

        if ($config !== null) {
            return (string)$config;
        }

        return 'name';
    }
    public function getCanEmptyPrefixes(): array
    {
        return $this->canEmptyPrefixes;
    }

    public function getTranslator(): SlugCompiler
    {
        return $this->translator;
    }
    public function getSlugPrefixes(): array
    {
        $prefixes = [];

        foreach ($this->supportedModels() as $class => $model) {
            $prefixes[] = addslashes($this->getPrefix($class, false));
        }

        return array_values(array_filter($prefixes));
    }

    public function getAllPrefixes(): array
    {
        $allSettingPrefixes = collect(setting()->all())
            ->filter(function ($value, $key) {
                return $value && Str::startsWith($key, 'permalink-');
            })
            ->all();

        $prefixes = [];

        foreach ($this->supportedModels() as $class => $model) {
            $normalizeModel = Str::slug(str_replace('\\', '_', $class));

            foreach ($allSettingPrefixes as $key => $value) {
                if (! Str::startsWith($key, 'permalink-' . $normalizeModel)) {
                    continue;
                }

                $prefixes[] = $value;

                unset($allSettingPrefixes[$key]);
            }

            $prefixes[] =  Arr::get(config('kamruldashboard.prefixes', []), $class);
        }

        return array_unique(array_filter($prefixes ?: []));
    }
}
