<div class="card">
    <div class="card-header">
        <h4 class="card-title">{!! Form::Label($name, $options['label'], $options['label_attr']) !!}</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
                {!! Form::text($name, $value, array_merge(['class' => 'form-control'], $attributes)) !!}
                @error($name)
                {!! getValidationMessage()!!}
                @enderror
                @if(isset($help_block) && $help_block != null)
                {!! Form::helper($help_block) !!}
                @endif
        </div>
    </div>
</div>
