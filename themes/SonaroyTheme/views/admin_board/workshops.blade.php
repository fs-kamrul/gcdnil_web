@php
//    $layout = ($layout && in_array($layout, array_keys(get_blog_single_layouts()))) ? $layout : 'post-full-width';
//    Theme::layout($layout);
@endphp
<section class="mb-85 bg-white px-4 lg:mt-100 lg:px-0">
    <div
        class="mx-auto xl:max-w-container lg:max-w-lg-container xs:max-w-xs-container sm:max-w-sm-container sm:px-4 lg:px-0">
        <div class="flex flex-col items-center text-center sm:px-4 lg:px-0">
            <h2 class="text-23 font-bold capitalize text-primary-dark lg:text-43">
                <span
                    class="after:content[''] relative z-20 after:absolute after:bottom-3 after:left-0 after:top-1.5 after:-z-10 after:h-22 after:w-full after:bg-text-highlight lg:after:top-5">
                    {{ __('All workshops') }}
                </span>
            </h2>
        </div>

        <div class="mt-10 flex flex-col flex-wrap sm:flex-row gap-5 xs:items-center sm:justify-center">

            @foreach($workshops as $key=>$workshop)
                <div
                    class="w-full xs:w-4/6 sm:w-45 shrink-0 rounded-26 @if($key == 0) bg-primary-dark text-white @else bg-background-sky-2 @endif px-28 py-30 transition duration-200 ease-linear hover:bg-primary-blue xl:w-23p lg:w-22p">
                    {!! Theme::partial('admin_board.workshops.item', ['workshop' => $workshop, 'img_slider' => true]) !!}
                </div>
            @endforeach
                @if ($workshops->total() > 0)
                    {!! $workshops->links(Theme::getThemeNamespace() . '::partials.admin_board.pagination') !!}
                @endif
{{--                {!! $workshops->withQueryString()->links() !!}--}}

        </div>
    </div>
</section>


