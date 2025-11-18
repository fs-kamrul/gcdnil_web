@php Theme::layout('homepage'); @endphp

<div class="container">
    <div style="margin: 40px 0;">
        <h4 style="color: #f00; margin-bottom: 15px;">You need to setup your homepage first!</h4>

        <p><strong>1. Go to Dashboard -> Plugins then activate all plugins.</strong></p>
        <p><strong>2. Go to Dashboard -> Pages and create a page:</strong></p>

        <div style="margin: 20px 0;">
            <div>- Content:</div>
            <div style="border: 1px solid rgba(0,0,0,.1); padding: 10px; margin-top: 10px;">

                <div>[banner-sections number_of_slide="4" post_types_id="2" button_label1="Apply Now" button_url1="#" button_label2="Campus Tour" button_url2="https://www.youtube.com/watch?v=xfN7jVcMJ8w"][/banner-sections]</div>
                <div>[academic-sections title="Academic Sections" category_id="3"][/academic-sections]</div>
                <div>[our-facilities title="Our Facilities" image="1" category_id="4"][/our-facilities]</div>
                <div>[code-line code_line=" Children must be taught how to think, not what to think." image="6" author_name="Margaret Mead" tag_line="DIS - We Nurture Future Leaders."][/code-line]</div>
                <div>[news-events number_of_post="3" title="News &amp; Events" category_id="6"][/news-events]</div>
                <div>[our-branches title="Our Branches" contain="Best environment to learn &amp; grow."][/our-branches]</div>
                <div>[testimonial title="What Parents Says About Us" category_id="7"][/testimonial]</div>
                <div>[affiliations title="Affiliations" category_id="8"][/affiliations]</div>
                <div>[gallery-section category_id="9"][/gallery-section]</div>
            </div>
            <br>
            <div>- Template: <strong>Homepage</strong>.</div>
        </div>

        <p><strong>3. Then go to Dashboard -> Appearance -> Theme setting -> Page to set your homepage.</strong></p>
    </div>
</div>
