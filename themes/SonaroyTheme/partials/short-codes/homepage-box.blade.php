@isset($categories)
    {{--        <h3 class="section_heading">{{ $shortcode->title }}</h3>--}}
    <div class="columns block mt-3">
        @foreach($categories as $key=>$category)
            <div id="box-3" class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 service-box box mb-20">
                <h4>{{ $category->name }}</h4>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-4">
                        <img
                            src="{{ getImageUrl($category->photo, 'post/category') }}"
                            alt="{{ $category->name }}" width="110" height=""/>
                    </div>
                    <div class="col-md-8 col-sm-8 col-8">
                        <ul class="caption " style="margin:0">
                            @foreach($category->post as $post)
                                <li><a href="{{ $post->url }}">{{ $post->name }}</a></li>
                            @endforeach

{{--                                @if($category->post->count() > 4)--}}
{{--                                    <li><a href="{{ $category->url }}">See more...</a></li>--}}
{{--                                @endif--}}
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endisset
