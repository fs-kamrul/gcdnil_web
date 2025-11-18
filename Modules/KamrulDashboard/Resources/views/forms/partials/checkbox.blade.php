<div class="card">
    <div class="card-header">
        <h4 class="card-title">{!! Form::Label($name, $options['label'], $options['label_attr']) !!}</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
            @foreach($value as $key => $values)
            {!! Form::customCheckbox([
                            [
                                $name, $key, $values, in_array($key, $selected)
                            ]
                        ]) !!}
            @endforeach
        </div>
    </div>
</div>
