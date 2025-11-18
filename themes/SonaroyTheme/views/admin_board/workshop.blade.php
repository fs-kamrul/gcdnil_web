<section class="mt-100">
    <div class="xl:max-w-container mx-auto">
        <h1 class="text-23 font-bold capitalize text-primary-dark lg:text-43">
                <span
                    class="after:content[''] relative z-20 after:absolute after:bottom-3 after:left-0 after:top-1.5 after:-z-10 after:h-22 after:w-full after:bg-text-highlight lg:after:top-5">
                    {{ __('Workshops') }}</span>
        </h1>
        <div class="flex justify-between mt-10">
            <div class="w-8/12 pr-10">
                <div>
                    <h2 class="text-xl font-bold leading-relaxed">{{ $workshop->name }}</h2>

                    <div class="w-full h-full mt-35">
                        <img src="{{ getImageUrl($workshop->photo,'adminboard/adminworkshop') }}" alt="{{ $workshop->name }}"
                             class="w-full h-332 object-cover rounded-30">
                    </div>
{{--                    <h3 class="text-center px-5 mt-18 text-xs font-semibold leading-relaxed">Mr. Anik Brahmachari,HR--}}
{{--                        professional and Global Member of SHRM (USA) along with the participants at the workshop--}}
{{--                        entitled “Let’s Map Your Way to Excellence”</h3>--}}
                    <div class="mt-42">
                        <div class="mb-5 flex items-center">
                        <span class="mr-4 flex h-8 w-8 items-center justify-center rounded-full bg-background-sky-2 text-lg">
                            <i class="ri-map-pin-fill"></i></span>
                            <p class="font-pop text-sm font-normal text-p-color">
                                {{ $workshop->location }}
                            </p>
                        </div>

                        <div class="flex items-center">
                        <span class="mr-4 flex h-8 w-8 items-center justify-center rounded-full bg-background-sky-2 text-lg">
                            <i class="ri-time-fill"></i></span>
                            <p class="font-pop text-sm font-normal text-p-color">
                                {{ $workshop->set_time }}, {{ date('d F Y', strtotime($workshop->start_date)) }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-44 text-sm leading-7 mb-10">
                        <p class="mb-5 ">
                            {!! clean($workshop->description) !!}
                        </p>
                    </div>

{{--                    <div class="flex gap-3 mt-10">--}}
{{--                        <a href="#"--}}
{{--                           class="w-7 h-7 bg-primary-blue rounded-full flex justify-center items-center text-white text-lg hover:text-text-highlight ease-in-out duration-200"><i--}}
{{--                                class="ri-facebook-fill"></i></a>--}}
{{--                        <a href="#"--}}
{{--                           class="w-7 h-7 bg-primary-blue rounded-full flex justify-center items-center text-white text-lg hover:text-text-highlight ease-in-out duration-200 "><i--}}
{{--                                class="ri-twitter-fill"></i></a>--}}
{{--                        <a href="#"--}}
{{--                           class="w-7 h-7 bg-primary-blue rounded-full flex justify-center items-center text-white text-lg hover:text-text-highlight ease-in-out duration-200"><i--}}
{{--                                class="ri-instagram-line"></i></a>--}}
{{--                    </div>--}}
                </div>
            </div>

            {!! Theme::partial('admin_board.workshops.workshop-recently', compact('workshops')) !!}
        </div>
    </div>
</section>
{{--{!! $workshop->status->toHtml() !!}--}}


<section class="mb-130 mt-20 bg-white px-4 lg:mt-32 lg:px-0">
    <div class="mx-auto xl:max-w-container lg:max-w-lg-container xs:max-w-xs-container sm:max-w-sm-container md:mt-172 sm:px-4 lg:px-0">
        <div class="flex flex-col items-center text-center sm:px-4 lg:px-0">
            <h2 class="font-pop text-23 font-bold capitalize text-primary-dark lg:text-43">
                @lang('Upcoming')
                <span
                    class="after:content[''] relative z-20 after:absolute after:bottom-3 after:left-0 after:top-1.5 after:-z-10 after:h-22 after:w-full after:bg-text-highlight lg:after:top-5">
                    @lang('Events')</span>
            </h2>
            {{--            <p class="mt-30 max-w-603 font-pop text-base font-normal text-p-color">--}}
            {{--                {{ $shortcode->contain }}--}}
            {{--            </p>--}}
        </div>

        @php
            $adminBoardRepository = app(\Modules\AdminBoard\Repositories\Interfaces\AdminWorkshopInterface::class);
            $upcoming_workshop = $adminBoardRepository->advancedGet(array_merge([
                'take' => 1,
                'order_by' => ['start_date' => 'desc'],
            ]));
        @endphp
        <div class="mt-90 justify-between lg:flex sm:px-4 lg:px-0">
            <div class="mb-20 w-full lg:mb-0 lg:w-45">
                <img src="{{ getImageUrl($upcoming_workshop->photo, 'adminboard/adminworkshop') }}" alt="{{ $upcoming_workshop->name }}"
                     class="block h-full w-full rounded-xl object-cover lg:rounded-30" />
            </div>

            <div class="w-full lg:w-45">
                <h3 class="font-pop text-xl font-bold tracking-wide lg:text-22">
                    {{ $upcoming_workshop->name }}
                </h3>
                <p class="mt-30 line-clamp-3 font-pop text-sm font-normal text-p-color lg:text-base">
                    {!! description_summary($upcoming_workshop->description) !!}
                </p>

                <div class="mt-42">
                    <div class="mb-5 flex items-center">
                        <span class="mr-4 flex h-8 w-8 items-center justify-center rounded-full bg-background-sky-2 text-lg">
                            <i class="ri-map-pin-fill"></i></span>
                        <p class="font-pop text-sm font-normal text-p-color">
                            {{ $upcoming_workshop->location }}
                        </p>
                    </div>

                    <div class="flex items-center">
                        <span class="mr-4 flex h-8 w-8 items-center justify-center rounded-full bg-background-sky-2 text-lg">
                            <i class="ri-time-fill"></i></span>
                        <p class="font-pop text-sm font-normal text-p-color">
                            {{ $upcoming_workshop->set_time }}, {{ date('d F Y', strtotime($upcoming_workshop->start_date)) }}
                        </p>
                    </div>
                </div>

                <a href="{{ $upcoming_workshop->url }}"
                   class="before:btn_clip before:content[''] hover:before:btn_clip_hover relative mt-30 inline-block overflow-hidden rounded-full bg-primary-blue px-5 py-2.5 font-pop text-base font-normal uppercase text-white before:absolute before:inset-0 before:duration-500 before:ease-in-out hover:before:bg-black">
                    <span class="relative z-10">@lang('View')</span></a>
            </div>
        </div>
        {!! Theme::partial('admin_board.workshops.items', ['workshops' => $up_workshops, 'img_slider' => true]) !!}

    </div>
</section>
