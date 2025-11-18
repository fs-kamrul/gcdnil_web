@php
    $value = $value == '[null]' ? '[]' : $value;
    $attributes = isset($attributes) ? $attributes : [];
    $module_set = 'Modules\AdminBoard\Http\Models\AdminGalleryBoard';
//    dd($choices);
@endphp
<div class="col-xl-12 col-xxl-12" id="images_set" style="margin-top: 15px;">
{{--    <label><strong>@lang('adminboard::lang.images')</strong></label>--}}
    <div class="dropzone clsbox" id="dropzone">
        @csrf
    </div>
</div>
@foreach($choices as $key=>$choice)
    <div id="custom-{{ $choice }}"><input type="hidden" value="{{ $key }}" name="{{ $name }}"></div>
@endforeach
<div id="image_set_data"></div>

@isset($value)
    @php
        $all_images = $value;
    @endphp
@else
    @php
        $all_images = 0;
    @endphp
@endisset
@once
    @section('stylesheet')
        <link rel="stylesheet" href="{{ url('vendor/Modules/KamrulDashboard/dropzone/dist/min/dropzone.min.css') }}" type="text/css"/>
    @endsection
    @push('footer')
        <script src="{{ url('vendor/Modules/KamrulDashboard/dropzone/dist/min/dropzone.min.js') }}"></script>


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
                            url: '{{ route('admin.dropzone.getimages', [$all_images, $module_set]) }}',
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
                        $('<div id="custom-' + file.previewElement.id + '"><input type="hidden" value="' + response.photo_data + '" name="{{ $name }}"/></div>').insertBefore('#image_set_data');
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
    @endpush
@endonce
