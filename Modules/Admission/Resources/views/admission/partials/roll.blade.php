@if (Auth::user()->can('admission_access'))
    <a  data-type="text" data-pk="{{ $item->id }}" data-url="{{ route('update-roll-by') }}" data-value="{{ $item->roll ?? 0 }}" data-title="{{ trans('kamruldashboard::tables.order') }}" class="editable" href="#">{{ $item->roll ?? 0 }}</a>
@else
    {{ $item->roll }}
@endif
