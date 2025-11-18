<?php

namespace Modules\KamrulDashboard\Packages\Supports;

use Illuminate\Support\Facades\Artisan;
//use Cache;
use Exception;
use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Http\Request;

class Helper
{
    /**
     * Load helpers from a directory
     * @param string $directory
     * @since 2.0
     */
    public static function autoload(string $directory): void
    {
        $helpers = File::glob($directory . '/*.php');
        foreach ($helpers as $helper) {
            File::requireOnce($helper);
        }
    }

    /**
     * @param Model | Model $object
     * @param string $sessionName
     * @return bool
     */
    public static function handleViewCount(Model $object, $sessionName): bool
    {
        if (!array_key_exists($object->id, session()->get($sessionName, []))) {
            try {
                $object->increment('views');
                session()->put($sessionName . '.' . $object->id, time());
                return true;
            } catch (Exception $exception) {
                return false;
            }
        }

        return false;
    }

    /**
     * Format Log data
     *
     * @param array $input
     * @param string $line
     * @param string $function
     * @param string $class
     * @return array
     */
    public static function formatLog($input, $line = '', $function = '', $class = ''): array
    {
        return array_merge($input, [
            'user_id'   => Auth::check() ? Auth::id() : 'System',
            'ip'        => Request::ip(),
            'line'      => $line,
            'function'  => $function,
            'class'     => $class,
            'userAgent' => Request::header('User-Agent'),
        ]);
    }

    /**
     * @param string $module
     * @param string $type
     * @return boolean
     */
    public static function removeModuleFiles(string $module, $type = 'packages'): bool
    {
        $folders = [
            public_path('vendor/Modules/' . $type . '/' . $module),
            resource_path('assets/' . $type . '/' . $module),
            resource_path('views/vendor/' . $type . '/' . $module),
            resource_path('lang/vendor/' . $type . '/' . $module),
            config_path($type . '/' . $module),
        ];

        foreach ($folders as $folder) {
            if (File::isDirectory($folder)) {
                File::deleteDirectory($folder);
            }
        }

        return true;
    }

    /**
     * @param string $command
     * @param array $parameters
     * @param null $outputBuffer
     * @return bool|int
     * @throws Exception
     * @deprecated since v5.5, will be removed in v5.7
     */
    public static function executeCommand(string $command, array $parameters = [], $outputBuffer = null): bool
    {
        if (!function_exists('proc_open')) {
            if (config('app.debug') && config('kamruldashboard::lang.can_execute_command')) {
                throw new Exception(trans('kamruldashboard::lang.proc_close_disabled_error'));
            }
            return false;
        }

        if (config('kamruldashboard::lang.can_execute_command')) {
            return Artisan::call($command, $parameters, $outputBuffer);
        }

        return false;
    }

    /**
     * @return bool
     */
    public static function isConnectedDatabase(): bool
    {
        try {
            return Schema::hasTable('settings');
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @return bool
     */
    public static function clearCache(): bool
    {
        Event::dispatch('cache:clearing');

        try {
            Cache::flush();
            if (!File::exists($storagePath = storage_path('framework/cache'))) {
                return true;
            }

            foreach (File::files($storagePath) as $file) {
                if (preg_match('/facade-.*\.php$/', $file)) {
                    File::delete($file);
                }
            }
        } catch (Exception $exception) {
            info($exception->getMessage());
        }

        Event::dispatch('cache:cleared');

        return true;
    }
    /**
     * @return bool
     */
    public static function configCache(): bool
    {
        Event::dispatch('config:cache');

        try {
            $cachedConfigFile = __DIR__ . '/../../../../../bootstrap/cache/config.php';

            if (file_exists($cachedConfigFile)) {
                require $cachedConfigFile;
            } else {
                $config = require __DIR__ . '/../config/compile.php';

                foreach (glob(__DIR__ . '/*.php') as $file) {
                    $config = array_merge($config, require $file);
                }

                file_put_contents($cachedConfigFile, '<?php return ' . var_export($config, true) . ';');
            }
        } catch (Exception $exception) {
            info($exception->getMessage());
        }

        Event::dispatch('config:cache');

//        return true;
    }


    /**
     * @param string $countryCode
     * @return string
     */
    public static function getCountryNameByCode(?string $countryCode): ?string
    {
        if (empty($countryCode)) {
            return null;
        }

        return Arr::get(self::countries(), $countryCode, $countryCode);
    }

    /**
     * @return string[]
     */
    public static function countries(): array
    {
        return config('kamruldashboard.countries', []);
    }

    /**
     * @param int $value
     * @return int
     */
    public static function convertHrToBytes($value)
    {
        $value = strtolower(trim($value));
        $bytes = (int)$value;

        if (false !== strpos($value, 'g')) {
            $bytes *= 1024 * 1024 * 1024;
        } elseif (false !== strpos($value, 'm')) {
            $bytes *= 1024 * 1024;
        } elseif (false !== strpos($value, 'k')) {
            $bytes *= 1024;
        }

        // Deal with large (float) values which run into the maximum integer size.
        return min($bytes, PHP_INT_MAX);
    }
}
