@php
    Assets::addScriptsDirectly('vendor/Modules/KamrulDashboard/js/repeater-field.js')->usingVueJS();

    $group = '';
    foreach ($fields as $key => $field) {
        if(!$field['repeated']){
        $item_add_remove = '<div class="col-md-2 mt-4">';
        $item_add_remove .= '<a class="btn btn-info" onclick="newX(\'add_row___key__\', __key__)" style="color: black;">' . __('Add Section') . '</a>' . '</div>';
        $item_add_remove .= '<div class="col-md-2 mt-4">';
        $item_add_remove .= '<a class="btn btn-warning" onclick="deleteX(\'add_row___key__\', __key__)" style="color: black;">' . __('Remove') . '</a>' . '</div>';
        $item = Form::hidden($name . '[__key__][' . $key . '][key]', $field['attributes']['name']);
            $field['attributes']['name'] = $name . '[__key__][' . $key . '][value]';
            $field['attributes']['options']['id'] = 'repeater_field_' . md5($field['attributes']['name']) . '__key__';
            Arr::set($field, 'label_attr.for', $field['attributes']['options']['id']);
            $item .= Form::customLabel(Arr::get($field, 'attr.name'), $field['label'], Arr::get($field, 'label_attr')) .
            call_user_func_array([Form::class, $field['type']], array_values($field['attributes']));
            $group .= '<div class="form-group mb-3">' . $item . '</div>';
        }
    }

    $defaultFields = ['<div class="repeater-item-group form-group mb-3 row" id="add_row___key__">' . $group . $item_add_remove . '</div>'];

    $values = (array)json_decode($value ?: '[]', true);

    $added = [];

//            dd(count($values[0]));
    if (count($values) > 0) {
        for ($i = 0; $i < count($values); $i++) {
            $group = '';
                    $item_add_remove = '<div class="col-md-2 mt-4">';
                    $item_add_remove .= '<a class="btn btn-info" onclick="newX(\'add_row_' . $i . '\',' . $i . ')" style="color: black;">' . __('Add Section') . '</a>' . '</div>';
                    $item_add_remove .= '<div class="col-md-2 mt-4">';
                    $item_add_remove .= '<a class="btn btn-warning" onclick="deleteX(\'add_row_' . $i . '\',' . $i . ')" style="color: black;">' . __('Remove') . '</a>' . '</div>';
//                    $item_add_remove .= '<div class="col-md-10" id="add_row"></div>';
            foreach ($fields as $key => $field) {
                if(!$field['repeated']){
                    $item = Form::hidden($name . '[' . $i . '][' . $key . '][key]', $field['attributes']['name']);
                    $field['attributes']['name'] = $name . '[' . $i . '][' . $key . '][value]';
                    $field['attributes']['value'] = Arr::get($values, $i . '.' . $key . '.value');
                    $field['attributes']['options']['id'] = 'repeater_field_' . md5($field['attributes']['name']);
                    Arr::set($field, 'label_attr.for', $field['attributes']['options']['id']);
                    $item .= Form::customLabel(Arr::get($field, 'attr.name'), $field['label'], Arr::get($field, 'label_attr')) .
                    call_user_func_array([Form::class, $field['type']], array_values($field['attributes']));

                    $group .= '<div class="form-group mb-3 col-md-8">' . $item . '</div>';
                    $group .= $item_add_remove;
                }
            }
            if(!empty($values[$i])){
                    $item_add_remove = '<div class="col-md-2">';
                    $item_add_remove .= '<button class="remove-field btn btn-info">Remove</button>' . '</div>';
                for ($j = 1; $j < count($values[$i]); $j++) {
    //            dd($j);
    //                if($fields[1]['repeated']){
                        $item = Form::hidden($name . '[' . $i . '][' . $j . '][key]', $fields[1]['attributes']['name']);
                        $fields[1]['attributes']['name'] = $name . '[' . $i . '][' . $j . '][value]';
                        $fields[1]['attributes']['value'] = Arr::get($values, $i . '.' . $j . '.value');
                        $fields[1]['attributes']['options']['id'] = 'repeater_field_' . md5($field['attributes']['name']);
                        Arr::set($fields[1], 'label_attr.for', $fields[1]['attributes']['options']['id']);
                        $item .= Form::customLabel(Arr::get($field, 'attr.name'), $fields[1]['label'], Arr::get($fields[1], 'label_attr')) .
                        call_user_func_array([Form::class, $fields[1]['type']], array_values($fields[1]['attributes']));

                        $group .= '<div class="form-group mb-3 col-md-12">' . $item . '</div>';
//                        $group .= $item_add_remove;
    //                }
                }
            }

            $added[] = '<div class="repeater-item-group form-group mb-3 row" id="add_row_' . $i . '">' . $group . '</div>';
        }
    }
@endphp
@push('footer')
    <script>

        function newX(x , num){
            console.log(x);
            var div = document.getElementById(x);
            var inputs = div.querySelectorAll("input");
            let numInputs = inputs.length;
            let inputsContainer = document.getElementById(x);
            let newInput = document.createElement("input");
            newInput.setAttribute("name", "curriculum_schema_config[" + num + "][" + (numInputs) + "][value]");
            newInput.type = "text";
            newInput.classList.add("form-control");
            newInput.classList.add("mt-3");
            newInput.id = x+numInputs;
            inputsContainer.appendChild(newInput);
        }
        function deleteX(x){
            document.getElementById(x).lastChild.remove();
        }

    </script>
@endpush
<input type="hidden" name="{{ $name }}" value="">
<repeater-component :fields="{{ json_encode($defaultFields) }}" :added="{{ json_encode($added) }}"></repeater-component>
