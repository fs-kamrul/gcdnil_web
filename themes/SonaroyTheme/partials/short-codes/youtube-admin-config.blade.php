<div class="form-group">
    <label for="title" class="control-label">{{ __('Title') }}</label>
    <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
</div>
<div class="form-group mb-3">
    <label class="control-label">{{ __('theme::lang.youtube_url') }}</label>
    <input type="text" name="url" class="form-control" placeholder="https://www.youtube.com/watch?v=ABCDEFGHIJK" data-shortcode-attribute="content" value="{{ $content }}"/>
</div>
