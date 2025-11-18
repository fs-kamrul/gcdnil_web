{!! Theme::partial('header') !!}

<section id="all-courses-page">
    @if (Theme::get('hasBreadcrumb', true))
        {!! Theme::partial('breadcrumbs') !!}
    @endif

    {!! Theme::content() !!}
</section>
{!! Theme::partial('footer') !!}
