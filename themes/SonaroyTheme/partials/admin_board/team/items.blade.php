
<div
    class="mt-100 flex flex-col sm:flex-wrap sm:flex-row gap-5 xs:items-center sm:justify-center lg:flex-row lg:flex-nowrap">
       @foreach($teams as $key=>$team)
        <div
            class="w-full xs:w-4/6 sm:w-45 shrink-0 rounded-26 @if($key == 0) bg-primary-dark text-white @else bg-background-sky-2 @endif px-28 py-30 transition duration-200 ease-linear hover:bg-primary-blue xl:w-23p lg:w-22p">
                {!! Theme::partial('admin_board.teams.item', ['team' => $team, 'img_slider' => true]) !!}
            </div>
        @endforeach

</div>
