
{!! SeoHelper::render() !!}

@if (theme_option('favicon'))
    @php
//        $favicon = theme_option('favicon');
//        if($favicon){
//            $favicon_image = \Modules\Post\Http\Models\PostGallery::where('id', $favicon)->first()->name;
//        }else{
//            $favicon_image = '';
//        }

    @endphp
    <link rel="shortcut icon" href="{{ getImageUrlById(theme_option('favicon'), 'shortcodes') }}">
{{--    <h>favicon test</h>--}}
@endif

@if (Theme::has('headerMeta'))
    {!! Theme::get('headerMeta') !!}
@endif
{!! apply_filters('theme_front_meta', null) !!}

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "{{ rescue(fn() => SeoHelper::openGraph()->getProperty('site_name')) }}",
  "url": "{{ url('') }}"
}
</script>

{!! Theme::asset()->styles() !!}
{!! Theme::asset()->container('after_header')->styles() !!}
{!! Theme::asset()->container('header')->scripts() !!}

{!! apply_filters(THEME_FRONT_HEADER, null) !!}

<script>
    window.siteUrl = "{{ route('public.index') }}";
</script>
