@extends('kamruldashboard::layouts.app_master')
@section('title', __( 'theme::lang.' . $title))
@section('stylesheet')
    <link rel="stylesheet" href="{{ url('vendor/Modules/KamrulDashboard/dropzone/dist/min/dropzone.min.css') }}" type="text/css"/>
    <!-- asColorpicker -->
    <link href="{{ url('vendor/Modules/KamrulDashboard/vendor/jquery-asColorPicker/css/asColorPicker.min.css') }}" rel="stylesheet">
{{--    <link rel="stylesheet" href="{{ url('vendor/kamruldashboard/vendor/toastr/css/toastr.min.css') }}">--}}
@endsection
@section('javascript')
{{--    <script src="{{ url('vendor/kamruldashboard/vendor/jquery/jquery.min.js') }}"></script>--}}

{{--<script src="{{ url('vendor/Modules/KamrulDashboard/vendor/toastr/js/toastr.min.js') }}"></script>--}}
{{--<script src="{{ url('vendor/Modules/KamrulDashboard/js/toastr_script.js') }}"></script>--}}
<script src="{{ url('vendor/Modules/KamrulDashboard/js/themes/theme-setting.js') }}"></script>
    <!-- asColorPicker -->
    <script src="{{ url('vendor/Modules/KamrulDashboard/vendor/jquery-asColor/jquery-asColor.min.js') }}"></script>
    <script src="{{ url('vendor/Modules/KamrulDashboard/vendor/jquery-asGradient/jquery-asGradient.min.js') }}"></script>
    <script src="{{ url('vendor/Modules/KamrulDashboard/vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js') }}"></script>
    <!-- asColorPicker init -->
    <script src="{{ url('vendor/Modules/KamrulDashboard/js/plugins-init/jquery-asColorPicker.init.js') }}"></script>

    <script src="{{ url('vendor/Modules/KamrulDashboard/dropzone/dist/dropzone.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function () {
            var all_image = document.getElementById("seo_og_image_image").value;
            if(!all_image){
                all_image = 0;
            }
            $("#seo_og_image").dropzone({
                url: "{{ route('shortcode.dropzone_upload', 'image') }}",
                autoProcessQueue: true,
                // uploadMultiple: true,
                parallelUploads: 15,
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                maxFiles: 1,
                maxFilesize: 1,
                //~ renameFile: function(file) {
                //~ var dt = new Date();
                //~ var time = dt.getTime();
                //~ return time+"-"+file.name;    // to rename file name but i didn't use it. i renamed file with php in controller.
                //~ },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                timeout: 50000,
                addRemoveLinks: true,
                init:function() {
                    // Get images
                    var myDropzone = this;
                    $('#submit-all').click(function(e){
                        myDropzone.processQueue();
                    });
                    $.ajax({
                        {{--url: '{{ route('shortcode.dropzone_getimages', $all_images) }}',--}}
                        url: '/shortcodes/shortcode/dropzone_getimages/' + all_image,
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
                success: function (file, response) {
                    // var imgName = response;
                    document.getElementById("seo_og_image_image").value = response.photo_data;
                    file.previewElement.id = response.success;
                    // $('<div id="custom-' + file.previewElement.id + '"><input type="hidden" value="' + response.photo_data + '" name="pics_file[]"/></div>').insertBefore('#submit-all');
                    // console.log(file.previewElement.id);
                    // set new images names in dropzone’s preview box.
                    var olddatadzname = file.previewElement.querySelector("[data-dz-name]");
                    file.previewElement.querySelector("img").alt = response.success;
                    olddatadzname.innerHTML = response.success;
                    file.previewElement.classList.add("dz-success");
                    // console.log("Successfully uploaded :" + response.photo_data);
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
                                url: '{{ route('shortcode.dropzone_delete') }}',
                                data: {filename: name},
                                success: function (data){
                                    // console.log(data.success);
                                    document.getElementById("seo_og_image_image").value = '';
                                    //alert(data.success +" File has been successfully removed!");
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
                error: function (file, response) {
                    file.previewElement.classList.add("dz-error");
                }
            });
            var favicon = document.getElementById("favicon_image").value;
            if(!favicon){
                favicon = 0;
            }
            $("#favicon").dropzone({
                url: "{{ route('shortcode.dropzone_upload', 'image') }}",
                autoProcessQueue: true,
                // uploadMultiple: true,
                parallelUploads: 15,
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                maxFiles: 1,
                maxFilesize: 1,
                //~ renameFile: function(file) {
                //~ var dt = new Date();
                //~ var time = dt.getTime();
                //~ return time+"-"+file.name;    // to rename file name but i didn't use it. i renamed file with php in controller.
                //~ },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                timeout: 50000,
                addRemoveLinks: true,
                init:function() {
                    // Get images
                    var myDropzone = this;
                    $('#submit-all').click(function(e){
                        myDropzone.processQueue();
                    });
                    $.ajax({
                        {{--url: '{{ route('shortcode.dropzone_getimages', $all_images) }}',--}}
                        url: '/shortcodes/shortcode/dropzone_getimages/' + favicon,
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
                success: function (file, response) {
                    // var imgName = response;
                    document.getElementById("favicon_image").value = response.photo_data;
                    file.previewElement.id = response.success;
                    // $('<div id="custom-' + file.previewElement.id + '"><input type="hidden" value="' + response.photo_data + '" name="pics_file[]"/></div>').insertBefore('#submit-all');
                    // console.log(file.previewElement.id);
                    // set new images names in dropzone’s preview box.
                    var olddatadzname = file.previewElement.querySelector("[data-dz-name]");
                    file.previewElement.querySelector("img").alt = response.success;
                    olddatadzname.innerHTML = response.success;
                    file.previewElement.classList.add("dz-success");
                    // console.log("Successfully uploaded :" + response.photo_data);
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
                                url: '{{ route('shortcode.dropzone_delete') }}',
                                data: {filename: name},
                                success: function (data){
                                    // console.log(data.success);
                                    document.getElementById("favicon_image").value = '';
                                    //alert(data.success +" File has been successfully removed!");
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
                error: function (file, response) {
                    file.previewElement.classList.add("dz-error");
                }
            });
            var logo = document.getElementById("logo_image").value;
            if(!logo){
                logo = 0;
            }
            $("#logo").dropzone({
                url: "{{ route('shortcode.dropzone_upload', 'image') }}",
                autoProcessQueue: true,
                // uploadMultiple: true,
                parallelUploads: 15,
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                maxFiles: 1,
                maxFilesize: 1,
                //~ renameFile: function(file) {
                //~ var dt = new Date();
                //~ var time = dt.getTime();
                //~ return time+"-"+file.name;    // to rename file name but i didn't use it. i renamed file with php in controller.
                //~ },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                timeout: 50000,
                addRemoveLinks: true,
                init:function() {
                    // Get images
                    var myDropzone = this;
                    $('#submit-all').click(function(e){
                        myDropzone.processQueue();
                    });
                    $.ajax({
                        {{--url: '{{ route('shortcode.dropzone_getimages', $all_images) }}',--}}
                        url: '/shortcodes/shortcode/dropzone_getimages/' + logo,
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
                success: function (file, response) {
                    // var imgName = response;
                    document.getElementById("logo_image").value = response.photo_data;
                    file.previewElement.id = response.success;
                    // $('<div id="custom-' + file.previewElement.id + '"><input type="hidden" value="' + response.photo_data + '" name="pics_file[]"/></div>').insertBefore('#submit-all');
                    // console.log(file.previewElement.id);
                    // set new images names in dropzone’s preview box.
                    var olddatadzname = file.previewElement.querySelector("[data-dz-name]");
                    file.previewElement.querySelector("img").alt = response.success;
                    olddatadzname.innerHTML = response.success;
                    file.previewElement.classList.add("dz-success");
                    // console.log("Successfully uploaded :" + response.photo_data);
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
                                url: '{{ route('shortcode.dropzone_delete') }}',
                                data: {filename: name},
                                success: function (data){
                                    // console.log(data.success);
                                    document.getElementById("logo_image").value = '';
                                    //alert(data.success +" File has been successfully removed!");
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
                error: function (file, response) {
                    file.previewElement.classList.add("dz-error");
                }
            });
            var logo_color = document.getElementById("logo_color_image").value;
            if(!logo){
                logo = 0;
            }
            $("#logo_color").dropzone({
                url: "{{ route('shortcode.dropzone_upload', 'logo_color_image') }}",
                autoProcessQueue: true,
                // uploadMultiple: true,
                parallelUploads: 15,
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                maxFiles: 1,
                maxFilesize: 1,
                //~ renameFile: function(file) {
                //~ var dt = new Date();
                //~ var time = dt.getTime();
                //~ return time+"-"+file.name;    // to rename file name but i didn't use it. i renamed file with php in controller.
                //~ },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                timeout: 50000,
                addRemoveLinks: true,
                init:function() {
                    // Get images
                    var myDropzone = this;
                    $('#submit-all').click(function(e){
                        myDropzone.processQueue();
                    });
                    $.ajax({
                        {{--url: '{{ route('shortcode.dropzone_getimages', $all_images) }}',--}}
                        url: '/shortcodes/shortcode/dropzone_getimages/' + logo_color,
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
                success: function (file, response) {
                    // var imgName = response;
                    document.getElementById("logo_color_image").value = response.photo_data;
                    file.previewElement.id = response.success;
                    // $('<div id="custom-' + file.previewElement.id + '"><input type="hidden" value="' + response.photo_data + '" name="pics_file[]"/></div>').insertBefore('#submit-all');
                    // console.log(file.previewElement.id);
                    // set new images names in dropzone’s preview box.
                    var olddatadzname = file.previewElement.querySelector("[data-dz-name]");
                    file.previewElement.querySelector("img").alt = response.success;
                    olddatadzname.innerHTML = response.success;
                    file.previewElement.classList.add("dz-success");
                    // console.log("Successfully uploaded :" + response.photo_data);
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
                                url: '{{ route('shortcode.dropzone_delete') }}',
                                data: {filename: name},
                                success: function (data){
                                    // console.log(data.success);
                                    document.getElementById("logo_color_image").value = '';
                                    //alert(data.success +" File has been successfully removed!");
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
                error: function (file, response) {
                    file.previewElement.classList.add("dz-error");
                }
            });
        });

    </script>
@endsection
@section('content')
    @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), THEME_OPTIONS_MODULE_SCREEN_NAME) @endphp
    @php  @endphp
    <div id="theme-option-header">
        <div class="display_header">
            <h2>{{ trans('theme::theme.theme_options') }}</h2>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="card">
        {!! Form::open(['route' => 'theme.options.post', 'method' => 'POST']) !!}
        <div class="theme-option-sticky">
            <div class="info_bar">
{{--                    <div class="float-start">--}}
{{--                        @if (ThemeOption::getArg('debug') == true) <span class="theme-option-dev-mode-notice">{{ trans('theme::theme.developer_mode') }}</span>@endif--}}
{{--                    </div>--}}
                <div class="theme-option-action_bar text-right">
                        {!! apply_filters(THEME_OPTIONS_ACTION_META_BOXES, null, THEME_OPTIONS_MODULE_SCREEN_NAME) !!}
                    <button type="submit" class="btn btn-primary button-save-theme-options">{{ trans('theme::theme.save_changes') }}</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-3">
                    <div class="nav flex-column nav-pills">
                            @foreach (ThemeOption::constructSections() as $section)
                                    <a href="#tab_{{ $section['id'] }}" class="nav-link @if ($loop->first) active show @endif" data-toggle="pill">@if (!empty($section['icon']))<i class="{{ $section['icon'] }}"></i> @endif {{ $section['title'] }}</a>
                            @endforeach
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="tab-content">
                        <div class="theme-option-main">
                            <div class="tab-content tab-content-in-right">
                                @foreach(ThemeOption::constructSections() as $section)
                                    <div class="tab-pane @if ($loop->first) active show @endif" id="tab_{{ $section['id'] }}">
                                        @foreach (ThemeOption::constructFields($section['id']) as $field)
                                            <div class="form-group mb-3 @if ($errors->has($field['attributes']['name'])) has-error @endif">
                                                {!! Form::label($field['attributes']['name'], $field['label'], ['class' => 'control-label']) !!}
                                                {!! ThemeOption::renderField($field) !!}
                                                @if (array_key_exists('helper', $field))
                                                    <span class="help-block">{!! $field['helper'] !!}</span>
                                                @endif
                                            </div>
                                            <hr>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="theme-option-sticky">
                            <div class="info_bar">
                                <div class="theme-option-action_bar">
                                    {!! apply_filters(THEME_OPTIONS_ACTION_META_BOXES, null, THEME_OPTIONS_MODULE_SCREEN_NAME) !!}
                                    <button type="submit" class="btn btn-primary button-save-theme-options">{{ trans('theme::theme.save_changes') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop
