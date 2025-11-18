<div class="w-3/12 mb-10">
    <h3 class="font-medium">@lang('adminboard::lang.recently_published') @lang('adminboard::lang.admincareernavigator')</h3>

    <div class="mt-35">

        @foreach($career_navigators as $career_navigator)
        <div class="flex items-center mb-5">
            <div
                class="w-10 h-76 bg-primary-blue flex flex-col text-white text-center justify-center shrink-0">
                <p class="text-lg font-bold">{{ date('d', strtotime($career_navigator->start_date)) }}</p>
                <p class="text-10">{{ date('F', strtotime($career_navigator->start_date)) }}</p>
                <p class="text-10 mt-1">{{ date('Y', strtotime($career_navigator->start_date)) }}</p>
            </div>

            <a href="{{ $career_navigator->url }}" class="ml-15 text-14 leading-relaxed line-clamp-3 hover:text-primary-blue">
                {{ $career_navigator->name }}
            </a>
        </div>
        @endforeach

        <p class="mt-10 "><a href="{{ url('career-navigator') }}" class="font-semibold underline underline-offset-4 text-primary-blue">+ @lang('adminboard::lang.more_career_navigators')</a></p>
    </div>
</div>

