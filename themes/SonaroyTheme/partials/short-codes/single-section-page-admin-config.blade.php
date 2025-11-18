<style>
    .modal-title {
        color: white;
    }
    .modal-header .close {
        color: white;
    }
    .dz-image img {
        width: 100%;
        height: 100%;
    }
    .dropzone.dz-started .dz-message {
        display: block !important;
    }
    .dropzone {
        border: 2px dashed #028AF4 !important;;
    }
    .dropzone .dz-preview.dz-complete .dz-success-mark {
        opacity: 1;
    }
    .dropzone .dz-preview.dz-error .dz-success-mark {
        opacity: 0;
    }
    .dropzone .dz-preview .dz-error-message{
        top: 144px;
    }
    #container {
        width: 100%;
        margin: 20px auto;
    }
    .ck-editor__editable[role="textbox"] {
        /* editing area */
        min-height: 200px;
    }
    .ck-content .image {
        /* block images */
        max-width: 80%;
        margin: 20px auto;
    }
    #video_url {
        display: none;
    }
</style>
<link rel="stylesheet" href="{{ url('vendor/Modules/KamrulDashboard/dropzone/dist/min/dropzone.min.css') }}" type="text/css"/>
<script src="{{ url('vendor/Modules/KamrulDashboard/dropzone/dist/min/dropzone.min.js') }}"></script>

    @php
        $data = Arr::get($attributes, 'image');
       if(isset($data)){
           $all_images = $data;
       }else{
           $all_images = 0;
       }
        $data2 = Arr::get($attributes, 'download_file');
       if(isset($data2)){
           $download_file = $data2;
       }else{
           $download_file = 0;
       }
       //print_r($all_images);
    @endphp
<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    <input name="image" type="hidden" id="shortcode_image" value="{{ Arr::get($attributes, 'image') }}" class="form-control" />
    <input name="download_file" type="hidden" id="download_file" value="{{ Arr::get($attributes, 'download_file') }}" class="form-control" />
</div>

<div class="form-group">
    <label class="control-label">{{ __('Contain') }}</label>
    <textarea name="contain" class="form-control">{{ Arr::get($attributes, 'contain') }}</textarea>
</div>

<div class="form-group">
    <label class="control-label" for="section_type"><?php echo __('Section Type'); ?></label>
    {!! Form::customSelect('section_type', get_section_type_layouts(), Arr::get($attributes, 'section_type'), ['class' => 'form-control', 'id' => 'section_type']) !!}
</div>
<div class="form-group" id="video_url">
    <label class="control-label">{{ __('Video Url') }}</label>
    <input name="video_url" value="{{ Arr::get($attributes, 'video_url') }}" class="form-control" />
</div>
<div class="form-group">
    <label class="control-label"><?php echo __('Image'); ?></label>
    <div id="dZUpload" class="dropzone">
        <div class="dz-default dz-message">
            <h3 class="sbold">@lang('Drop files here to upload')</h3>
            <span>@lang('You can also click to open file browser')</span><br/>
            <span class="note needsclick">@lang('theme::lang.upload_file_image')</span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label">{{ __('Button Label ') }}</label>
    <input name="button_label" value="{{ Arr::get($attributes, 'button_label') }}" class="form-control" />
</div>
<div class="form-group">
    <label class="control-label">{{ __('Button Url ') }}</label>
    <input name="button_url" value="{{ Arr::get($attributes, 'button_url') }}" class="form-control" />
</div>
{{--<div class="form-group">--}}
{{--    <label class="control-label"><?php echo __('Download'); ?></label>--}}
{{--    <?php echo Form::Select('downloadable', ['disable' => __('Disable'), 'enable' => __('Enable')], Arr::get($attributes, 'downloadable'), ['class' => 'form-control', 'id' => 'downloadable']); ?>--}}

{{--</div>--}}

<div class="form-group download_file2" id="download_file2" style="display:none;">
    <label class="control-label"><?php echo __('Downloadable File'); ?></label>
    <div id="DownloadUpload" class="dropzone">
        <div class="dz-default dz-message">
            <h3 class="sbold">@lang('Drop files here to upload')</h3>
            <span>@lang('You can also click to open file browser')</span><br/>
            <span class="note needsclick">@lang('theme::lang.upload_file_image_file')</span>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var select_data = document.getElementById('section_type');
        var video_url = document.getElementById('video_url');

        if (select_data.value === 'video_view') {
            video_url.style.display = 'block';
        }
        select_data.addEventListener('change', () => {
            if (select_data.value === 'video_view') {
                video_url.style.display = 'block';
            } else {
                video_url.style.display = 'none';
            }
        });
    });
</script>


<script>
    // $(document).ready(function () {
    //     var file_update = document.getElementById('downloadable').value;
    //     if(file_update == 'enable'){
    //         document.getElementById('download_file2').style.display = 'block';
    //     }
    //     document.getElementById('downloadable').addEventListener('change', function () {
    //         var style = this.value == 'enable' ? 'block' : 'none';
    //         document.getElementById('download_file2').style.display = style;
    //     });
    // });

    $(document).ready(function () {
        Dropzone.autoDiscover = false;
        $("#dZUpload").dropzone({
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
                    url: '{{ route('shortcode.dropzone_getimages', $all_images) }}',
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
                document.getElementById("shortcode_image").value = response.photo_data;
                file.previewElement.id = response.success;
                $('<div id="custom-' + file.previewElement.id + '"><input type="hidden" value="' + response.photo_data + '" name="pics_file[]"/></div>').insertBefore('#submit-all');
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
                                document.getElementById("shortcode_image").value = '';
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
        $("#DownloadUpload").dropzone({
            url: "{{ route('shortcode.dropzone_upload', 'download') }}",
            autoProcessQueue: true,
            // uploadMultiple: true,
            parallelUploads: 15,
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            maxFiles: 1,
            maxFilesize: 1,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf,.zip",
            timeout: 50000,
            addRemoveLinks: true,
            init:function() {
                // Get images
                var myDropzone = this;
                $('#submit-all').click(function(e){
                    myDropzone.processQueue();
                });
                $.ajax({
                    url: '{{ route('shortcode.dropzone_getimages', $download_file) }}',
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
                document.getElementById("download_file").value = response.photo_data;
                file.previewElement.id = response.success;
                $('<div id="custom-' + file.previewElement.id + '"><input type="hidden" value="' + response.photo_data + '" name="download_file[]"/></div>').insertBefore('#submit-all');
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
                                document.getElementById("download_file").value = '';
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
{{--<div class="col-xl-12 col-xxl-12">--}}
{{--    <label><strong>@lang('Images')</strong></label>--}}
{{--    <div class="dropzone clsbox" id="dropzone">--}}
{{--        @csrf--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
{{--    <label class="control-label">{{ __('Image') }}</label>--}}
{{--    {!! Form::Image('image', Arr::get($attributes, 'image')) !!}--}}
{{--</div>--}}
