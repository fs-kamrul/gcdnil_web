<div class="faq">
    <div class="container">
        <div class="row justify-content-center">
            @php
                $wow = 0;
                $increment = 0.2;
            @endphp
            @foreach($option_sets as $key=>$option_set)
                @php
                    $wow = ($key == 6) ? 0 : $wow+$increment;
                @endphp
                {!! Theme::partial('admin_board.option_set.item', ['option_set' => $option_set, 'img_slider' => true, 'wow' => $wow]) !!}
            @endforeach
        </div>
        @if ($option_sets->total() > 0)
            <div class="justify-content-center" style="text-align: center !important;">
                {!! $option_sets->links(Theme::getThemeNamespace() . '::partials.option.pagination') !!}
            </div>
        @endif
    </div>
</div>
