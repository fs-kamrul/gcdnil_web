@php
    $i = 0;
@endphp
<ul {!! $options !!}>
    @foreach ($menu_nodes as $key => $row)
        <li class="col{{ $i++ }} @if ($row->has_child) mzr-drop @endif @if ($row->active) current-menu-item @endif">
            <a class=" @if ($row->css_class == 'home') Home @else {{ $row->css_class }} @endif @if ($row->has_child) submenu @endif"
               @if ($row->css_class == 'home') style="background-image: url('themes/{{ Theme::getThemeName() }}/images/home_dark.png');margin-top:5px;" @endif
               href="{{ url($row->url) }}"
               @if ($row->target !== '_self')target="{{ $row->target }}" @endif>
                @if ($row->icon_font) <i class="{{ trim($row->icon_font) }}"></i> @endif
                @if($row->css_class == 'home')

                @else {{ $row->title }} @endif
            </a>
            @if ($row->has_child)
                <div class="mzr-content drop-one-columns">
                    <div class="one-col">
                        <h6>{{ $row->title }}</h6>
                        {!! Menus::generateMenu([
                            'menu'       => $menu,
                            'menu_nodes' => $row->child,
                            'view'       => 'menu_custom',
                            'options' => [
                                'class' => 'mzr-links',
                            ]
                        ]) !!}
                    </div>
                </div>
            @endif
        </li>
    @endforeach
</ul>
