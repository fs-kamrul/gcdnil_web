<div class="w-3/12 mb-10">
    <h3 class="font-medium">@lang('adminboard::lang.recently_published') @lang('adminboard::lang.adminnoticeboard')</h3>

    <div class="mt-35">

        @foreach($notice_boards as $notice_board)
        <div class="flex items-center mb-5">
            <div
                class="w-10 h-76 bg-primary-blue flex flex-col text-white text-center justify-center shrink-0">
                <p class="text-lg font-bold">{{ date('d', strtotime($notice_board->created_at)) }}</p>
                <p class="text-10">{{ date('F', strtotime($notice_board->created_at)) }}</p>
                <p class="text-10 mt-1">{{ date('Y', strtotime($notice_board->created_at)) }}</p>
            </div>

            <a href="{{ $notice_board->url }}" class="ml-15 text-14 leading-relaxed line-clamp-3 hover:text-primary-blue">
                {{ $notice_board->name }}
            </a>
        </div>
        @endforeach

        <p class="mt-10 "><a href="{{ url('notice-board') }}" class="font-semibold underline underline-offset-4 text-primary-blue">+ @lang('adminboard::lang.more_notice_boards')</a></p>
    </div>
</div>

