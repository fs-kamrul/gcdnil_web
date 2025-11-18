
<div class="col-10 col-lg-8">


    @if ($slider->title)
        <h2 class="text-white text-uppercase mb-3 animated slideInDown">{!! DboardHelper::clean($slider->title) !!}</h2>
    @endif

    @php
        $subtitle = $slider->getMetaData('subtitle', true);
        $highlightText = $slider->getMetaData('highlight_text', true);
    @endphp
    @if ($subtitle || $highlightText)
        <h4 class="display-3 text-white animated slideInDown mb-4">{!! DboardHelper::clean($subtitle) !!} <span class="text-primary">{!! DboardHelper::clean($highlightText) !!}</span></h4>
    @endif

{{--    @if ($highlightText = $slider->getMetaData('highlight_text', true))--}}
{{--        <h1 class="animated fw-900 text-brand">{!! DboardHelper::clean($highlightText) !!}</h1>--}}
{{--    @endif--}}

    @if ($slider->description)
        <p class="fs-5 fw-medium text-white mb-4 pb-2">{!! DboardHelper::clean($slider->description) !!}</p>
    @endif
    @if ($slider->link)
        <a class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft" href="{{ url($slider->link) }}">
            {!! DboardHelper::clean($slider->getMetaData('button_text', true)) !!}
{{--            <i class="fa fa-arrow-right"></i> --}}
        </a>
{{--        <a href="" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Free Quote</a>--}}
    @endif
</div>
