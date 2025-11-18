@if (Arr::get($metaBox, 'before_wrapper'))
    {!! Arr::get($metaBox, 'before_wrapper') !!}
@endif

@if (Arr::get($metaBox, 'wrap', true))
    <x-kamruldashboard::card
        class="mb-3"
        :attributes="new \Illuminate\View\ComponentAttributeBag(Arr::get($metaBox, 'attributes', []))"
    >
        <x-kamruldashboard::card.header>
            @if(($subtitle = Arr::get($metaBox, 'subtitle')) && ($title = Arr::get($metaBox, 'title')))
                <div>
                    <x-kamruldashboard::card.title>{{ $title }}</x-kamruldashboard::card.title>
                    <x-kamruldashboard::card.subtitle>{{ $subtitle }}</x-kamruldashboard::card.subtitle>
                </div>
            @else
                <x-kamruldashboard::card.title>{{ Arr::get($metaBox, 'title') }}</x-kamruldashboard::card.title>
            @endif

            @if (Arr::get($metaBox, 'header_actions'))
                <x-kamruldashboard::card.actions>
                    {!! Arr::get($metaBox, 'header_actions') !!}
                </x-kamruldashboard::card.actions>
            @endif
        </x-kamruldashboard::card.header>

        @if (!($hasTable = Arr::get($metaBox, 'has_table', false)))
            <x-kamruldashboard::card.body>
                {!! Arr::get($metaBox, 'content') !!}
            </x-kamruldashboard::card.body>
        @else
            {!! Arr::get($metaBox, 'content') !!}
        @endif

        @if(($footer = Arr::get($metaBox, 'footer')))
            <x-kamruldashboard::card.footer>
                {!! $footer !!}
            </x-kamruldashboard::card.footer>
        @endif
    </x-kamruldashboard::card>
@else
    {!! Arr::get($metaBox, 'content') !!}
@endif

@if (Arr::get($metaBox, 'after_wrapper'))
    {!! Arr::get($metaBox, 'after_wrapper') !!}
@endif
