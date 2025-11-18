<div class="form-group col-md-6">
        <label>{{ string_capital($key) }}</label>
{{--	<textarea rows="5" name="{{$key}}[value]" class="form-control ckeditor">{{$value->value}}</textarea>--}}
    <textarea class="summernote" id="description" name="{{$key}}[value]">{{$value->value}}</textarea>
	<input type="hidden" name="{{$key}}[type]" value = "{{$value->type}}" >
<input type="hidden" name="{{$key}}[tool_tip]" value = "{{$value->tool_tip}}" >
</div>
