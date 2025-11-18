<a @if($student_guideline->document != null) href="{{ getImageUrl($student_guideline->document, 'adminboard/adminstudentguideline') }}" target="_blank"  @endif  class="ag-courses-item_link">
    <div class="ag-courses-item_bg"></div>

{{--    <a @if($student_guideline->document != null) href="{{ getImageUrl($student_guideline->document, 'adminboard/admincareernavigator') }}" target="_blank"  @endif class="mt-30 line-clamp-2   text-15 font-semibold capitalize leading-6">--}}
{{--        {{ $student_guideline->name }}--}}
{{--    </a>--}}
    <div class="ag-courses-item_title">
        {{ $student_guideline->name }}
    </div>

    @if($student_guideline->created_at)
    <div class="ag-courses-item_date-box">
        @lang('kamruldashboard::lang.date'): {{ date('d M Y', strtotime($student_guideline->created_at)) }}
    </div>
    @endif
</a>

