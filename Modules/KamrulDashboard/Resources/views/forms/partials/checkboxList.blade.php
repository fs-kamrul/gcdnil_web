
<div class="card">
    <div class="card-header">
        <h4 class="card-title">{!! Form::Label($name, $options['label'], $options['label_attr']) !!}</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
            @php
                $margin_left = 0;
            @endphp
            <div class="form-group form-group-no-margin @if ($errors->has($name)) has-error @endif">
                <div class="multi-choices-widget list-item-checkbox">
                    @include('kamruldashboard::forms.partials.checkboxList2', [
                       'categories' => $value,
                       'value'      => $selected,
                       'currentId'  => null,
                       'name'       => $name
                   ])
                </div>
            </div>
        </div>
    </div>
</div>
