
<div class="tools">
    @php
        $hiddenIcons = '';
        if (Arr::get($settings, 'show_state', true) && Arr::get($settings, 'state', 'expand') == 'collapse') {
            $hiddenIcons = 'd-none';
        }
    @endphp
    @if (Arr::get($settings, 'show_predefined_ranges', false) && count($predefinedRanges))
        <div class="predefined-ranges ui-select-wrapper d-inline-block {{ $hiddenIcons }}">
            <select name="predefined_range" class="ui-select py-0">
                @foreach ($predefinedRanges as $key => $item)
                    <option value="{{ $item['key'] }}">{{ $item['label'] }}</option>
                @endforeach
            </select>
            <i class="fa fa-sort svg-next-icon svg-next-icon-size-16" aria-hidden="true"></i>
        </div>
    @endif
</div>
