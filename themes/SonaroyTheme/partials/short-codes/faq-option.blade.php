
<!-- --------------- Faq page Start --------------- -->
@php
//dd($categories);
@endphp
@if($faqs->count()>0)

    <section id="faq">
        <div class="container">
            <div class="faq_page">
                <h2 class="heading_40 primary_text center_text">{{ clean($title) }}</h2>
                <div class="row">
                    <div class="offset-xxl-1 col-xxl-10 offset-xl-1 col-xl-10 offset-lg-1 col-lg-10 col-md-12 col-sm-12">
                        <div class="faq_main mt_60 mb_150">
                            <div class="accordion" id="faq-accordion">
                                @foreach($faqs as $key=>$faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $key }}">
                                        <button class="accordion-button primary_text" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}" @if($key==0) aria-expanded="true" @endif
                                                aria-controls="collapse{{ $key }}">
                                            {{ $key+1 }}. {{ $faq->question }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $key }}" class="accordion-collapse collapse @if($key==0) show @endif"
                                         aria-labelledby="heading{{ $key }}" data-bs-parent="#faq-accordion">
                                        <div class="accordion-body">
                                            {!! $faq->answer !!}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<!-- --------------- Faq page End --------------- -->
