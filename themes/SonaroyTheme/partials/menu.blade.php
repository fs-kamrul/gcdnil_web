<ul {!! $options !!}>
    @foreach ($menu_nodes as $key => $row)
        <li class="nav-item @if ($row->has_child) menu-item-has-children @endif @if ($row->active) current-menu-item @endif">
            <a class=" @if ($row->css_class == 'border-button') {{ $row->css_class }} @else nav-link @endif" href="{{ url($row->url) }}" @if ($row->target !== '_self') target="{{ $row->target }}" @endif>
                @if ($row->icon_font) <i class="{{ trim($row->icon_font) }}"></i> @endif @if($row->css_class == 'grid_css')
                        <img class="grid2" src="{{ asset('themes/'. Theme::getThemeName() .'/img/grid.png') }}" alt="{{ $row->title }}">
                    @else {{ $row->title }} @endif
            </a>
            @if ($row->has_child)
                {!! Menus::generateMenu([
                    'menu'       => $menu,
                    'menu_nodes' => $row->child,
                    'view'       => 'menu',
                    'options' => [
                        'class' => 'sub-menu text-muted font-small',
                    ]
                ]) !!}
            @endif
        </li>
    @endforeach
</ul>
