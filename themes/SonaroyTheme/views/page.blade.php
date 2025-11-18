@php

    Theme::set('pageId', $page->id);

@endphp

{!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, clean($page->description), $page) !!}
