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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf_token
            }
        });
        $.ajax({
            url: "{{ route('themeicon.geticon') }}",
            type: 'get',
            success: data =>  {
                let $all_icon = data.message;
                let $setIcon = "@isset($record){{$record->icon}}@else{{ old('icon') }}@endisset";
                $('#icon_target').iconpicker()
                    .iconpicker('setAlign', 'center')
                    .iconpicker('setArrowClass', 'btn-success')
                    .iconpicker('setArrowPrevIconClass', 'fa fa-angle-left')
                    .iconpicker('setArrowNextIconClass', 'fa fa-angle-right')
                    .iconpicker('setCols', 7)
                    .iconpicker('setFooter', true)
                    .iconpicker('setHeader', true)
                    .iconpicker('setIconset', {
                        iconClass: '',
                        iconClassFix: '',
                        icons: $all_icon
                    })
                    .iconpicker('setIcon', $setIcon)
                    .iconpicker('setLabelHeader', '{0} of {1} pages')
                    .iconpicker('setLabelFooter', '{0} - {1} of {2} icons')
                    .iconpicker('setPlacement', 'bottom') // Only in button tag
                    .iconpicker('setRows', 6)
                    .iconpicker('setSearch', true)
                    .iconpicker('setSearchText', 'Type text')
                    .iconpicker('setSelectedClass', 'btn-danger')
                    .iconpicker('setUnselectedClass', 'btn-primary');
            },
            error: data =>  {
                kamruldashboard.handleError(data);
            }
        });
        $('#icon_target').on('change', function(e) {
            document.getElementById('icon_set').value = e.icon;
            //console.log(e.icon);
        });
    </script>
    <script type="text/javascript">
        Dropzone.options.dropzone =
            {
                url: '{{ route('post.dropzone.upload') }}',
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
                        url: '{{ route('post.dropzone.getimages', $all_images) }}',
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
                                url: '{{ route('post.dropzone.delete') }}',
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
    <script>
        $(document).ready(function () {
            var file_update = document.getElementById('post_types_id').value;
            console.log('pre load-' + file_update);
            if(file_update == 2){
                document.getElementById('header_title').style.display = 'none';
                document.getElementById('designation').style.display = 'none';
                document.getElementById('tag_line').style.display = 'none';
                document.getElementById('start_date').style.display = 'none';
                document.getElementById('set_time').style.display = 'none';
                document.getElementById('short_description').style.display = 'none';
                document.getElementById('icon_set').style.display = 'none';
                document.getElementById('document_file').style.display = 'none';
                document.getElementById('content_set').style.display = 'block';
                document.getElementById('images_set').style.display = 'none';
                document.getElementById('additional_post_fields').style.display = 'none';
                // document.getElementById('additional_venuefacility').style.display = 'none';
                // document.getElementById('additional_keyfacility').style.display = 'none';
            }else if(file_update == 3){
                document.getElementById('images_set').style.display = 'block';
                document.getElementById('designation').style.display = 'none';
                document.getElementById('header_title').style.display = 'none';
                document.getElementById('tag_line').style.display = 'none';
                document.getElementById('start_date').style.display = 'none';
                document.getElementById('set_time').style.display = 'none';
                document.getElementById('short_description').style.display = 'block';
                document.getElementById('icon_set').style.display = 'none';
                document.getElementById('document_file').style.display = 'none';
                document.getElementById('content_set').style.display = 'block';
                document.getElementById('photo').style.display = 'block';
                document.getElementById('additional_post_fields').style.display = 'block';
                // document.getElementById('additional_venuefacility').style.display = 'block';
                // document.getElementById('additional_keyfacility').style.display = 'block';
            }else if(file_update == 4 || file_update == 5){
                document.getElementById('images_set').style.display = 'none';
                document.getElementById('designation').style.display = 'block';
                document.getElementById('header_title').style.display = 'none';
                document.getElementById('tag_line').style.display = 'none';
                document.getElementById('start_date').style.display = 'none';
                document.getElementById('set_time').style.display = 'none';
                document.getElementById('short_description').style.display = 'none';
                document.getElementById('icon_set').style.display = 'none';
                document.getElementById('document_file').style.display = 'none';
                document.getElementById('content_set').style.display = 'block';
                document.getElementById('photo').style.display = 'block';
                document.getElementById('additional_post_fields').style.display = 'block';
                // document.getElementById('additional_venuefacility').style.display = 'block';
                // document.getElementById('additional_keyfacility').style.display = 'block';
            // }else if(file_update == 5){
            //     document.getElementById('header_title').style.display = 'none';
            //     document.getElementById('designation').style.display = 'none';
            //     document.getElementById('tag_line').style.display = 'none';
            //     document.getElementById('start_date').style.display = 'none';
            //     document.getElementById('set_time').style.display = 'none';
            //     document.getElementById('short_description').style.display = 'none';
            //     document.getElementById('icon_set').style.display = 'none';
            //     document.getElementById('photo').style.display = 'block';
            //     document.getElementById('document_file').style.display = 'none';
            //     document.getElementById('content_set').style.display = 'block';
            //     document.getElementById('images_set').style.display = 'none';
            //     document.getElementById('additional_post_fields').style.display = 'none';
                // document.getElementById('additional_venuefacility').style.display = 'none';
                // document.getElementById('additional_keyfacility').style.display = 'none';
            }else if(file_update == 6){
                document.getElementById('header_title').style.display = 'none';
                document.getElementById('designation').style.display = 'none';
                document.getElementById('tag_line').style.display = 'none';
                document.getElementById('start_date').style.display = 'none';
                document.getElementById('set_time').style.display = 'none';
                document.getElementById('short_description').style.display = 'none';
                document.getElementById('icon_set').style.display = 'none';
                document.getElementById('photo').style.display = 'block';
                document.getElementById('document_file').style.display = 'none';
                document.getElementById('content_set').style.display = 'none';
                document.getElementById('images_set').style.display = 'block';
                document.getElementById('additional_post_fields').style.display = 'none';
                // document.getElementById('additional_venuefacility').style.display = 'none';
                // document.getElementById('additional_keyfacility').style.display = 'none';
            }else if(file_update == 8){
                document.getElementById('images_set').style.display = 'none';
                document.getElementById('designation').style.display = 'none';
                document.getElementById('header_title').style.display = 'none';
                document.getElementById('tag_line').style.display = 'none';
                document.getElementById('start_date').style.display = 'none';
                document.getElementById('set_time').style.display = 'none';
                document.getElementById('short_description').style.display = 'block';
                document.getElementById('icon_set').style.display = 'none';
                document.getElementById('document_file').style.display = 'none';
                document.getElementById('content_set').style.display = 'none';
                document.getElementById('images_set').style.display = 'none';
                document.getElementById('photo').style.display = 'block';
                document.getElementById('additional_post_fields').style.display = 'none';
                // document.getElementById('additional_venuefacility').style.display = 'none';
                // document.getElementById('additional_keyfacility').style.display = 'none';
            }else if(file_update == 9){

                document.getElementById('header_title').style.display = 'none';
                document.getElementById('designation').style.display = 'none';
                document.getElementById('tag_line').style.display = 'none';
                document.getElementById('start_date').style.display = 'none';
                document.getElementById('set_time').style.display = 'none';
                document.getElementById('short_description').style.display = 'none';
                document.getElementById('icon_set').style.display = 'block';
                document.getElementById('photo').style.display = 'block';
                document.getElementById('document_file').style.display = 'none';
                document.getElementById('content_set').style.display = 'none';
                document.getElementById('images_set').style.display = 'none';
                document.getElementById('additional_post_fields').style.display = 'none';
                // document.getElementById('additional_venuefacility').style.display = 'none';
                // document.getElementById('additional_keyfacility').style.display = 'none';
            }else if(file_update == 10 || file_update == 11){
                document.getElementById('images_set').style.display = 'none';
                document.getElementById('designation').style.display = 'none';
                document.getElementById('header_title').style.display = 'none';
                document.getElementById('tag_line').style.display = 'none';
                document.getElementById('start_date').style.display = 'block';
                document.getElementById('set_time').style.display = 'block';
                document.getElementById('short_description').style.display = 'block';
                document.getElementById('icon_set').style.display = 'none';
                document.getElementById('document_file').style.display = 'none';
                document.getElementById('content_set').style.display = 'block';
                document.getElementById('images_set').style.display = 'block';
                document.getElementById('photo').style.display = 'block';
                document.getElementById('additional_post_fields').style.display = 'none';
                // document.getElementById('additional_venuefacility').style.display = 'none';
                // document.getElementById('additional_keyfacility').style.display = 'none';
            } else{
                document.getElementById('designation').style.display = 'none';
                document.getElementById('header_title').style.display = 'none';
                document.getElementById('tag_line').style.display = 'none';
            }
            document.getElementById('post_types_id').addEventListener('change', function () {
                console.log(this.value);
                if(this.value == 1) {
                    var style = this.value == 1 ? 'block' : 'none';
                    var style_hide = this.value == 1 ? 'none' : 'block';
                    document.getElementById('header_title').style.display = style_hide;
                    document.getElementById('designation').style.display = style_hide;
                    document.getElementById('tag_line').style.display = style_hide;
                    document.getElementById('photo').style.display = style;
                    document.getElementById('start_date').style.display = style_hide;
                    document.getElementById('set_time').style.display = style_hide;
                    document.getElementById('short_description').style.display = style;
                    document.getElementById('icon_set').style.display = style_hide;
                    document.getElementById('document_file').style.display = style_hide;
                    document.getElementById('content_set').style.display = style;
                    document.getElementById('images_set').style.display = style;
                    document.getElementById('additional_post_fields').style.display = style_hide;
                    // document.getElementById('additional_venuefacility').style.display = style_hide;
                    // document.getElementById('additional_keyfacility').style.display = style_hide;
                }else if(this.value == 2) {
                    var style = this.value == 2 ? 'block' : 'none';
                    var style_hide = this.value == 2 ? 'none' : 'block';
                    document.getElementById('header_title').style.display = style_hide;
                    document.getElementById('designation').style.display = style_hide;
                    document.getElementById('tag_line').style.display = style_hide;
                    document.getElementById('photo').style.display = style;
                    document.getElementById('start_date').style.display = style_hide;
                    document.getElementById('set_time').style.display = style_hide;
                    document.getElementById('short_description').style.display = style_hide;
                    document.getElementById('icon_set').style.display = style_hide;
                    document.getElementById('document_file').style.display = style;
                    document.getElementById('content_set').style.display = style;
                    document.getElementById('images_set').style.display = style_hide;
                    document.getElementById('additional_post_fields').style.display = style_hide;
                    // document.getElementById('additional_venuefacility').style.display = style_hide;
                    // document.getElementById('additional_keyfacility').style.display = style_hide;
                }else if(this.value == 3) {
                    var style = this.value == 3 ? 'block' : 'none';
                    var style_hide = this.value == 3 ? 'none' : 'block';
                    document.getElementById('header_title').style.display = style_hide;
                    document.getElementById('designation').style.display = style_hide;
                    document.getElementById('tag_line').style.display = style_hide;
                    document.getElementById('images_set').style.display = style;
                    document.getElementById('start_date').style.display = style_hide;
                    document.getElementById('set_time').style.display = style_hide;
                    document.getElementById('short_description').style.display = style;
                    document.getElementById('icon_set').style.display = style_hide;
                    document.getElementById('document_file').style.display = style_hide;
                    document.getElementById('content_set').style.display = style;
                    document.getElementById('photo').style.display = style;
                    document.getElementById('additional_post_fields').style.display = style;
                    // document.getElementById('additional_venuefacility').style.display = style;
                    // document.getElementById('additional_keyfacility').style.display = style;
                }else if(this.value == 4 || this.value == 5) {
                    var style = this.value == 4 || this.value == 5 ? 'block' : 'none';
                    var style_hide = this.value == 4 || this.value == 5 ? 'none' : 'block';
                    document.getElementById('header_title').style.display = style_hide;
                    document.getElementById('designation').style.display = style;
                    document.getElementById('tag_line').style.display = style_hide;
                    document.getElementById('images_set').style.display = style_hide;
                    document.getElementById('start_date').style.display = style_hide;
                    document.getElementById('set_time').style.display = style_hide;
                    document.getElementById('short_description').style.display = style_hide;
                    document.getElementById('icon_set').style.display = style_hide;
                    document.getElementById('document_file').style.display = style_hide;
                    document.getElementById('content_set').style.display = style;
                    document.getElementById('photo').style.display = style;
                    document.getElementById('additional_post_fields').style.display = style;
                    // document.getElementById('additional_venuefacility').style.display = style;
                    // document.getElementById('additional_keyfacility').style.display = style;
                // }else if(this.value == 5) {
                //     var style = this.value == 5 ? 'block' : 'none';
                //     var style_hide = this.value == 5 ? 'none' : 'block';
                //     document.getElementById('header_title').style.display = style_hide;
                //     document.getElementById('designation').style.display = style_hide;
                //     document.getElementById('tag_line').style.display = style_hide;
                //     document.getElementById('photo').style.display = style;
                //     document.getElementById('start_date').style.display = style_hide;
                //     document.getElementById('set_time').style.display = style_hide;
                //     document.getElementById('short_description').style.display = style_hide;
                //     document.getElementById('icon_set').style.display = style_hide;
                //     document.getElementById('document_file').style.display = style_hide;
                //     document.getElementById('content_set').style.display = style;
                //     document.getElementById('images_set').style.display = style_hide;
                //     document.getElementById('additional_post_fields').style.display = style_hide;
                    // document.getElementById('additional_venuefacility').style.display = style_hide;
                    // document.getElementById('additional_keyfacility').style.display = style_hide;
                }else if(this.value == 6) {
                    var style = this.value == 6 ? 'block' : 'none';
                    var style_hide = this.value == 6 ? 'none' : 'block';
                    document.getElementById('header_title').style.display = style_hide;
                    document.getElementById('designation').style.display = style_hide;
                    document.getElementById('tag_line').style.display = style_hide;
                    document.getElementById('start_date').style.display = style_hide;
                    document.getElementById('set_time').style.display = style_hide;
                    document.getElementById('short_description').style.display = style_hide;
                    document.getElementById('icon_set').style.display = style_hide;
                    document.getElementById('photo').style.display = style;
                    document.getElementById('document_file').style.display = style_hide;
                    document.getElementById('content_set').style.display = style_hide;
                    document.getElementById('images_set').style.display = style;
                    document.getElementById('additional_post_fields').style.display = style_hide;
                    // document.getElementById('additional_venuefacility').style.display = style_hide;
                    // document.getElementById('additional_keyfacility').style.display = style_hide;
                }else if(this.value == 8) {
                    var style = this.value == 8 ? 'block' : 'none';
                    var style_hide = this.value == 8 ? 'none' : 'block';
                    document.getElementById('header_title').style.display = style_hide;
                    document.getElementById('designation').style.display = style_hide;
                    document.getElementById('tag_line').style.display = style_hide;
                    document.getElementById('photo').style.display = style;
                    document.getElementById('start_date').style.display = style_hide;
                    document.getElementById('set_time').style.display = style_hide;
                    document.getElementById('short_description').style.display = style;
                    document.getElementById('icon_set').style.display = style_hide;
                    document.getElementById('document_file').style.display = style_hide;
                    document.getElementById('content_set').style.display = style_hide;
                    document.getElementById('images_set').style.display = style_hide;
                    document.getElementById('additional_post_fields').style.display = style_hide;
                    // document.getElementById('additional_venuefacility').style.display = style_hide;
                    // document.getElementById('additional_keyfacility').style.display = style_hide;
                }else if( this.value == 9) {
                    var style = this.value == 9 ? 'block' : 'none';
                    var style_hide = this.value == 9 ? 'none' : 'block';
                    document.getElementById('header_title').style.display = style_hide;
                    document.getElementById('designation').style.display = style_hide;
                    document.getElementById('tag_line').style.display = style_hide;
                    document.getElementById('start_date').style.display = style_hide;
                    document.getElementById('set_time').style.display = style_hide;
                    document.getElementById('short_description').style.display = style_hide;
                    document.getElementById('icon_set').style.display = style;
                    document.getElementById('photo').style.display = style;
                    document.getElementById('document_file').style.display = style_hide;
                    document.getElementById('content_set').style.display = style_hide;
                    document.getElementById('images_set').style.display = style_hide;
                    document.getElementById('additional_post_fields').style.display = style_hide;
                    // document.getElementById('additional_venuefacility').style.display = style_hide;
                    // document.getElementById('additional_keyfacility').style.display = style_hide;
                }else if(this.value == 10 || this.value == 11) {
                    var style = this.value == 10 || this.value == 11 ? 'block' : 'none';
                    var style_hide = this.value == 10 || this.value == 11 ? 'none' : 'block';
                    document.getElementById('header_title').style.display = style_hide;
                    document.getElementById('designation').style.display = style_hide;
                    document.getElementById('tag_line').style.display = style_hide;
                    document.getElementById('photo').style.display = style;
                    document.getElementById('start_date').style.display = style;
                    document.getElementById('set_time').style.display = style;
                    document.getElementById('short_description').style.display = style;
                    document.getElementById('icon_set').style.display = style_hide;
                    document.getElementById('document_file').style.display = style_hide;
                    document.getElementById('content_set').style.display = style;
                    document.getElementById('images_set').style.display = style;
                    document.getElementById('additional_post_fields').style.display = style_hide;
                    // document.getElementById('additional_venuefacility').style.display = style_hide;
                    // document.getElementById('additional_keyfacility').style.display = style_hide;
                }else  {
                    // if(!inArray(this.value, [1,2,5]))
                    // console.log('check array')
                    var style = 'block';
                    var style_hide = 'none';
                    document.getElementById('header_title').style.display = style_hide;
                    document.getElementById('designation').style.display = style_hide;
                    document.getElementById('tag_line').style.display = style_hide;
                    document.getElementById('images_set').style.display = style_hide;
                    document.getElementById('photo').style.display = style;
                    document.getElementById('start_date').style.display = style_hide;
                    document.getElementById('set_time').style.display = style_hide;
                    document.getElementById('short_description').style.display = style;
                    document.getElementById('icon_set').style.display = style;
                    document.getElementById('document_file').style.display = style;
                    document.getElementById('content_set').style.display = style;
                    document.getElementById('additional_post_fields').style.display = style_hide;
                    // document.getElementById('additional_venuefacility').style.display = style_hide;
                    // document.getElementById('additional_keyfacility').style.display = style_hide;
                }
            });
            function inArray(needle, haystack) {
                var length = haystack.length;
                for(var i = 0; i < length; i++) {
                    if(haystack[i] == needle) return true;
                }
                return false;
            }
        });
    </script>
@endsection
@section('title', __( 'post::lang.' . $title))
@section('content')

@if(isset($record))
    @php
//    dd($record->url);
        $button = 'update';
        $language = getLanguageUrlPost($record->id , 'post');
//    dd($language['code']);
    @endphp
    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
        <input type="hidden" name="model" value="{{ \Modules\Post\Http\Models\Post::class }}">
        <input type="hidden" name="language" value="{{ $language['code'] }}">
@else
    @php
        $button = 'save';
    @endphp
    <form name="formPost" method="POST" action="{{ route('post.createpost.store') }}" enctype="multipart/form-data">
@endif
@csrf
        @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), \Modules\Post\Http\Models\Post::class) @endphp
    <div class="row">
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('post::lang.post_create')</h4>
                </div>

                <div class="card-body">
                    <div class="basic-form">
                        <div class="form-row">
                            <div class="form-group col-md-12" id="header_title" style="display: none;">
                                <label>@lang('post::lang.header_title')</label>
                                <input type="text" id="header_title" name="header_title" value="@isset($record){{$record->header_title}}@else{{ old('header_title') }}@endisset" class="form-control" placeholder="@lang('post::lang.header_title')">
                                @error('header_title')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label>@lang('post::lang.name')</label>
                                <input type="text" id="name" required name="name" value="@isset($record){{$record->name}}@else{{ old('name') }}@endisset" class="form-control" placeholder="@lang('post::lang.name')">
                                @error('name')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>
{{--                            @isset($record)--}}
{{--                                {!! Form::permalink('slug', $record->slug, $record->id, '') !!}--}}
{{--                            @endisset--}}
                            @php
                                if(isset($record)){
                                    $slug = get_slug_table_data(null, \Modules\Post\HTTP\Models\post::class,$record->id, \Modules\Post\Http\Models\post::class);
                                }
                            @endphp
                            {!! Form::permalink('slug', isset($slug) ? $slug->key : null, isset($slug) ? $slug->reference_id : null, isset($slug) ? $slug->prefix : null) !!}
                            @isset($record){!! input_design_html('icon_set',$record,12,'file', __('post::lang.icon')) !!} @else{!! input_design_html('icon_set',null,12,'file', __('post::lang.icon_set')) !!} @endisset

{{--                            <div class="input-group col-md-12 row" id="icon_set">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <label>@lang('post::lang.icon')</label>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-12 input-group">--}}
{{--                                <span class="input-group-prepend">--}}
{{--                                    <button class="btn btn-secondary" id="icon_target" data-icon="fa fa-map-marker-alt" role="iconpicker"></button>--}}
{{--                                </span>--}}
{{--                                <input type="text" class="form-control" name="icon_set" id="icon_set" value="@isset($record){{$record->icon}}@else{{ old('icon') }}@endisset"  placeholder="@lang('post::lang.icon')">--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="form-group col-md-12" id="short_description">
                                <label>@lang('post::lang.short_description_or_seo_description')</label>
{{--                                <input type="text" id="short_description" name="short_description" value="@isset($record){{$record->short_description}}@else{{ old('short_description') }}@endisset" class="form-control" placeholder="@lang('post::lang.short_description_or_seo_description')">--}}
                                <textarea class="form-control" rows="4" placeholder="@lang('post::lang.short_description_or_seo_description')"
                                          id="short_description" name="short_description" cols="50">@isset($record){{$record->short_description}}@else{{ old('short_description') }}@endisset</textarea>
                                @error('short_description')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>
                            <div class="form-group col-md-12" id="designation" style="display: none;">
                                <label>@lang('post::lang.designation')</label>
                                <input type="text" id="designation" name="designation" value="@isset($record){{$record->designation}}@else{{ old('designation') }}@endisset" class="form-control" placeholder="@lang('post::lang.designation')">
                                @error('designation')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>
                            <div class="form-group col-md-12" id="tag_line" style="display: none;">
                                <label>@lang('post::lang.tag_line')</label>
                                <input type="text" id="tag_line" name="tag_line" value="@isset($record){{$record->tag_line}}@else{{ old('tag_line') }}@endisset" class="form-control" placeholder="@lang('post::lang.tag_line')">
                                @error('tag_line')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>
                            @isset($record){!! input_design_html('photo',$record,6,'file', __('post::lang.photo')) !!} @else{!! input_design_html('photo',null,6,'file', __('post::lang.photo')) !!} @endisset

{{--                            <div class="form-group col-md-3">--}}
{{--                                <div class="radio">--}}
{{--                                    <label>--}}
{{--                                        <input type="radio"  @isset($record) @if($record->check_design == 'theme_img') checked @endif @else{{ old('check_design') }}@endisset name="check_design" value="theme_img" > @lang('Regular Design Image')</label>--}}
{{--                                </div>--}}
{{--                                <div class="radio">--}}
{{--                                    <label>--}}
{{--                                        <input type="radio" @isset($record) @if($record->check_design == 'regular_img') checked @endif @else{{ old('check_design') }}@endisset name="check_design" value="regular_img" > @lang('Circle Design Image')</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            @isset($record){!! status_design_html($record->status,6, __('post::lang.status')) !!} @else{!! status_design_html(1,6, __('post::lang.status')) !!} @endisset

                            @isset($record){!! input_design_html('document_file',$record,12,'file', __('post::lang.document_file')) !!} @else{!! input_design_html('document_file',null,12,'file', __('post::lang.document_file')) !!} @endisset
                            {!! Form::datePicker(
                               'start_date',
                               [
                                   'label'         => trans('post::lang.start_date'),
                                   'label_show'    => true,
                                   'label_attr'    => ['class' => 'control-label'],
                                   'attr'    => ['data-date-format' => config('kamruldashboard.date_format.js.date'),
                                                   'class'=>'form-control',
                                                   'data-input'=>"",
                                                    'readonly'=>"readonly",
                                                ],
                                   'value'         => isset($record) ? $record->start_date : DboardHelper::formatDate(now()),
                                   'wrapper'       => true,
                                   'wrapperAttrs'  => ' class="form-group col-md-6" id="start_date"',
                               ],
                            ) !!}

                            <div class="form-group col-md-6" id="set_time">
                                <label>@lang('post::lang.time')</label>
                                <input type="text" id="set_time" name="set_time" value="@isset($record){{$record->set_time}}@else{{ old('set_time') }}@endisset" class="form-control" placeholder="@lang('post::lang.placeholder_time')">
                                @error('name')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>
                            @php

//                                add_shortcode('kamrul_i','kam', 'Add blog posts');
//                                shortcode()->setAdminConfig('kamrul_i', '[kamrul][/kamrul]' );
//                                add_shortcode('kamrul_2','kam 2', 'Add blog posts2');
//                                shortcode()->setAdminConfig('kamrul_2', '<p>sfgd</p>' );

                            @endphp
{{--                            {{ route('short-codes.ajax-get-admin-config', $key) }}--}}
                            <div class="col-xl-12 col-xxl-12 list-shortcode-items" id="content_set">
                                <label><strong>@lang('post::lang.content')</strong></label>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-primary show-hide-editor-btn" type="button" data-result="content">
                                                {{ trans('post::lang.show_hide_editor') }}
                                            </button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <div class="basic-dropdown editor-action-item">
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-primary dropdown-toggle add_shortcode_btn_trigger" data-result="content" data-toggle="dropdown" data-bs-toggle="dropdown">
                                                        <i class="fa fa-code"></i> {{ trans('post::lang.short_code') }}
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
{{--                                <div class="basic-dropdown editor-action-item list-shortcode-items">--}}
{{--                                    <div class="dropdown">--}}
{{--                                        <button type="button" class="btn btn-primary dropdown-toggle add_shortcode_btn_trigger" data-result="content" data-toggle="dropdown" data-bs-toggle="dropdown">--}}
{{--                                            <i class="fa fa-code"></i> {{ trans('post::lang.short_code') }}--}}
{{--                                        </button>--}}
{{--                                        <ul class="dropdown-menu">--}}
{{--                                            @php $item_data = array(); @endphp--}}
{{--                                            @foreach (shortcode()->getAll() as $key => $item)--}}
{{--                                                @if ($item['name'])--}}
{{--                                                    @php array_push($item_data,$item['key']); @endphp--}}
{{--                                                    <li>--}}
{{--                                                        <a--}}
{{--                                                           href="{{ route('short-codes.ajax-get-admin-config', $key) }}"--}}
{{--                                                           data-has-admin-config="{{ Arr::has($item, 'admin_config') }}"--}}
{{--                                                           data-key="{{ $key }}"--}}
{{--                                                           data-description="{{ $item['description'] }}"--}}
{{--                                                        >--}}
{{--                                                            {{ $item['name'] }}--}}
{{--                                                        </a>--}}
{{--                                                    </li>--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
                                    <textarea class="form-control editor-ckeditor" rows="4" placeholder="Short description" with-short-code id="content" name="description" cols="50">@isset($record){{$record->description}}@else{{ old('description') }}@endisset</textarea>
{{--                                </div>--}}
{{--                                <textarea class="summernote" id="description" name="description">@isset($record){{$record->description}}@else{{ old('description') }}@endisset</textarea>--}}
                                @error('description')
{{--                                {!! getValidationMessage()!!}--}}
                                @enderror
                            </div>
                            <div class="col-xl-12 col-xxl-12" id="images_set">
                                <label><strong>@lang('post::lang.images')</strong></label>
                                <div class="dropzone clsbox" id="dropzone">
                                    @csrf
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @isset($record)
                @php do_action(BASE_ACTION_META_BOXES, 'advanced', \Modules\Post\Http\Models\Post::where('id',$record->id)->first()) @endphp
            @else
                @php do_action(BASE_ACTION_META_BOXES, 'advanced', new \Modules\Post\Http\Models\Post ) @endphp
            @endisset
        </div>
        <div class=" col-md-3">
            @isset($record)
                @foreach($record->PostGalleryParameter as $PostGalleryParameter)
                    <div id="custom-{{ $PostGalleryParameter->name }}"><input type="hidden" value="{{ $PostGalleryParameter->id }}" name="pics_file[]"></div>
                @endforeach
            @endisset
                <div id="image_set_data"></div>
                {!! Form::formActions(__('post::lang.publish'), '') !!}


{{--                @isset($record)--}}
{{--                    @php do_action(BASE_ACTION_META_BOXES, 'top', $record) @endphp--}}
{{--                @endisset--}}


            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('post::lang.category')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                        <div class="form-row">
                            <div class="form-row">
                                @isset($record){!! checkbox_design_html($record->categories,$category,'categories[]',12, __('post::lang.category')) !!} @else{!! checkbox_design_html(0,$category,'categories[]',12, __('post::lang.category')) !!} @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $_module = Savefunction::request_module_defined('Branch');
            @endphp
            @if($_module)
                @php
//                    $branch   = \Modules\Branch\Http\Models\Branch::where('status',1)->get();
                    $branch   = \Modules\KamrulDashboard\Http\Models\User::where('id',Auth::id())->first()->branch;
                @endphp
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">@lang('branch::lang.branch')</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">

                            <div class="form-row">
                                <div class="form-row">
                                    @isset($record){!! checkbox_design_html($record->branch,$branch,'branch[]',12, __('branch::lang.branch')) !!} @else{!! checkbox_design_html(0,$branch,'branch[]',12, __('post::lang.branch')) !!} @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('post::lang.posttype')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                        <div class="form-row">
{{--                            <div class="form-row">--}}
                                @isset($record){!! select_design_html($record->post_types_id,$posttype,'post_types_id',12, __('post::lang.posttype')) !!} @else{!! select_design_html(0,$posttype,'post_types_id',12, __('post::lang.posttype')) !!} @endisset
{{--                            </div>--}}
                            @error('post_types_id')
                            {!! getValidationMessage()!!}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
                @isset($record)
                    @php do_action(BASE_ACTION_META_BOXES, 'top', \Modules\Post\Http\Models\Post::where('id',$record->id)->first()) @endphp
                @else
                    @php do_action(BASE_ACTION_META_BOXES, 'top', new \Modules\Post\Http\Models\Post ) @endphp
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
