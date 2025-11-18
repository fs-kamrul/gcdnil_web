@php
    Theme::set('subtitle', clean($category->description));
    Theme::set('pageId', theme_option('site_page_id', setting('site_page_id')));

    $layout = theme_option('blog_layout', 'grid');
    $layout = ($layout && in_array($layout, array_keys(get_blog_layouts()))) ? $layout : 'grid';

    if (in_array($layout, ['grid', 'list'])) {
        Theme::layout('right-sidebar');
    }
@endphp

@include(Theme::getThemeNamespace() . '::views.templates.posts', compact('posts', 'layout'))
