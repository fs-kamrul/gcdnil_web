<div class="form-group">
    <label for="widget-name">{{ __('Name') }}</label>
    <input type="text" id="widget-name" class="form-control" name="name" value="{{ $config['name'] }}">
</div>
<div class="form-group">
    <label for="widget_menu">{{ __('Select Post Type') }}</label>
    {!! Form::customSelect('post_type_id', app(\Modules\Post\Repositories\Interfaces\PosttypeInterface::class)->pluck('name', 'id'), $config['post_type_id'], ['class' => 'form-control select-full']) !!}
</div>
