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
</style>
{{--<link rel="stylesheet" href="{{ url('vendor/Modules/KamrulDashboard/dropzone/dist/min/dropzone.min.css') }}" type="text/css"/>--}}
{{--<script src="{{ url('vendor/Modules/KamrulDashboard/dropzone/dist/min/dropzone.min.js') }}"></script>--}}

@php
    Assets::addScripts(['dropzone'])
                ->addStyles(['dropzone']);

        $data = $config['image'];
       if(isset($data)){
           $all_images = $data;
       }else{
           $all_images = 0;
       }
@endphp

<input name="image" type="hidden" id="shortcode_image" value="{{ $config['image'] }}" class="form-control" />
<div class="form-group">
    <label for="widget-name">{{ trans('kamruldashboard::lang.name') }}</label>
    <input type="text" class="form-control" name="name" value="{{ $config['name'] }}">
</div>
<div class="form-group">
    <label for="widget-name">{{ trans('kamruldashboard::lang.description') }}</label>
    <textarea rows="3" class="form-control" name="description">{{ $config['description'] }}</textarea>
</div>
{{--<div class="form-group">--}}
{{--    <label for="widget-name">{{ trans('kamruldashboard::lang.image') }}</label>--}}
{{--    {!! Form::mediaImage('image', $config['image']) !!}--}}

{{--</div>--}}

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

<script>
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
    });
</script>
