@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
<link rel="stylesheet" href="{{ url('vendor/kamruldashboard/slug/slug.css') }}" type="text/css"/>
<style>
    div.note-dropdown-menu {
        overflow-y:auto;
        max-height:400px; /*recommend keep it approx 50 px less than height of editor itself*/
        width: 180px; /*SM's setting was too narrow for its own style DDL */
    }
</style>
@endsection
@section('javascript')

    <script type="text/javascript">
        var csrf_token = "{{ csrf_token() }}";
    </script>
    <script src="{{ url('vendor/kamruldashboard/slug/slug.js') }}"></script>
    <script type="text/javascript">
        var LaracmcVariables = LaracmcVariables || {};
        var url_data = "{{ url('short-codes/ajax-get-admin-config/') }}";

        @if (Auth::check())
            LaracmcVariables.authorized = "1";
        @endif
    </script>

    <script src="{{ url('vendor/kamruldashboard/js/ckeditor/script.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/js/ckeditor/ckeditor.js') }}"></script>
    <script type="module" src="{{ url('vendor/kamruldashboard/js/ckeditor/editor.js') }}"></script>

@endsection
@section('title', __( 'post::lang.' . $title))
@section('content')

@if(isset($record))
    @php
        $button = 'update';
        $language = getLanguageUrlPost($record->id , 'page');
    @endphp
    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
        <input type="hidden" name="model" value="{{ \Modules\Post\Http\Models\Page::class }}">
        <input type="hidden" name="language" value="{{ $language['code'] }}">
@else
    @php
        $button = 'save';
    @endphp
    <form method="POST" action="{{ route('page.createpage.store') }}"  enctype="multipart/form-data">
@endif
@csrf

        @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), \Modules\Post\Http\Models\Page::class) @endphp
    <div class="row">
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('post::lang.page_create')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>@lang('post::lang.name')</label>
                                <input type="text" id="name" name="name" value="@isset($record){{$record->name}}@else{{ old('name') }}@endisset" class="form-control" placeholder="@lang('post::lang.name')">
                                @error('name')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>
                            @php
                                if(isset($record)){
                                    $slug = get_slug_table_data(null, \Modules\Post\HTTP\Models\page::class,$record->id, \Modules\Post\Http\Models\page::class);
                                }
                            @endphp
                            {!! Form::permalink('slug', isset($slug) ? $slug->key : null, isset($slug) ? $slug->reference_id : null, isset($slug) ? $slug->prefix : null) !!}

{{--                        @isset($record)--}}
{{--                                {!! Form::permalink('slug', $record->slug, $record->id, '') !!}--}}
{{--                            @endisset--}}
                            <div class="form-group col-md-12" id="short_description">
                                <label>@lang('post::lang.short_description_or_seo_description')</label>
                                {{--                                <input type="text" id="short_description" name="short_description" value="@isset($record){{$record->short_description}}@else{{ old('short_description') }}@endisset" class="form-control" placeholder="@lang('post::lang.short_description_or_seo_description')">--}}
                                <textarea class="form-control" rows="4" placeholder="@lang('post::lang.short_description_or_seo_description')"
                                          id="short_description" name="short_description" cols="50">@isset($record){{$record->short_description}}@else{{ old('short_description') }}@endisset</textarea>
                                @error('short_description')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>
                            @isset($record) @if($language['code_edit']){!! input_design_html('photo',$record,6,'file', __('post::lang.photo')) !!} @endif @else{!! input_design_html('photo',null,6,'file', __('post::lang.photo')) !!} @endisset

                            @isset($record) @if($language['code_edit']) {!! status_design_html($record->status->getValue(),6, __('post::lang.status')) !!} @endif @else{!! status_design_html(1,6, __('post::lang.status')) !!} @endisset

                            <div class="col-xl-12 col-xxl-12">
                                <label><strong>@lang('post::lang.content')</strong></label>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-primary show-hide-editor-btn" type="button" data-result="content">
                                                {{ trans('post::lang.show_hide_editor') }}
                                            </button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <div class="basic-dropdown editor-action-item list-shortcode-items">
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-primary dropdown-toggle add_shortcode_btn_trigger" data-result="content" data-toggle="dropdown" data-bs-toggle="dropdown">
                                                        <i class="fa fa-code"></i> {{ trans('post::lang.short_code') }}
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @php $item_data = array(); @endphp
                                                        @foreach (shortcode()->getAll() as $key => $item)
                                                            @if ($item['name'])
                                                                @php array_push($item_data,$item['key']); @endphp
                                                                <li>
                                                                    <a
                                                                        href="{{ route('short-codes.ajax-get-admin-config', $key) }}"
                                                                        data-has-admin-config="{{ Arr::has($item, 'admin_config') }}"
                                                                        data-key="{{ $key }}"
                                                                        data-description="{{ $item['description'] }}"
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
                                    </div>
                                </div>
                                    <textarea class="form-control editor-ckeditor" rows="4" placeholder="Short description" with-short-code id="content" name="description" cols="50">@isset($record){{$record->description}}@else{{ old('description') }}@endisset</textarea>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @isset($record)
                @php do_action(BASE_ACTION_META_BOXES, 'advanced', \Modules\Post\Http\Models\Page::where('id',$record->id)->first()) @endphp
            @else
                @php do_action(BASE_ACTION_META_BOXES, 'advanced', new \Modules\Post\Http\Models\Page ) @endphp
            @endisset
        </div>
        <div class=" col-md-3">

            {!! Form::formActions(__('post::lang.publish'), '') !!}

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('post::lang.templates')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                        <div class="form-row">
                            {{--                            <div class="form-row">--}}
                            @isset($record) @if($language['code_edit']) {!! select_design_html($record->page_templates_id,$page_templates,'page_templates_id',12, __('post::lang.templates')) !!} @endif @else{!! select_design_html(0,$page_templates,'page_templates_id',12, __('post::lang.templates')) !!} @endisset
                            {{--                            </div>--}}
                            @error('page_templates_id')
                            {!! getValidationMessage()!!}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            @isset($record)
                @php do_action(BASE_ACTION_META_BOXES, 'top', \Modules\Post\Http\Models\Page::where('id',$record->id)->first()) @endphp
            @endisset
        </div>
    </div>
    </form>

            <div class="modal fade short_code_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h4 class="modal-title"><i class="til_img"></i><strong>{{ trans('shortcodes::lang.add_short_code') }}</strong></h4>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>

                        <div class="modal-body with-padding">
                            <form class="form-horizontal short-code-data-form">
                                <input type="hidden" class="short_code_input_key">

                                @include('shortcodes::elements.loading')

                                <div class="short-code-admin-config"></div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="float-start btn btn-secondary" data-dismiss="modal">{{ trans('shortcodes::lang.cancel') }}</button>
                            <button type="button" class="float-end btn btn-primary add_short_code_btn" data-add-text="{{ trans('shortcodes::lang.add') }}" data-update-text="{{ trans('shortcodes::lang.update') }}">{{ trans('shortcodes::lang.add') }}</button>
                        </div>
                    </div>
                </div>
            </div>
@endsection
