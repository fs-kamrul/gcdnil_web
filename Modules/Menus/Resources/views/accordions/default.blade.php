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

    <div id="collapse{{$id}}" class="collapse @isset($show) show @endisset"
    aria-labelledby="heading{{$id}}"
    data-parent="#accordion">
        <div class="card-body box-links-for-menu">
            <form method="get" action="">
                <div class="form-group">
                    <ul class="list-item">
                        @foreach ($urls as $key => $item)
                        <li>
                            <label for="menu-link-{{$id}}-{{$key}}">
                                <input
                                id="menu-link-{{$id}}-{{$key}}"
                                class="" type="checkbox" name="menu_id"
                                value="{{$item['url']}}"
                                data-icon="{{$item['icon']}}"
                                data-url="{{$item['url']}}"
                                data-label="{{$item['label']}}"
                                data-reference-id="{{$item['reference_id']}}"
                                data-reference-type="{{$item['reference_type']}}"
                                >
                                {{ $item['label'] }}
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="form-group">
                    <button type="button" onclick="addItemMenu(this, 'custom')"
                    class="btn btn-info btn-sm float-right mr-2 mb-2">
                        @lang('menus::lang.add_to_menu')
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
