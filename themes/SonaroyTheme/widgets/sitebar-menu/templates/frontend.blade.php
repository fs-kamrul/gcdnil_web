<div class="column block">
    <h5 class="bk-org title internal-eservice">
        <a>{{ $config['name'] }}</a>
    </h5>
        {!!
            Menus::generateMenu(['slug' => $config['menu_id'], 'view'    => 'menu_footer','options' => ['class' => '']])
        !!}
</div>
