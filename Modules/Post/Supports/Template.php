<?php

namespace Modules\Post\Supports;

use Theme;

class Template
{
    /**
     * @param array $templates
     * @return void
     * @since 16-09-2016
     */
    public static function registerPageTemplate($templates = [])
    {
        $validTemplates = [];
        foreach ($templates as $key => $template) {
            if (in_array($key, self::getExistsTemplate())) {
                $validTemplates[$key] = $template;
            }
        }

        config([
            'post.templates' => array_merge(config('post.templates'),
                $validTemplates),
        ]);
    }

    /**
     * @return array
     * @since 16-09-2016
     */
    protected static function getExistsTemplate()
    {
        $files = scan_folder(theme_path(Theme::getThemeName() . DIRECTORY_SEPARATOR . config('theme.containerDir.layout')));
        foreach ($files as $key => $file) {
            $files[$key] = str_replace('.blade.php', '', $file);
        }

        return $files;
    }

    /**
     * @return array
     * @since 16-09-2016
     */
    public static function getPageTemplates()
    {
        return config('post.templates', []);
    }
}
