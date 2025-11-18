@push('header')
    <script type="text/javascript">
        var csrf_token = "{{ csrf_token() }}";
    </script>
@endpush
@php
    $model = (object)$options['model'];
    $options['prefix'] = SlugHelper::getPrefix($model::class);
@endphp

<input
    type="hidden"
    name="model"
    value="{{ $model::class }}"
>

@if (empty($model))
    <div class="form-group mb-3 col-md-12 @if ($errors->has($name)) has-error @endif">
        {!! Form::permalink($name, old($name), 0, $options['prefix'], [], true, $model) !!}
        {!! Form::error($name, $errors) !!}
    </div>
@else
    <div class="form-group mb-3 col-md-12 @if ($errors->has($name)) has-error @endif">
        {!! Form::permalink(
            $name,
            $model->slug,
            $model->slug_id,
            $options['prefix'],
//            SlugHelper::canPreview($model) && in_array($model->status, [Modules\KamrulDashboard\Packages\Supports\DboardStatus::DRAFT, Modules\KamrulDashboard\Packages\Supports\DboardStatus::PENDING]),
            [],
            true,
            $model,
        ) !!}
        {!! Form::error($name, $errors) !!}
    </div>
@endif
