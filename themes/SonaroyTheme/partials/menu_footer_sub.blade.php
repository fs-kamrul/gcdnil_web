{{--<ul {!! $options !!}>--}}
    @foreach ($menu_nodes as $key => $row)
        <li class="@if ($row->css_class) {{ $row->css_class }} @endif" data-aos="fade-up" data-aos-delay="200">
            @if ($row->icon_font) <i class="{{ trim($row->icon_font) }}"></i> @endif
            <a href="{{ url($row->url) }}" @if ($row->target !== '_self') target="{{ $row->target }}" @endif>
{{--                <i class="@if ($row->icon_font !== '_self') target="{{ $row->icon_font }}" @endif"></i>--}}
               {{ $row->title }}
            </a>
            @if ($row->has_child)
                {!! Menus::generateMenu([
                    'menu'       => $menu,
                    'menu_nodes' => $row->child,
                    'view'       => 'menu_footer_sub',
                    'options' => [
                        'class' => 'sub-menu text-muted font-small',
                    ]
                ]) !!}
            @endif
        </li>
    @endforeach
{{--</ul>--}}
