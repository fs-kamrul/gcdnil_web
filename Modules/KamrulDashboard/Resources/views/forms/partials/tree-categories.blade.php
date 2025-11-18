
@php
    $updateTreeRoute ??= null;
@endphp

<div class="dd" data-depth="0" data-empty-text="{{ trans('kamruldashboard::tree-category.empty_text') }}">
    @include('kamruldashboard::forms.partials.tree-category', compact('updateTreeRoute'))
</div>

