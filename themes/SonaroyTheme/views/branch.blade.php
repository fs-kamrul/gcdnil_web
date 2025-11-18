@php

    Theme::set('pageId', $branch->id);

@endphp

{!! apply_filters(BRANCH_FILTER_FRONT_PAGE_CONTENT, clean($branch->description), $branch) !!}
