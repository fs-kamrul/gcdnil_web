<div class="form-group mb-3">
    <label for="widget-name">{{ trans('kamruldashboard::lang.name') }}</label>
    <input type="text" class="form-control" name="name" value="{{ $config['name'] }}">
</div>
<div class="form-group mb-3">
    <label for="content">{{ trans('kamruldashboard::lang.content') }}</label>
    <textarea name="content" class="form-control" rows="7">{{ $config['content'] }}</textarea>
</div>
