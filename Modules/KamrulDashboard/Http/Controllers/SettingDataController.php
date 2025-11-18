<?php

namespace Modules\KamrulDashboard\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ProcessUtils;
use Modules\KamrulDashboard\Http\Requests\EmailSettingRequest;
use Modules\KamrulDashboard\Http\Requests\EmailTemplateRequest;
use Modules\KamrulDashboard\Http\Requests\ResetEmailTemplateRequest;
use Modules\KamrulDashboard\Http\Requests\SendTestEmailRequest;
use Modules\KamrulDashboard\Http\Requests\SettingRequest;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Packages\Supports\Language;
use PageTitle;
use Throwable;
use Assets;
use DboardHelper;
use EmailHandler;


class SettingDataController extends DboardController
{
    public function getOptions()
    {
        if (!auth()->user()->can('settings_access')) {
            abort(403, 'Unauthorized action.');
        }
        PageTitle::setTitle(trans('kamruldashboard::setting.title'));

        Assets::addScriptsDirectly([
                'vendor/Modules/KamrulDashboard/js/setting.js',
            ])
            ->addStylesDirectly('vendor/Modules\KamrulDashboard/css/setting.css');

//        Assets::usingVueJS();


        return view('kamruldashboard::setting_data.index2');
    }

    public function postEdit(SettingRequest $request, DboardHttpResponse $response)
    {
        $this->saveSettings(
            $request->except([
                '_token',
                'locale',
                'default_admin_theme',
                'admin_locale_direction',
            ])
        );

        $locale = $request->input('locale');
        if ($locale && array_key_exists($locale, Language::getAvailableLocales())) {
            session()->put('site-locale', $locale);
        }

        $isDemoModeEnabled = DboardHelper::hasDemoModeEnabled();

        if (! $isDemoModeEnabled) {
            setting()->set('locale', $locale);
        }

        $adminTheme = $request->input('default_admin_theme');
        if ($adminTheme != setting('default_admin_theme')) {
            session()->put('admin-theme', $adminTheme);
        }

        if (! $isDemoModeEnabled) {
            setting()->set('default_admin_theme', $adminTheme);
        }

        $adminLocalDirection = $request->input('admin_locale_direction');
        if ($adminLocalDirection != setting('admin_locale_direction')) {
            session()->put('admin_locale_direction', $adminLocalDirection);
        }

        if (! $isDemoModeEnabled) {
            setting()->set('admin_locale_direction', $adminLocalDirection);
            setting()->save();
        }

        return $response
            ->setPreviousUrl(route('settings.options'))
            ->setMessage(trans('kamruldashboard::notices.update_success_message'));
    }

    protected function saveSettings(array $data): void
    {
        foreach ($data as $settingKey => $settingValue) {
            if (is_array($settingValue)) {
                $settingValue = json_encode(array_filter($settingValue));
            }

            setting()->set($settingKey, (string)$settingValue);
        }

        setting()->save();
    }

    public function getEmailConfig()
    {
        PageTitle::setTitle(trans('kamruldashboard::layouts.setting_email'));

        Assets::addScriptsDirectly('vendor/Modules/KamrulDashboard/js/setting.js')
            ->addStylesDirectly('vendor/Modules/KamrulDashboard/css/setting.css')
            ->addScripts(['jquery-validation', 'form-validation']);

//        $jsValidation = JsValidator::formRequest(EmailSettingRequest::class);

        return view('kamruldashboard::setting_data.email');
    }

    public function postEditEmailConfig(EmailSettingRequest $request, DboardHttpResponse $response)
    {
        $this->saveSettings($request->except(['_token']));

        return $response
            ->setPreviousUrl(route('settings.email'))
            ->setMessage(trans('kamruldashboard::notices.update_success_message'));
    }

    public function getEditEmailTemplate(string $type, string $module, string $template)
    {
        PageTitle::setTitle(trans(config($type . '.' . $module . '.email.templates.' . $template . '.title', '')));

        Assets::addStylesDirectly([
            'vendor/Modules/KamrulDashboard/vendor2/codemirror/lib/codemirror.css',
            'vendor/Modules/KamrulDashboard/vendor2/codemirror/addon/hint/show-hint.css',
            'vendor/Modules/KamrulDashboard/css/setting.css',
        ])
            ->addScriptsDirectly([
                'vendor/Modules/KamrulDashboard/vendor2/codemirror/lib/codemirror.js',
                'vendor/Modules/KamrulDashboard/vendor2/codemirror/lib/css.js',
                'vendor/Modules/KamrulDashboard/vendor2/codemirror/addon/hint/show-hint.js',
                'vendor/Modules/KamrulDashboard/vendor2/codemirror/addon/hint/anyword-hint.js',
                'vendor/Modules/KamrulDashboard/vendor2/codemirror/addon/hint/css-hint.js',
                'vendor/Modules/KamrulDashboard/js/setting.js',
            ]);

        $emailContent = get_setting_email_template_content($type, $module, $template);
        $emailSubject = get_setting_email_subject($type, $module, $template);
        $pluginData = [
            'type' => $type,
            'name' => $module,
            'template_file' => $template,
        ];

        return view('kamruldashboard::setting_data.email-template-edit', compact('emailContent', 'emailSubject', 'pluginData'));
    }

    public function postStoreEmailTemplate(EmailTemplateRequest $request, DboardHttpResponse $response)
    {
        if ($request->has('email_subject_key')) {
            setting()
                ->set($request->input('email_subject_key'), $request->input('email_subject'))
                ->save();
        }

        $templatePath = get_setting_email_template_path($request->input('module'), $request->input('template_file'));

        DboardHelper::saveFileData($templatePath, $request->input('email_content'), false);

        return $response->setMessage(trans('kamruldashboard::notices.update_success_message'));
    }

    public function postResetToDefault(ResetEmailTemplateRequest $request, DboardHttpResponse $response)
    {
        Setting::delete([$request->input('email_subject_key')]);

        $templatePath = get_setting_email_template_path($request->input('module'), $request->input('template_file'));

        if (File::exists($templatePath)) {
            File::delete($templatePath);
        }

        $shouldBeCleanedDirectories = [
            File::dirname($templatePath),
            storage_path('app/email-templates'),
        ];

        foreach ($shouldBeCleanedDirectories as $shouldBeCleanedDirectory) {
            if (File::isDirectory($shouldBeCleanedDirectory) && File::isEmptyDirectory($shouldBeCleanedDirectory)) {
                File::deleteDirectory($shouldBeCleanedDirectory);
            }
        }

        return $response->setMessage(trans('kamruldashboard::setting.email.reset_success'));
    }

    public function postChangeEmailStatus(Request $request, DboardHttpResponse $response)
    {
        $request->validate(['key' => 'string', 'value' => 'in:0,1']);

        setting()
            ->set($request->input('key'), $request->boolean('value'))
            ->save();

        return $response->setMessage(trans('kamruldashboard::notices.update_success_message'));
    }

    public function postSendTestEmail(DboardHttpResponse $response, SendTestEmailRequest $request)
    {
        try {
            EmailHandler::send(
                file_get_contents(core_path('KamrulDashboard/Resources/email-templates/test.tpl')),
                'Test',
                $request->input('email'),
                [],
                true
            );

            return $response->setMessage(trans('kamruldashboard::setting.test_email_send_success'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
//
//    public function getMediaSetting(MediaFolderInterface $mediaFolderRepository)
//    {
//        PageTitle::setTitle(trans('kamruldashboard::setting.media.title'));
//
//        Assets::addScriptsDirectly('vendor/Modules/KamrulDashboard/js/setting.js')
//            ->addStylesDirectly('vendor/Modules/KamrulDashboard/css/setting.css')
//            ->addScripts(['jquery-validation', 'form-validation']);
//
//        $folderIds = json_decode((string)setting('media_folders_can_add_watermark'), true);
//
//        $folders = $mediaFolderRepository->pluck('name', 'id', ['parent_id' => 0]);
//
//        $jsValidation = JsValidator::formRequest(MediaSettingRequest::class);
//
//        return view('kamruldashboard::media', compact('folders', 'folderIds', 'jsValidation'));
//    }

//    public function postEditMediaSetting(MediaSettingRequest $request, DboardHttpResponse $response)
//    {
//        $this->saveSettings($request->except(['_token']));
//
//        return $response
//            ->setPreviousUrl(route('settings.media'))
//            ->setMessage(trans('kamruldashboard::notices.update_success_message'));
//    }


    public function previewEmailTemplate(Request $request, string $type, string $module, string $template)
    {
        $emailHandler = EmailHandler::setModule($module)
            ->setType($type)
            ->setTemplate($template);

        $variables = $emailHandler->getVariables($type, $module, $template);

        $coreVariables = $emailHandler->getCoreVariables();

        Arr::forget($variables, array_keys($coreVariables));

        $inputData = $request->only(array_keys($variables));

        if (! empty($inputData)) {
            foreach ($inputData as $key => $value) {
                $inputData[DboardHelper::stringify($key)] = DboardHelper::clean(DboardHelper::stringify($value));
            }
        }

        $routeParams = [$type, $module, $template];

        $backUrl = route('setting.email.template.edit', $routeParams);

        $iframeUrl = route('setting.email.preview.iframe', $routeParams);

        return view(
            'kamruldashboard::setting_data.preview-email',
            compact('variables', 'inputData', 'backUrl', 'iframeUrl')
        );
    }

    public function previewEmailTemplateIframe(Request $request, string $type, string $module, string $template)
    {
        $emailHandler = EmailHandler::setModule($module)
            ->setType($type)
            ->setTemplate($template);

        $variables = $emailHandler->getVariables($type, $module, $template);

        $coreVariables = $emailHandler->getCoreVariables();

        Arr::forget($variables, array_keys($coreVariables));

        $inputData = $request->only(array_keys($variables));

        foreach ($variables as $key => $variable) {
            if (! isset($inputData[$key])) {
                $inputData[$key] = '{{ ' . $key . ' }}';
            } else {
                $inputData[$key] = DboardHelper::clean(DboardHelper::stringify($inputData[$key]));
            }
        }

        $emailHandler->setVariableValues($inputData);

        $content = get_setting_email_template_content($type, $module, $template);

        $content = $emailHandler->prepareData($content);

        return DboardHelper::clean($content);
    }

    public function cronjob(): View
    {
        PageTitle::setTitle(trans('kamruldashboard::setting.cronjob.name'));

        Assets::addScriptsDirectly('vendor/Modules/KamrulDashboard/js/setting.js');

        $command = sprintf(
            '* * * * * cd %s && %s >> /dev/null 2>&1',
            DboardHelper::hasDemoModeEnabled() ? 'path-to-your-project' : ProcessUtils::escapeArgument(base_path()),
            Application::formatCommandString('schedule:run')
        );

        $lastRunAt = Setting::get('cronjob_last_run_at');

        if ($lastRunAt) {
            $lastRunAt = Carbon::parse($lastRunAt);
        }

        return view('kamruldashboard::setting_data.cronjob', compact('command', 'lastRunAt'));
    }

}
