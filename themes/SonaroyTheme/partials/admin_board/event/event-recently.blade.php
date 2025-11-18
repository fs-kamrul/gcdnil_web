<div class="w-3/12">
    <h3 class="font-medium">@lang('adminboard::lang.recently_published') @lang('adminboard::lang.adminevent')</h3>

    <div class="mt-35">

        @foreach($events as $event)
        <div class="flex items-center mb-5">
            <div
                class="w-10 h-76 bg-primary-blue flex flex-col text-white text-center justify-center shrink-0">
                <p class="text-lg font-bold">{{ date('d', strtotime($event->start_date)) }}</p>
                <p class="text-10">{{ date('F', strtotime($event->start_date)) }}</p>
                <p class="text-10 mt-1">{{ date('Y', strtotime($event->start_date)) }}</p>
            </div>

            <a href="{{ $event->url }}" class="ml-15 text-14 leading-relaxed line-clamp-3 hover:text-primary-blue">
                {{ $event->name }}
            </a>
        </div>
        @endforeach

        <p class="mt-10 "><a href="{{ url('event') }}" class="font-semibold underline underline-offset-4 text-primary-blue">+ @lang('adminboard::lang.more_events')</a></p>
    </div>
</div>

