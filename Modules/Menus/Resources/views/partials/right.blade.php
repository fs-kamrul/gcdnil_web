<div class="card mt-2">
    <div class="card-body">
        <div class="row">
            <form class="form-inline" action="" method="post">
            <div class="col-md-12">
                    <div class="form-group">
                        <label for="email" class="mr-sm-2">@lang('menus::lang.name'): </label>
                        <input name="menu-name" id="menu-name" type="text"
                        class="form-control menu-name regular-text menu-item-textbox"
                        title="@lang('menus::lang.enter_menu_name')" value="@if(isset($indmenu)){{$indmenu->name}}@endif">
                        @if(request()->has('action'))
                            <button type="button" onclick="createNewMenu()" name="save_menu"
                                class="btn btn-primary menu-save ml-2">@lang('menus::lang.create_menu')</button>
                        @elseif(request()->has('menu'))
                            <button type="button" onclick="actualizarMenu(false)" name="save_menu"
                                class="btn btn-primary menu-save ml-2">@lang('menus::lang.save_menu')</button>
                        @else
                            <button type="button" onclick="createNewMenu()" name="save_menu"
                                class="btn btn-primary menu-save ml-2">@lang('menus::lang.create_menu')</button>
                        @endif
                    </div>
                <hr>
            </div>
                <div class=" col-md-12 mt-3">
                    @if(request()->get('menu') != 0 && isset($menus) && count($menus) > 0)
                        <div class="jumbotron jumbotron-fluid p-2">
                            <div class="container">
                                <h3>@lang('menus::lang.menu_structure')</h3>
                                <p class="lead">@lang('menus::lang.menu_structure_configuration_information')</p>
                            </div>
                        </div>
                    @elseif(request()->get('menu') == 0)
                        <div class="jumbotron jumbotron-fluid p-2">
                            <div class="container">
                                <h3>@lang('menus::lang.menu_creation')</h3>
                                <p class="lead">@lang('menus::lang.menu_creation_information')</p>
                            </div>
                        </div>
                    @else
                        <div class="jumbotron jumbotron-fluid p-2">
                            <div class="container">
                                <h3>@lang('menus::lang.create_menu_item')</h3>
                                <p class="lead"></p>
                            </div>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <span>{{ trans('menus::lang.menu_settings') }}</span>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="col-md-4">
                                    <p><i>{{ trans('menus::lang.display_location') }}</i></p>
                                </div>
                                <div class="col-md-8">
                                    @foreach (Menus::getMenuLocations() as $location => $description)
                                        <div>
                                            <input type="checkbox" @if (in_array($location, $locations)) checked @endif class="locations_menu"  name="locations" value="{{ $location }}" id="menu_location_{{ $location }}">
                                            <label style="display: initial;" for="menu_location_{{ $location }}">{{ $description }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-md-12">


                <div id="accordion" class="">
                    @php
                        $menus_sub = 0;
                    @endphp
                    @if(isset($menus) && count($menus) > 0)
                    <div class="dd nestable-menu" id="nestable">
                        <ol class="dd-list">
                            @foreach($menus as $key => $m)
                                @include('menus::partials.loop-item', ['key' => $key])
                            @endforeach
                        </ol>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(request()->get('menu') != 0)
    <div class="card-footer">
        <button type="button" class="btn btn-danger btn-sm submitdelete deletion menu-delete"
            onclick="deleteMenu()" href="javascript:void(9)">@lang('menus::lang.delete_menu')
        </button>
        @if(isset($menus) && count($menus) > 0)
        <button type="button" class="btn btn-info btn-sm"
            onclick="updateItem()" href="javascript:void(9)">@lang('menus::lang.update_all_item')
        </button>
        @endif
    </div>
    @endif
</div>
