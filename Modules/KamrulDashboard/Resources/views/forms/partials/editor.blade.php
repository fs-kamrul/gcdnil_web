@if (!Arr::get($attributes, 'without-buttons', false))
    @php
        $id = Arr::get($attributes, 'id', $name);
    @endphp
    <div class="card">
        <div class="card-body">
        <x-kamruldashboard::button
            type="button"
            data-result="{{ $id }}"
            class="btn btn-secondary show-hide-editor-btn"
        >
            {{ trans('kamruldashboard::forms.show_hide_editor') }}
        </x-kamruldashboard::button>
            <div class="btn-group" role="group">
                <div class="basic-dropdown editor-action-item">
                    <div class="dropdown">
                        <x-kamruldashboard::button
                            type="button"
                            icon="ti ti-photo"
                            class="btn btn-primary dropdown-toggle add_shortcode_btn_trigger"
                            data-result="{{ $id }}"
                {{--            data-multiple="true"--}}
                            data-toggle="dropdown"
                            data-bs-toggle="dropdown"
                {{--            data-action="media-insert-{{ DboardHelper::getRichEditor() }}"--}}
                        >
                            {{ trans('kamruldashboard::forms.short_code') }}
                        </x-kamruldashboard::button>
                        <ul class="dropdown-menu">
                            @php $item_data = array(); @endphp
                            @foreach (shortcode()->getAll() as $key => $item)
                                @if ($item['name'])
                                    @php array_push($item_data,$item['key']); @endphp<li>
                                        <a
                                            href="{{ route('short-codes.ajax-get-admin-config', $key) }}"
                                            data-has-admin-config="{{ Arr::has($item, 'admin_config') }}"
                                            data-key="{{ $key }}"
                                            data-description="{{ $item['description'] }}"
                                            data-preview-image="{{ Arr::get($item, 'previewImage') }}"
                                        >
                                            {{ $item['name'] }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        {!! apply_filters(BASE_FILTER_FORM_EDITOR_BUTTONS, null, $attributes, $id) !!}
        </div>
    </div>

    @push('header')
        {!! apply_filters(BASE_FILTER_FORM_EDITOR_BUTTONS_HEADER, null, $attributes, $id) !!}
    @endpush

    @push('footer')
        {!! apply_filters(BASE_FILTER_FORM_EDITOR_BUTTONS_FOOTER, null, $attributes, $id) !!}
    @endpush
@else
    @php Arr::forget($attributes, 'with-short-code'); @endphp
@endif

{!! call_user_func_array([Form::class, DboardHelper::getRichEditor()], [$name, $value, $attributes]) !!}
{{--@if (Arr::get($attributes, 'without-buttons', false) != true)--}}
{{--    <div class="d-flex mb-2">--}}
{{--        @php $result = Arr::get($attributes, 'id', $name); @endphp--}}
{{--        <div class="d-inline-block editor-action-item action-show-hide-editor">--}}
{{--            <button class="btn btn-primary show-hide-editor-btn" type="button" data-result="{{ $result }}">{{ trans('kamruldashboard::forms.show_hide_editor') }}</button>--}}
{{--        </div>--}}
{{--        <div class="d-inline-block editor-action-item">--}}
{{--            <a href="#" class="btn_gallery btn btn-primary"--}}
{{--               data-result="{{ $result }}"--}}
{{--               data-multiple="true"--}}
{{--               data-action="media-insert-{{ DboardHelper::getRichEditor() }}">--}}
{{--                <i class="far fa-image"></i> {{ trans('media::media.add') }}--}}
{{--            </a>--}}
{{--        </div>--}}
{{--        @if (function_exists('shortcode') && Arr::get($attributes, 'with-short-code', false) == true)--}}
{{--            <div class="d-inline-block editor-action-item list-shortcode-items">--}}
{{--                <div class="dropdown">--}}
{{--                    <button class="btn btn-primary dropdown-toggle add_shortcode_btn_trigger" data-result="{{ $result }}" type="button" data-bs-toggle="dropdown"><i class="fa fa-code"></i> {{ trans('kamruldashboard::forms.short_code') }}--}}
{{--                    </button>--}}
{{--                    <ul class="dropdown-menu">--}}
{{--                        @foreach (shortcode()->getAll() as $key => $item)--}}
{{--                            @if ($item['name'])--}}
{{--                                <li>--}}
{{--                                    <a href="{{ route('short-codes.ajax-get-admin-config', $key) }}" data-has-admin-config="{{ Arr::has($item, 'admin_config') }}" data-key="{{ $key }}" data-description="{{ $item['description'] }}">{{ $item['name'] }}</a>--}}
{{--                                </li>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            @once--}}
{{--                @push('footer')--}}
{{--                    <div class="modal fade short_code_modal" tabindex="-1" role="dialog">--}}
{{--                        <div class="modal-dialog modal-md">--}}
{{--                            <div class="modal-content">--}}
{{--                                <div class="modal-header bg-primary">--}}
{{--                                    <h4 class="modal-title"><i class="til_img"></i><strong>{{ trans('kamruldashboard::forms.add_short_code') }}</strong></h4>--}}
{{--                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>--}}
{{--                                </div>--}}

{{--                                <div class="modal-body with-padding">--}}
{{--                                    <form class="form-horizontal short-code-data-form">--}}
{{--                                        <input type="hidden" class="short_code_input_key">--}}

{{--                                        @include('kamruldashboard::elements.loading')--}}

{{--                                        <div class="short-code-admin-config"></div>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                                <div class="modal-footer">--}}
{{--                                    <button type="button" class="float-start btn btn-secondary" data-bs-dismiss="modal">{{ trans('kamruldashboard::tables.cancel') }}</button>--}}
{{--                                    <button type="button" class="float-end btn btn-primary add_short_code_btn" data-add-text="{{ trans('kamruldashboard::forms.add') }}" data-update-text="{{ trans('kamruldashboard::forms.update') }}">{{ trans('kamruldashboard::forms.add') }}</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endpush--}}
{{--            @endonce--}}
{{--        @endif--}}

{{--        {!! apply_filters(BASE_FILTER_FORM_EDITOR_BUTTONS, null) !!}--}}
{{--    </div>--}}
{{--    <div class="clearfix"></div>--}}
{{--@else--}}
{{--    @php Arr::forget($attributes, 'with-short-code'); @endphp--}}
{{--@endif--}}

{{--{!! call_user_func_array([Form::class, DboardHelper::getRichEditor()], [$name, $value, $attributes]) !!}--}}
