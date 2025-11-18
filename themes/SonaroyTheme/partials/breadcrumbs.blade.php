<!-- Page Header Start -->
<div class="container-fluid page-header py-5" style="margin-bottom: 6rem;">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">{{ SeoHelper::getTitle() }}</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb">
                @foreach (Theme::breadcrumb()->getCrumbs() as $i => $crumb)
                    @if ($i != (count(Theme::breadcrumb()->getCrumbs()) - 1))
                        <li class="breadcrumb-item">
                            <a style="color: white;" href="{{ $crumb['url'] }}">{!! $crumb['label'] !!}</a><span></span>
                        </li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page"  style="color: white;">
                            {!! $crumb['label'] !!}
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->
