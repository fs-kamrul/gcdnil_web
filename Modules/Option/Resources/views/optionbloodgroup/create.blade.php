@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
    <style>
        div.note-dropdown-menu {
            overflow-y:auto;
            max-height:400px; /*recommend keep it approx 50 px less than height of editor itself*/
            width: 180px; /*SM's setting was too narrow for its own style DDL */
        }
    </style>
    <link rel="stylesheet" href="{{ url('vendor/Modules/KamrulDashboard/dropzone/dist/min/dropzone.min.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ url('vendor/Modules/KamrulDashboard/slug/slug.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ url('vendor/Modules/KamrulDashboard/iconpicker/css/bootstrap-iconpicker.min.css') }}" type="text/css"/>
    @php
        Assets::addScripts([
                 'waypoints',
             ]);
    @endphp
    @isset($record)
        @php
            $all_images = $record->id;
        @endphp
    @else
        @php
            $all_images = 0;
        @endphp
    @endisset
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
    <script src="{{ url('vendor/Modules/KamrulDashboard/js/ckeditor/script.js') }}"></script>
    <script src="{{ url('vendor/Modules/KamrulDashboard/js/ckeditor/ckeditor.js') }}"></script>
    <script type="module" src="{{ url('vendor/Modules/KamrulDashboard/js/ckeditor/editor.js') }}"></script>
    <script src="{{ url('vendor/Modules/KamrulDashboard/dropzone/dist/min/dropzone.min.js') }}"></script>

    <script src="{{ url('vendor/Modules/KamrulDashboard/iconpicker/js/bootstrap-iconpicker.bundle.min.js') }}"></script>

    <script type="text/javascript">
        Dropzone.options.dropzone =
            {
                url: '{{ route('admin.dropzone.upload') }}',
                autoProcessQueue: true,
                // uploadMultiple: true,
                parallelUploads: 15,
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                maxFiles: 15,
                maxFilesize: 1,
                //~ renameFile: function(file) {
                //~ var dt = new Date();
                //~ var time = dt.getTime();
                //~ return time+"-"+file.name;    // to rename file name but i didn't use it. i renamed file with php in controller.
                //~ },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                addRemoveLinks: true,
                timeout: 50000,
                init:function() {
                    // Get images
                    var myDropzone = this;
                    $('#image_set_data').click(function(e){
                        // e.preventDefault();
                        // e.stopPropagation();
                        // console.log('i was clicked');
                        // console.log(myDropzone.files);
                        myDropzone.processQueue();
                    });
                    $.ajax({
                        url: '{{ route('admin.dropzone.getimages', $all_images) }}',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data){
                            //console.log(data);
                            $.each(data, function (key, value) {

                                var file = {name: value.name, size: value.size};
                                myDropzone.options.addedfile.call(myDropzone, file);
                                myDropzone.options.thumbnail.call(myDropzone, file, value.path);
                                myDropzone.emit("complete", file);
                            });
                        }
                    });
                },
                removedfile: function(file)
                {
                    if (this.options.dictRemoveFile) {
                        return Dropzone.confirm("Are You Sure to "+this.options.dictRemoveFile, function() {
                            if(file.previewElement.id != ""){
                                var name = file.previewElement.id;
                            }else{
                                var name = file.name;
                            }
                            var inputs = document.getElementById('custom-'+name);
                            if(inputs) {
                                inputs.remove();
                            }
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                type: 'POST',
                                url: '{{ route('admin.dropzone.delete') }}',
                                data: {filename: name},
                                success: function (data){
                                    //alert(data.success +" File has been successfully removed!");
                                    // console.log(data.success);
                                },
                                error: function(e) {
                                    //console.log(e);
                                }
                            });
                            var fileRef;
                            return (fileRef = file.previewElement) != null ?
                                fileRef.parentNode.removeChild(file.previewElement) : void 0;
                        });
                    }
                },

                success: function(file, response)
                {
                    file.previewElement.id = response.success;
                    $('<div id="custom-' + file.previewElement.id + '"><input type="hidden" value="' + response.photo_data + '" name="pics_file[]"/></div>').insertBefore('#image_set_data');
                    // console.log(file.previewElement.id);
                    // set new images names in dropzone’s preview box.
                    var olddatadzname = file.previewElement.querySelector("[data-dz-name]");
                    file.previewElement.querySelector("img").alt = response.success;
                    olddatadzname.innerHTML = response.success;
                },
                error: function(file, response)
                {
                    if($.type(response) === "string")
                        var message = response; //dropzone sends it's own error messages in string
                    else
                        var message = response.message;
                    file.previewElement.classList.add("dz-error");
                    _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                    _results = [];
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i];
                        _results.push(node.textContent = message);
                    }
                    return _results;
                }

            };
    </script>
@endsection
@section('title', __( 'option::lang.' . $title))
@section('content')

    @if(isset($record))
        @php
            $button = 'update';
            $language = getLanguageUrlPost($record->id , 'optionbloodgroup');
        @endphp
        <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
            <input type="hidden" name="model" value="{{ \Modules\Option\Http\Models\OptionBloodGroup::class }}">
            <input type="hidden" name="language" value="{{ $language['code'] }}">
            @else
                @php
                    $button = 'save';
                @endphp
                <form method="POST" action="{{ route('optionbloodgroup.createoptionbloodgroup.store') }}"  enctype="multipart/form-data">
                    @endif
                    @csrf
                    @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), \Modules\Option\Http\Models\OptionBloodGroup::class) @endphp

                    <div class="row">
                        <div class=" col-md-9">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">@lang('option::lang.optionbloodgroupcreate')</h4>
                                </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="form-row">

                                            {!! Form::textField('name', isset($record) ? $record->name : null, 'option', '12', ['placeholder'=> __('option::lang.name')]) !!}

                                            @php
                                                if(isset($record)){
                                                    $slug = get_slug_table_data(null, \Modules\Option\Http\Models\OptionBloodGroup::class,$record->id, \Modules\Option\Http\Models\OptionBloodGroup::class);
                                                }
                                            @endphp
                                            {!! Form::permalink('slug', isset($slug) ? $slug->key : null, isset($slug) ? $slug->reference_id : null, isset($slug) ? $slug->prefix : null) !!}

                                            @isset($record) @if($language['code_edit']){!! input_design_html('photo',$record,12,'file', __('option::lang.photo')) !!} @endif @else{!! input_design_html('photo',null,6,'file', __('option::lang.photo')) !!} @endisset


                                            <div class="form-group col-md-12" id="short_description">
                                                <label>@lang('option::lang.short_description_or_seo_description')</label>
                                                {{--                                <input type="text" id="short_description" name="short_description" value="@isset($record){{$record->short_description}}@else{{ old('short_description') }}@endisset" class="form-control" placeholder="@lang('option::lang.short_description_or_seo_description')">--}}
                                                <textarea class="form-control" rows="4" placeholder="@lang('option::lang.short_description_or_seo_description')"
                                                          id="short_description" name="short_description" cols="50">@isset($record){{$record->short_description}}@else{{ old('short_description') }}@endisset</textarea>
                                                @error('short_description')
                                                {!! getValidationMessage()!!}
                                                @enderror
                                            </div>
                                            <div class="col-xl-12 col-xxl-12 list-shortcode-items" id="content_set">
                                                <label><strong>@lang('option::lang.content')</strong></label>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-primary show-hide-editor-btn" type="button" data-result="content">
                                                                {{ trans('option::lang.show_hide_editor') }}
                                                            </button>
                                                        </div>
                                                        <div class="btn-group" role="group">
                                                            <div class="basic-dropdown editor-action-item">
                                                                <div class="dropdown">
                                                                    <button type="button" class="btn btn-primary dropdown-toggle add_shortcode_btn_trigger" data-result="content" data-toggle="dropdown" data-bs-toggle="dropdown">
                                                                        <i class="fa fa-code"></i> {{ trans('option::lang.short_code') }}
                                                                    </button>
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
                                                    </div>
                                                </div>
                                                <textarea class="form-control editor-ckeditor" rows="4" placeholder="Short description" with-short-code id="content" name="description" cols="50">@isset($record){{$record->description}}@else{{ old('description') }}@endisset</textarea>
                                                {{--                                </div>--}}
                                                {{--                                <textarea class="summernote" id="description" name="description">@isset($record){{$record->description}}@else{{ old('description') }}@endisset</textarea>--}}
                                                @error('description')
                                                {{--                                {!! getValidationMessage()!!}--}}
                                                @enderror
                                            </div>
                                            <div class="col-xl-12 col-xxl-12" id="images_set" style="margin-top: 15px;">
                                                <label><strong>@lang('option::lang.images')</strong></label>
                                                <div class="dropzone clsbox" id="dropzone">
                                                    @csrf
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @isset($record)
                                @php do_action(BASE_ACTION_META_BOXES, 'advanced', \Modules\Option\Http\Models\OptionBloodGroup::where('id',$record->id)->first()) @endphp
                            @else
                                @php do_action(BASE_ACTION_META_BOXES, 'advanced', new \Modules\Option\Http\Models\OptionBloodGroup ) @endphp
                            @endisset
                        </div>
                        <div class=" col-md-3">
                            @isset($record)
                                @foreach($record->AdminGalleryParameter as $AdminGalleryParameter)
                                    <div id="custom-{{ $AdminGalleryParameter->name }}"><input type="hidden" value="{{ $AdminGalleryParameter->id }}" name="pics_file[]"></div>
                                @endforeach
                            @endisset
                            <div id="image_set_data"></div>

                            {!! Form::formActions(__('option::lang.publish'), '') !!}

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">@lang('option::lang.status')</h4>
                                </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="form-row">
                                            @isset($record)
                                                @if($language['code_edit'])
                                                    {!! status_admin_enum($record->status,12, '', \Modules\Option\Enums\OptionBloodGroupStatusEnum::class) !!}
                                                @endif @else {!! status_admin_enum(1,12, '' , \Modules\Option\Enums\OptionBloodGroupStatusEnum::class) !!}
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">@lang('option::lang.order')</h4>
                                </div>
                                <div class="card-body">
                                    <div class="basic-form">

                                        <div class="form-row">
                                            {!! Form::numberField('order', isset($record) ? $record->order : 0, 'option', '12', ['placeholder'=> __('option::lang.order')]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @isset($record)
                                @php do_action(BASE_ACTION_META_BOXES, 'top', \Modules\Option\Http\Models\OptionBloodGroup::where('id',$record->id)->first()) @endphp
                            @else
                                @php do_action(BASE_ACTION_META_BOXES, 'top', new \Modules\Option\Http\Models\OptionBloodGroup ) @endphp
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
