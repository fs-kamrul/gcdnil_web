<?php

namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Slug;
use Modules\Menus\Http\Models\MenusNode;
use Modules\Post\Http\Models\Page;
use SlugHelper;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = 1;
        $data = [
            [
                'id'                => $id++,
                'uuid'              => gen_uuid(),
                'name'              => "Homepage",
                'description'       => '<shortcode class="bb-shortcode">[banner-sections number_of_slide="4" post_types_id="2" button_label1="Apply Now" button_url1="#" button_label2="Campus Tour" button_url2="https://www.youtube.com/watch?v=xfN7jVcMJ8w"][/banner-sections]</shortcode><shortcode class="bb-shortcode">[academic-sections title="Academic Sections" category_id="3" button_label="Apply Now" button_url="#"][/academic-sections]</shortcode><shortcode class="bb-shortcode">[our-facilities title="Our Facilities" image="1" category_id="4" button_label="Apply Now" button_url="#"][/our-facilities]</shortcode><shortcode class="bb-shortcode">[code-line code_line=" Children must be taught how to think, not what to think." image="6" author_name="Margaret Mead" tag_line="DIS - We Nurture Future Leaders."][/code-line]</shortcode><shortcode class="bb-shortcode">[news-events title="News &amp; Events" category_id="6" number_of_post="3" button_label="See All" button_url="all-news-events"][/news-events]</shortcode><shortcode class="bb-shortcode">[our-branches title="Our Branches" contain="Best environment to learn &amp; grow."][/our-branches]</shortcode><shortcode class="bb-shortcode">[testimonial title="What Parents Says About Us" category_id="7"][/testimonial]</shortcode><shortcode class="bb-shortcode">[affiliations title="Affiliations" category_id="8"][/affiliations]</shortcode><shortcode class="bb-shortcode">[gallery-section category_id="9"][/gallery-section]</shortcode><shortcode class="bb-shortcode">[newsletter][/newsletter]</shortcode>',
                'slug'              => "homepage",
                'page_templates_id' => 3,
                'status'            => 1,
                'user_id'           => 1,
            ],
            [
                'id'                => $id++,
                'uuid'              => gen_uuid(),
                'name'              => "Contact Us",
                'description'       => 'Contact Us',
                'slug'              => "contact-us",
                'page_templates_id' => 2,
                'status'            => 1,
                'user_id'           => 1,
            ]
        ];
        $post_slug = array();
        foreach ($data as $key=>$value){
            $data_set = [
                'id'                => $key+41,
                'key'               => $value['slug'],
                'reference_id'      => $value['id'],
                'reference_type'    => Page::class,
                'prefix'            => SlugHelper::getPrefix(Page::class),
            ];
            array_push($post_slug,$data_set);
        }

        Page::upsert($data, ['name']);
        Slug::upsert($post_slug, ['key']);
    }
}
