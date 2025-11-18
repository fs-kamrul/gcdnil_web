<style>
    .club-group{
        margin-top: 30px;
    }
</style>
<div class="club-group">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    {!! Theme::partial('admin_board.admin_club.items', ['admin_clubs' => $admin_clubs, 'img_slider' => true]) !!}
                </div>
                <div class="justify-content-center" style="text-align: center !important;">
                    @if ($admin_clubs->total() > 0)
                        {!! $admin_clubs->links(Theme::getThemeNamespace() . '::partials.admin_board.pagination') !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
