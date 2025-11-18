<div class="row columns mb_100">
    <div class="container my-5 columns mb_100">
        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Notice Title -->
                <h3 class="card-title text-primary mb-3">
                    {{ $notice_board->name }}
                </h3>

                <!-- Published Date -->
                <p class="text-muted mb-4">
                    <strong>@lang('adminboard::lang.published_date'):</strong>
                    {{ date('d F Y', strtotime($notice_board->created_at)) }}
                </p>

                <!-- Description -->
                <div class="mb-4">
                    {!! clean($notice_board->description) !!}
                </div>

                <!-- Photo Display -->
                @if($notice_board->photo != null)
                    <div class="mb-4 text-center">
                        <img src="{{ getImageUrl($notice_board->photo,'adminboard/adminnoticeboard') }}"
                             class="img-fluid rounded border"
                             alt="{{ $notice_board->name }}">
                    </div>
                @endif

                <!-- Document Download -->
                @if($notice_board->document != null)
                    <div class="text-center">
                        <a href="{{ getImageUrl($notice_board->document,'adminboard/adminnoticeboard') }}"
                           class="btn btn-outline-primary"
                           target="_blank">
                            @lang('adminboard::lang.download_notice')
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
