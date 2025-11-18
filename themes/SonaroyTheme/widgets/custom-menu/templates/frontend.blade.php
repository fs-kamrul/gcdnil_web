{{--<div class="col-lg-4 col-md-6 col-sm-6">--}}
{{--    <div class="important-link">--}}
{{--        <h5>{{ $config['name'] }}</h5>--}}
        {!!
            Menus::generateMenu(['slug' => $config['menu_id'], 'view'    => 'menu_footer','options' => ['class' => '']])
        !!}
{{--    </div>--}}
{{--</div>--}}
