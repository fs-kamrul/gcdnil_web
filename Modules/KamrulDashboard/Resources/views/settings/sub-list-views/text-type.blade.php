<?php $tool_tip = '';
				if(isset($value->tool_tip))
					$tool_tip = $value->tool_tip;

				?>
    <div class="form-group col-md-6">
        <label>{{ string_capital($key) }}</label>

    <input
        type="{{$value->type}}"
        class="form-control"
        name="{{$key}}[value]"
        required="true"
        value = "{{$value->value}}"
        title ="{{$tool_tip}}"
        placeholder ="{{$tool_tip}}"
    >

    <input
        type="hidden"
        name="{{$key}}[type]"
        value = "{{$value->type}}" >

    <input
        type="hidden"
        name="{{$key}}[tool_tip]"
        value = "{{$tool_tip}}" >
    </div>
