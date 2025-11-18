<?php

namespace Modules\Captcha\Supports;


use Modules\Captcha\Contracts\Captcha as CaptchaContract;
use Illuminate\Support\Facades\Http;

class Captcha extends CaptchaContract
{
    protected $rendered = false;

    public function display(array $attributes = [], array $options = [])
    {
        if (!$this->siteKey || !$this->isEnabled()) {
            return null;
        }

        $name = 'captcha_' . md5(uniqid((string)rand(), true));

        $isRendered = $this->rendered;

        add_filter(THEME_FRONT_FOOTER, function ($html) use ($isRendered, $name): string {
            $url = self::RECAPTCHA_CLIENT_API_URL . '?' . http_build_query([
                    'onload' => 'onloadCallback',
                    'render' => 'explicit',
                    'hl' => app()->getLocale(),
                ]);

            return $html . view('captcha::v2.script', compact('url', 'isRendered', 'name'))->render();
        }, 99);

        $this->rendered = true;

        return view('captcha::v2.html', [
            'name' => $name,
            'siteKey' => $this->siteKey,
        ])->render();
    }

    public function verify(string $response, string $clientIp = null, array $options = []): bool
    {
        if (!$this->isEnabled()) {
            return true;
        }

        if (empty($response)) {
            return false;
        }

        $response = Http::asForm()
            ->withoutVerifying()
            ->post(self::RECAPTCHA_VERIFY_API_URL, [
                'secret' => $this->secretKey,
                'response' => $response,
                'remoteip' => $clientIp,
            ]);

        return $response->json('success');
    }
}
