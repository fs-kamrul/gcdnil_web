<ul {!! $options !!}>
    @foreach ($menu_nodes as $key => $row)
        <li class="@if ($row->has_child) dropdown @endif @if ($row->active) current-menu-item @endif">
            <a class="dropdown-item @if ($row->has_child) dropdown-toggle @endif"
               @if ($row->has_child) data-bs-toggle="dropdown" aria-expanded="false" @endif
               href="{{ url($row->url) }}" @if ($row->target !== '_self') target="{{ $row->target }}" @endif>
                @if ($row->icon_font) <i class="{{ trim($row->icon_font) }}"></i> @endif @if($row->css_class == 'grid_css')
                        <div class="nav_others">
                            <div class="nav_others_wrapper">
                                <div class="nav_others_box"></div>
                                <div class="nav_others_box"></div>
                            </div>
                            <div class="nav_others_wrapper">
                                <div class="nav_others_box"></div>
                                <div class="nav_others_box"></div>
                            </div>
                        </div>
                        <div class="sm_dropdown">{{ $row->title }} <i class="ri-arrow-down-s-line"></i></div>
                    @else {{ $row->title }} @endif
            </a>
            @if ($row->has_child)
                {!! Menus::generateMenu([
                    'menu'       => $menu,
                    'menu_nodes' => $row->child,
                    'view'       => 'menu_right_sub',
                    'options' => [
                        'class' => 'dropdown-menu dropdown-menu-end',
                    ]
                ]) !!}
            @endif
        </li>
    @endforeach
</ul>
{{--@if ($row->css_class == 'border-button') {{ $row->css_class }} @else nav-link @endif--}}
