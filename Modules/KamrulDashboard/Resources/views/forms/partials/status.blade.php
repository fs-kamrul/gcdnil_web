<div class="form-group col-md-{{ $selected_row }} col-xl-{{ $selected_row }}">
    {!! Form::Label($name, $options['label'], $options['label_attr']) !!}
    {!! Form::select(isset($name) ? $name : 'status',
        isset($list) ? $list : \Modules\KamrulDashboard\Packages\Supports\DboardStatus::labels(),
        isset($selected) ? $selected : old(isset($name) ? $name : 'status', \Modules\KamrulDashboard\Packages\Supports\DboardStatus::PUBLISHED),
        $attributes,
    ) !!}
</div>
