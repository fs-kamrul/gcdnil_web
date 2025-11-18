<div class="faq">
    <div class="container">
        <div class="row justify-content-center">
            @php
                $wow = 0;
                $increment = 0.2;
            @endphp
            @foreach($events as $key=>$event)
                @php
                    $wow = ($key == 6) ? 0 : $wow+$increment;
                @endphp
                {!! Theme::partial('admin_board.event.item', ['event' => $event, 'img_slider' => true, 'wow' => $wow]) !!}
            @endforeach
            {{--                {!! $event->withQueryString()->links() !!}--}}
        </div>

        @if ($events->total() > 0)
            <div class="justify-content-center" style="text-align: center !important;">
                {!! $events->links(Theme::getThemeNamespace() . '::partials.admin_board.pagination') !!}
            </div>
        @endif
    </div>
</div>
