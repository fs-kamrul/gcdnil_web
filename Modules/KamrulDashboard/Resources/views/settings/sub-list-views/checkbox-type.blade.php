<?php $tool_tip = '';
				if(isset($value->tool_tip))
					$tool_tip = $value->tool_tip;
$checked = '';
if($value->value)
$checked = 'checked';
				?>
<div class="form-group col-md-6">
    <label title="{{$tool_tip}}">{{ string_capital($key) }}</label>
{{--						  <label data-toggle="tooltip" data-placement="top" title="{{$tool_tip}}">{{getPhrase($key)}}--}}
						   <input
					 		type="checkbox"

					 		name="{{$key}}[value]"
					 		required="true"
					 		value = "1"
                            <?php if($value->value == 1) { echo 'checked'; } ?>
							title ="{{$tool_tip}}"
							{{$checked}}

					 		>
</label>


					 		<input
					 		type="hidden"
					 		name="{{$key}}[type]"
							value = "{{$value->type}}" >

							<input
					 		type="hidden"
					 		name="{{$key}}[tool_tip]"
							value = "{{$tool_tip}}" >

							</div>
