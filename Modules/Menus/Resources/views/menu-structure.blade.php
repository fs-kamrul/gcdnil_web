@php
//dd($menu);
@endphp
@if (!empty($menu) && $menu->id)
    <input type="hidden" name="deleted_nodes">
    <textarea name="menu_nodes" id="nestable-output" class="form-control hidden"></textarea>
    <div class="row widget-menu">
        <div class="col-md-4">
            <div class="panel-group" id="accordion">

                @php do_action(MENU_ACTION_SIDEBAR_OPTIONS) @endphp

                <div class="widget meta-boxes">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCustomLink">
                        <h4 class="widget-title">
                            <span>{{ trans('menus::lang.add_link') }}</span>
                            <i class="fa fa-angle-down narrow-icon"></i>
                        </h4>
                    </a>
                    <div id="collapseCustomLink" class="panel-collapse collapse">
                        <div class="widget-body">
                            <div class="box-links-for-menu">
                                <div id="external_link" class="the-box">
                                    <div class="node-content">
                                        <div class="form-group mb-3">
                                            <label for="node-title">{{ trans('menus::lang.title') }}</label>
                                            <input type="text" class="form-control" id="node-title" autocomplete="false">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="node-url">{{ trans('menus::lang.url') }}</label>
                                            <input type="text" class="form-control" id="node-url" placeholder="http://" autocomplete="false">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="node-icon">{{ trans('menus::lang.icon') }}</label>
                                            <input type="text" class="form-control" id="node-icon" placeholder="fa fa-home" autocomplete="false">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="node-css">{{ trans('menus::lang.css_class') }}</label>
                                            <input type="text" class="form-control" id="node-css" autocomplete="false">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="target">{{ trans('menus::lang.target') }}</label>
                                            <div class="ui-select-wrapper">
                                                <select name="target" class="ui-select form-control" id="target">
                                                    <option value="_self">{{ trans('menus::lang.self_open_link') }}</option>
                                                    <option value="_blank">{{ trans('menus::lang.blank_open_link') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="text-end form-group node-actions hidden">
                                            <a class="btn red btn-remove" href="#">{{ trans('menus::lang.remove') }}</a>
                                            <a class="btn blue btn-cancel" href="#">{{ trans('menus::lang.cancel') }}</a>
                                        </div>

                                        <div class="form-group mb-3">
                                            <div class="text-end add-button">
                                                <div class="btn-group">
                                                    <a href="#" class="btn-add-to-menu btn btn-primary"><span class="text"><i class="fa fa-plus"></i> {{ trans('menus::lang.add_to_menu') }}</span></a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="widget meta-boxes">
                <div class="widget-title">
                    <h4>
                        <span>{{ trans('menus::lang.structure') }}</span>
                    </h4>
                </div>
                <div class="widget-body">
                    <div class="dd nestable-menu" id="nestable" data-depth="0">
                        {!!
                             Menus::generateMenu([
                                'menu'   => $menu,
                                'slug'   => $menu->slug,
                                'view'   => 'menus::partials.menu',
                                'theme'  => false,
                                'active' => false,
                             ])
                        !!}
                    </div>
                </div>
            </div>

            @if (defined('THEME_MODULE_SCREEN_NAME'))
                <div class="widget meta-boxes">
                    <div class="widget-title">
                        <h4>
                            <span>{{ trans('menus::lang.menu_settings') }}</span>
                        </h4>
                    </div>
                    <div class="widget-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p><i>{{ trans('menus::lang.display_location') }}</i></p>
                            </div>
                            <div class="col-md-8">
                                @foreach (Menus::getMenuLocations() as $location => $description)
                                    <div>
                                        <input type="checkbox" @if (in_array($location, $locations)) checked @endif  name="locations[]" value="{{ $location }}" id="menu_location_{{ $location }}">
                                        <label for="menu_location_{{ $location }}">{{ $description }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif
