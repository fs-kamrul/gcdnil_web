<div class="w-3/12 mb-10">
    <h3 class="font-medium">@lang('adminboard::lang.recently_published') @lang('adminboard::lang.adminworkshop')</h3>

    <div class="mt-35">

        @foreach($workshops as $workshop)
        <div class="flex items-center mb-5">
            <div
                class="w-10 h-76 bg-primary-blue flex flex-col text-white text-center justify-center shrink-0">
                <p class="text-lg font-bold">{{ date('d', strtotime($workshop->start_date)) }}</p>
                <p class="text-10">{{ date('F', strtotime($workshop->start_date)) }}</p>
                <p class="text-10 mt-1">{{ date('Y', strtotime($workshop->start_date)) }}</p>
            </div>

            <a href="{{ $workshop->url }}" class="ml-15 text-14 leading-relaxed line-clamp-3 hover:text-primary-blue">
                {{ $workshop->name }}
            </a>
        </div>
        @endforeach

        <p class="mt-10 "><a href="{{ url('workshop') }}" class="font-semibold underline underline-offset-4 text-primary-blue">+ @lang('adminboard::lang.more_workshops')</a></p>
    </div>
</div>

