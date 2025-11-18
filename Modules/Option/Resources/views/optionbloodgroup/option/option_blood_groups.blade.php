<div class="faq">
    <div class="container">
        <div class="row justify-content-center">
            @php
                $wow = 0;
                $increment = 0.2;
            @endphp
            @foreach($option_blood_groups as $key=>$option_blood_group)
                @php
                    $wow = ($key == 6) ? 0 : $wow+$increment;
                @endphp
                {!! Theme::partial('admin_board.option_blood_group.item', ['option_blood_group' => $option_blood_group, 'img_slider' => true, 'wow' => $wow]) !!}
            @endforeach
        </div>
        @if ($option_blood_groups->total() > 0)
            <div class="justify-content-center" style="text-align: center !important;">
                {!! $option_blood_groups->links(Theme::getThemeNamespace() . '::partials.option.pagination') !!}
            </div>
        @endif
    </div>
</div>
