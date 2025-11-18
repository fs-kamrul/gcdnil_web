
@if ($paginator->hasPages())
<div class="pagination">
    <div class="container">
        <div class="pagination_box">
        <ul>
            {{-- Previous Page Link --}}
            @if (!$paginator->onFirstPage())
                <li>
                    <a class="pagination_btn" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa-solid fa-angle-left"></i></a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <a class="pagination_btn"><span>{{ $element }}</span></a>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <a class="pagination_btn active"><span>{{ $page }}</span></a>
                            </li>
                        @else
                            <li><a class="pagination_btn" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li><a class="pagination_btn" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa-solid fa-angle-right"></i></a></li>
            @endif
        </ul>
        </div>
    </div>
</div>
@endif
