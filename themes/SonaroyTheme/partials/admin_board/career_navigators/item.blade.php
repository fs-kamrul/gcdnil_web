<a @if($career_navigator->document != null) href="{{ getImageUrl($career_navigator->document, 'adminboard/admincareernavigator') }}" target="_blank"  @endif  class="ag-courses-item_link">
    <div class="ag-courses-item_bg"></div>

{{--    <a @if($career_navigator->document != null) href="{{ getImageUrl($career_navigator->document, 'adminboard/admincareernavigator') }}" target="_blank"  @endif class="mt-30 line-clamp-2   text-15 font-semibold capitalize leading-6">--}}
{{--        {{ $career_navigator->name }}--}}
{{--    </a>--}}
    <div class="ag-courses-item_title">
        {{ $career_navigator->name }}
    </div>

    @if($career_navigator->start_date)
    <div class="ag-courses-item_date-box">
        @lang('adminboard::lang.start'): {{ date('d M Y', strtotime($career_navigator->start_date)) }}
    </div>
    @endif
</a>

