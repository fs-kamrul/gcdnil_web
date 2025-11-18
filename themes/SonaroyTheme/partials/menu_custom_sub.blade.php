<div class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">aaaa</a>
    <div class="dropdown-menu fade-up m-0">
        @foreach ($menu_nodes as $key => $row)
{{--        <li class="menu-item @if ($row->has_child) @endif @if ($row->css_class) {{ $row->css_class }} @endif">--}}
{{--            @if ($row->icon_font) <i class="{{ trim($row->icon_font) }}"></i> @endif--}}

                <a class="dropdown-item"
                   href="{{ url($row->url) }}" @if ($row->target !== '_self') target="{{ $row->target }}" @endif >
                    <div>{{ $row->title }}</div>
                </a>
                @if ($row->has_child)
                    {!! Menus::generateMenu([
                        'menu'       => $menu,
                        'menu_nodes' => $row->child,
                        'view'       => 'menu_custom_sub',
                        'options' => [
                            'class' => 'sub-menu-container',
                        ]
                    ]) !!}
            @endif
    @endforeach
            </div>
</div>
