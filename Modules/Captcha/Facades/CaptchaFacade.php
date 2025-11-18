<?php

namespace Modules\Captcha\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool verify(string $response, string $clientIp, array $options = [])
 * @method static string|null display(array $attributes = [], array $options = [])
 * @method static array rules()
 * @method static bool isEnabled()
 * @method static array mathCaptchaRules()
 * @method static string captchaType()
 * @method static array attributes()
 *
 * @see \Modules\Captcha\Contracts\Captcha
 */
class CaptchaFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'captcha';
    }
}
