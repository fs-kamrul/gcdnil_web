@if ($paginator->hasPages())
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center my-4 gap-3">
        {{-- Page Info --}}
        <div class="text-muted small order-2 order-md-1">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>

        {{-- Pagination --}}
        <nav aria-label="Page navigation" class="order-1 order-md-2">
            <ul class="pagination pagination-sm mb-0" style="--bs-pagination-active-bg: #683091; --bs-pagination-active-border-color: #683091; --bs-pagination-hover-bg: #683091; --bs-pagination-hover-border-color: #683091; --bs-pagination-focus-bg: #683091; --bs-pagination-focus-border-color: #683091;">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                            <span class="page-link bg-light border-secondary text-muted">
                                <span class="d-none d-sm-inline">&laquo; Prev</span>
                                <span class="d-sm-none">&laquo;</span>
                            </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link text-white border-0"
                           style="background-color: #683091;"
                           href="{{ $paginator->previousPageUrl() }}" rel="prev">
                            <span class="d-none d-sm-inline">&laquo; Prev</span>
                            <span class="d-sm-none">&laquo;</span>
                        </a>
                    </li>
                @endif

                {{-- Smart Pagination Elements --}}
                @php
                    $current = $paginator->currentPage();
                    $last = $paginator->lastPage();
                    $start = max(1, $current - 2);
                    $end = min($last, $current + 2);

                    // Always show first page
                    if ($start > 1) {
                        $showFirst = true;
                        $showStartEllipsis = $start > 2;
                    } else {
                        $showFirst = false;
                        $showStartEllipsis = false;
                    }

                    // Always show last page
                    if ($end < $last) {
                        $showLast = true;
                        $showEndEllipsis = $end < $last - 1;
                    } else {
                        $showLast = false;
                        $showEndEllipsis = false;
                    }
                @endphp

                {{-- First Page --}}
                @if ($showFirst)
                    <li class="page-item">
                        <a class="page-link border-0"
                           style="background-color: #f8f9fa; color: #683091;"
                           href="{{ $paginator->url(1) }}">1</a>
                    </li>
                @endif

                {{-- Start Ellipsis --}}
                @if ($showStartEllipsis)
                    <li class="page-item disabled">
                        <span class="page-link bg-white border-light text-muted">...</span>
                    </li>
                @endif

                {{-- Current Range --}}
                @for ($i = $start; $i <= $end; $i++)
                    @if ($i == $current)
                        <li class="page-item active">
                                <span class="page-link text-white border-0 fw-bold"
                                      style="background-color: #683091;">
                                    {{ $i }}
                                </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link border-0"
                               style="background-color: #f8f9fa; color: #683091;"
                               href="{{ $paginator->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endfor

                {{-- End Ellipsis --}}
                @if ($showEndEllipsis)
                    <li class="page-item disabled">
                        <span class="page-link bg-white border-light text-muted">...</span>
                    </li>
                @endif

                {{-- Last Page --}}
                @if ($showLast)
                    <li class="page-item">
                        <a class="page-link border-0"
                           style="background-color: #f8f9fa; color: #683091;"
                           href="{{ $paginator->url($last) }}">{{ $last }}</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link text-white border-0"
                           style="background-color: #683091;"
                           href="{{ $paginator->nextPageUrl() }}" rel="next">
                            <span class="d-none d-sm-inline">Next &raquo;</span>
                            <span class="d-sm-none">&raquo;</span>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                            <span class="page-link bg-light border-secondary text-muted">
                                <span class="d-none d-sm-inline">Next &raquo;</span>
                                <span class="d-sm-none">&raquo;</span>
                            </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
