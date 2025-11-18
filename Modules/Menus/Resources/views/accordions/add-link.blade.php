@php
    $id = rand(100000, 999999);
@endphp
<div class="card">
    <div class="card-header" id="heading-{{$id}}">
        <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse"
            data-target="#collapse{{$id}}"
            aria-expanded="true" aria-controls="collapse{{$id}}">
                @lang('menus::lang.'.$name)
                <i class="fa fa-angle-down narrow-icon float-right"></i>
            </button>
        </h5>
    </div>

    <div id="collapse{{$id}}" class="collapse"
    aria-labelledby="heading{{$id}}"
    data-parent="#accordion">
        <div class="card-body">
            <form method="GET">
                <div class="form-group">
                    <label for="label">@lang('menus::lang.enter_Label')</label>
                    <input type="text" class="form-control" name="label" placeholder="@lang('menus::lang.label_menu')">
                </div>
                <div class="form-group">
                    <label for="url">@lang('menus::lang.enter_url')</label>
                    <input type="text" class="form-control" name="url" placeholder="#">
                </div>
                <div class="form-group">
                    <label for="icon">@lang('menus::lang.enter_icon')</label>
                    <input type="text" class="form-control" id="iconHelp" name="icon" placeholder="@lang('menus::lang.icon')">
                    <small id="iconHelp" class="form-text text-muted">
                        @lang('menus::lang.exam_icon_set')
                    </small>
                </div>
                <div class="form-group">
                    <button type="button" onclick="addItemMenu(this, 'default')"
                    class="btn btn-info btn-sm float-right mr-2 mb-2">
                        @lang('menus::lang.add_to_menu')
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
