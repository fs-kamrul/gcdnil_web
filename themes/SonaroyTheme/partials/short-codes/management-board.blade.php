<style>
    .employee_box {
        background-color: #edf6fa;
        border-radius: 18px;
        padding: 16px 30px 16px 16px;
        margin-right: 50px;
    }
    .mb_25 {
        margin-bottom: 25px;
    }
    .employee_box_inner {
        display: flex;
        align-items: center;
    }
    .employee_img_box {
        width: 152px;
        height: 170px;
        margin-right: 45px;
    }
    .employee_img_box img {
        width: 100%;
        height: 100%;
        border-radius: 10px;
        object-fit: cover;
        object-position: top center;
    }
    .employee_name {
        font-family: 'Source Serif Pro', serif;
        font-size: 20px;
        font-weight: 600;
    }
    .orange_text {
        font-size: 17px;
        color: #FF9203;
        font-weight: 400;
        text-transform: capitalize;
    }
    .employee_contact_box{
        font-size:13px;
    }

</style>
<div class="row columns mb_100">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade  show active " id="english-medium" role="tabpanel" aria-labelledby="english-medium-tab" tabindex="0">

                @foreach($posts as $key=>$post)
                <div class="employee_box mb_25 aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                    <div class="employee_box_inner">
                        <div class="employee_img_box">
                            <img src="{{ getImageUrl($post->photo) }}" alt="{{ $post->name }}">
                        </div>

                        <div class="employee_info">
                            <h1 class="employee_name bule_text">{{ $post->name }}</h1>
                            <p class="employee_designation orange_text mb_15">{{ $post->designation }}</p>

                            <div class="employee_contact_box">
                                {!! $post->description !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </div>

    @if ($posts->total() > 0)
        {!! $posts->links(Theme::getThemeNamespace() . '::partials.pagination') !!}
    @endif
</div>
