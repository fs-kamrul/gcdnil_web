<ul {!! $options !!}>
    <div class="dropdown_box">
        <div class="container">
            <div class="row">
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                    <div class="dropdowm_img_box">
                        <div class="overlay">
                            <h6 class="heading_40 white_text">Start Building Your Career</h6>
                        </div>
                        <img src="{{ url('themes/'. Theme::getThemeName() .'/img/dropdown-img.webp') }}" alt="HRDI Courses">
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                    <div class="course_list short_course mb_30">
{{--                        <h6 class="heading_22 mb_30">Short Courses</h6>--}}
                        <ul>
                            @php
                                $increment_value = 0;
                                $increment_number = 6;
                                $total_value = 6;
                            @endphp
                        @foreach ($menu_nodes as $key => $row)
                                @php
                                    $increment_value++;
                                    if($total_value + 1 == $increment_value){
                                        $total_value += $increment_number;
                                    }
                                @endphp
                                @if ($row->css_class == 'heading_22')
{{--                                    <div class="course_list short_course mb_30">--}}
                                    <h6 class="heading_22 mb_30">{{ $row->title }}</h6>
                                @else
                                    <li>
                                        <a  class="dropdown-link @if ($row->css_class) {{ $row->css_class }} @endif" href="{{ url($row->url) }}" @if ($row->target !== '_self') target="{{ $row->target }}" @endif>
                                            @if ($row->icon_font) <i class="{{ trim($row->icon_font) }}"></i> @endif
                                            {{ $row->title }}
                                        </a>
                                        @php
                                            if ($row->has_child){
                                                $class = 'sub-menu-container';
                                            }else{
                                                $class = 'sub-menu-container';
                                            }
                                        @endphp
                                        @if ($row->has_child)
                                            {!! Menus::generateMenu([
                                                'menu'       => $menu,
                                                'menu_nodes' => $row->child,
                                                'view'       => 'menu_custom_mega',
                                                'options' => [
                                                    'class' => $class,
                                                ]
                                            ]) !!}
                                        @endif
                                    </li>
                                @endif
                            @if ($increment_value == $total_value && $menu_nodes->count() != $total_value)
                        </ul>
                    </div>
                    @if (($increment_number * 2) == $total_value && $menu_nodes->count() != $total_value)

                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                    @endif

                    <div class="course_list medical_course mb_30">
{{--                        <h6 class="heading_22 mb_30">Medical Ultrasound</h6>--}}
                        <ul>
                            @endif
                        @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</ul>
