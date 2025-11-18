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

                    @foreach($career_navigators as $key=>$career_navigator)
                        @php
                            $wow = ($key == 6) ? 0 : $wow+$increment;
                        @endphp
                        <div class="ag-courses_item  wow fadeInUp" data-wow-delay="@isset($wow) {{ $wow . 's' }} @endisset">
                            {!! Theme::partial('admin_board.career_navigators.item', ['career_navigator' => $career_navigator, 'img_slider' => true, 'wow' => $wow]) !!}
                        </div>
                    @endforeach
{{--                {!! $career_navigators->withQueryString()->links() !!}--}}

                </div>
            </div>
            @if ($career_navigators->total() > 0)
                <div class="mb-15 " style="padding-bottom: 20px">
                    {!! $career_navigators->links(Theme::getThemeNamespace() . '::partials.admin_board.pagination') !!}
                </div>
            @endif
        </div>
    </div>
</div>


