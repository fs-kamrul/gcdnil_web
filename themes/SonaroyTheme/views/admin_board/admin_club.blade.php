
<section class="clubs-single section wow fadeIn" data-wow-delay="0.3s">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="single-main">
                            <!-- clubs Head -->
                            <div class="clubs-head">
                                <img src="{{ getImageUrl($admin_club->photo, 'adminboard/adminclub') }}" alt="{{ $admin_club->name }}">
                            </div>
                            <!-- clubs Title -->
{{--                            <h1 class="clubs-title"><a href="{{ $admin_club->url }}">{{ $admin_club->name }}</a></h1>--}}
                            <!-- Meta -->
                            <div class="meta">
                                <div class="meta-left">
                                    <span class="date"><i class="ri-calendar-todo-line"></i>{{ date('d M Y', strtotime($admin_club->created_at)) }}</span>
                                </div>
                            </div>
                            <!-- clubs Text -->
                            <div class="clubs-text">
                                <p>{!! $admin_club->description !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
