<?php

namespace Modules\KamrulDashboard\Services;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class DboardMedia
{

    public function getRealPath(string $url): string
    {
        $default = config('filesystems.default');
        switch ($default) {
            case 'local':
            case 'public':
                return Storage::path($url);
            default:
                return Storage::url($url);
        }
    }
    /**
     * @param null $key
     * @param null $default
     * @return array|\ArrayAccess|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function getConfig($key = null, $default = null)
    {
        $configs = config('Modules.KamrulDashboard.media');

        if (! $key) {
            return $configs;
        }

        return Arr::get($configs, $key, $default);
    }

    /**
     * @return bool
     */
    public function isChunkUploadEnabled()
    {
        return $this->getConfig('chunk.enabled') == '1';
    }

}
