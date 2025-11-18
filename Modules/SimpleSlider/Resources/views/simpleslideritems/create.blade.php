

<div class="modal-box-container fancybox-content">
    <button data-fancybox-close="" class="fancybox-close-small" title="Close"></button>
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
    <link rel="stylesheet" href="{{ url('vendor/kamruldashboard/dropzone/dist/min/dropzone.min.css') }}" type="text/css"/>
    <script src="{{ url('vendor/kamruldashboard/dropzone/dist/min/dropzone.min.js') }}"></script>

    @php
        $data =  isset($record) ? $record->image : 0;
       if(isset($data)){
           $all_images = $data;
       }else{
           $all_images = 0;
       }
    @endphp
@if(isset($record))
    @php
        $button = 'update';
        $language = getLanguageUrlSlider($record->id , 'simple-slider-item');
    @endphp
    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
        <input type="hidden" name="model" value="{{ \Modules\SimpleSlider\Http\Models\SimpleSlider::class }}">
        <input type="hidden" name="language" value="{{ $language['code'] }}">
@else
    @php
        $button = 'save';
    @endphp
    <form method="POST" action="{{ route('simple-slider-item.create.store') }}"  enctype="multipart/form-data">
@endif
@csrf
        <div class="modal-header">
            <h4 class="modal-title" id="avatar-modal-label"><i class="til_img"></i><strong>{{ $title }}</strong></h4>
            <button type="button" class="btn-close" data-dismiss="modal"></button>
        </div>
        <div class="modal-body">
                    <div class="basic-form">

                        @isset($record)
                            @php do_action(BASE_ACTION_META_BOXES, 'top', Modules\SimpleSlider\Http\Models\SimpleSliderItem::where('id',$record->id)->first()) @endphp
                        @else
                            @php do_action(BASE_ACTION_META_BOXES, 'top', new Modules\SimpleSlider\Http\Models\SimpleSliderItem ) @endphp
                        @endisset

                            <input name="image" type="hidden" id="shortcode_image" value="{{ isset($record) ? $record->image : 0 }}" class="form-control" />

                            {!! Form::textField('title', isset($record) ? $record->title : null, 'simpleslider', '12', ['placeholder'=> __('simpleslider::lang.title')]) !!}

                            {!! Form::textField('link', isset($record) ? $record->link : null, 'simpleslider', '12', ['placeholder'=> 'http://']) !!}

                            {!! Form::textField('description', isset($record) ? $record->description : null, 'simpleslider', '12', ['placeholder'=> __('simpleslider::lang.description')]) !!}

                            @isset($record)
                                @php do_action(BASE_ACTION_META_BOXES, 'advanced', Modules\SimpleSlider\Http\Models\SimpleSliderItem::where('id',$record->id)->first()) @endphp
                            @else
                                @php do_action(BASE_ACTION_META_BOXES, 'advanced', new Modules\SimpleSlider\Http\Models\SimpleSliderItem ) @endphp
                            @endisset

                            {!! Form::textField('order', isset($record) ? $record->order : null, 'simpleslider', '12', ['placeholder'=> __('simpleslider::lang.order')]) !!}

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
{{--                            <input type="hidden" name="image" value="{{ request()->simple_slider_id }}">--}}
                            <input type="hidden" name="simple_slider_id" value="@isset($simple_slider_id){{ $simple_slider_id  }}@else{{ request()->simple_slider_id }}@endisset">

                            <br/>
                                <div class="form-group">
                            <button type="submit" name="submit" value="apply" class="btn btn-success">
                                <i class="fa fa-check-circle"></i> {{ trans('kamruldashboard::forms.save') }}
                            </button>
                                </div>
                        </div>
                </div>

    </form>

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
</div>
