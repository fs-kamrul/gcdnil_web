<ul {!! $options !!}>
    @foreach ($menu_nodes as $key => $row)
        <li class="nav-item @if ($row->has_child) dropdown @endif @if ($row->active) current-menu-item @endif">
            <a class="nav-link @if ($row->has_child) dropdown-toggle @endif"
               @if ($row->has_child) data-bs-toggle="dropdown" aria-expanded="false" @else data-bs-toggle="modal" data-bs-target="#searchModal" @endif
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
                    @elseif($row->css_class == 'searchModal')
                        <i class="ri-search-line nav_search"></i>
                    @else{{ $row->title }} @endif
            </a>
            @if($row->css_class == 'searchModal')
                <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal_top">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form action="">
                                    <div class="form_group">
                                        <input type="text" placeholder="search">
                                        <button type="submit">@lang('Search')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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
