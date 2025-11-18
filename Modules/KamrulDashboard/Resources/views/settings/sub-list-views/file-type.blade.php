<div class="form-group col-md-6">
    <div class="row">
        <div class="col-md-6">
        <label>{{ string_capital($key) }}</label>

						   <input
					 		type="{{$value->type}}"
					 		class="form-control"
					 		name="{{$key}}[value]"
					 		required="true"
					 		value = "{{$value->value}}" >
					 		<input
					 		type="hidden"
					 		name="{{$key}}[type]"
							value = "{{$value->type}}"
							title="{{$value->tool_tip}}"
							data-toggle="tooltip"

							data-placement="right"
							>
							<input type="hidden" name="{{$key}}[tool_tip]" value = "{{$value->tool_tip}}" >

							</fieldset>



							</div>
							<div class="col-md-6">
							 {{ Form::label('', '') }}
							<img src="{{url('uploads/settings/'.$value->value)}}"  height="80" width="100">
							</div>
    </div>
							</div>
