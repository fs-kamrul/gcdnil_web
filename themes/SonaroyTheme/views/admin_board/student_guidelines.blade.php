@php
//    $layout = ($layout && in_array($layout, array_keys(get_blog_single_layouts()))) ? $layout : 'post-full-width';
//    Theme::layout($layout);
@endphp
<div class="sylaabus">
    <div class="container">
        <div class="row justify-content-center">
            <div class="ag-format-container">
                <div class="ag-courses_box">
                    @php
                        $wow = 0;
                        $increment = 0.2;
                    @endphp

                    @foreach($student_guidelines as $key=>$student_guideline)
                        @php
                            $wow = ($key == 6) ? 0 : $wow+$increment;
                        @endphp
                        <div class="ag-courses_item  wow fadeInUp" data-wow-delay="@isset($wow) {{ $wow . 's' }} @endisset">
                            {!! Theme::partial('admin_board.student_guidelines.item', ['student_guideline' => $student_guideline, 'img_slider' => true, 'wow' => $wow]) !!}
                        </div>
                    @endforeach
{{--                {!! $student_guidelines->withQueryString()->links() !!}--}}

                </div>
            </div>
            @if ($student_guidelines->total() > 0)
                <div class="mb-15 " style="padding-bottom: 20px">
                    {!! $student_guidelines->links(Theme::getThemeNamespace() . '::partials.admin_board.pagination') !!}
                </div>
            @endif
        </div>
    </div>
</div>


