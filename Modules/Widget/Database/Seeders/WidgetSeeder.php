<?php

namespace Modules\Widget\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\KamrulDashboard\Http\Models\Permission;
use Modules\Widget\Http\Models\Widget;
use Theme;

class WidgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $theme = Theme::getThemeName();
        $data =
            [
                [
                    'id'         => 1,
                    'widget_id'  => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'theme'      => $theme,
                    'position'   => 0,
                    'data'       => json_encode([
                        'id'      => 'CustomMenuWidget',
                        'name'    => 'About Us',
                        'menu_id' => 'footer1',
                    ]),
                ],
                [
                    'id'         => 2,
                    'widget_id'  => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'theme'      => $theme,
                    'position'   => 1,
                    'data'       => json_encode([
                        'id'      => 'CustomMenuWidget',
                        'name'    => 'Admission',
                        'menu_id' => 'footer2',
                    ]),
                ],
                [
                    'id'         => 3,
                    'widget_id'  => 'CustomMenuWidget',
                    'sidebar_id' => 'footer_sidebar',
                    'theme'      => $theme,
                    'position'   => 2,
                    'data'       => json_encode([
                        'id'      => 'CustomMenuWidget',
                        'name'    => 'Important Links',
                        'menu_id' => 'footer3',
                    ]),
                ],
//                [
//                    'id'         => 2,
//                    'widget_id'  => 'NewsletterWidget',
//                    'sidebar_id' => 'footer_sidebar',
//                    'theme'      => $theme,
//                    'position'   => 1,
//                    'data'       => json_encode([
//                        'id'   => 'NewsletterWidget',
//                        'name' => 'Newsletter',
//                    ]),
//                ],
//                [
//                    'id'         => 3,
//                    'widget_id'  => 'AboutWidget',
//                    'sidebar_id' => 'footer_sidebar',
//                    'theme'      => $theme,
//                    'position'   => 2,
//                    'data'       => json_encode([
//                        'id'          => 'AboutWidget',
//                        'name'        => "Hello, I'm Kamrul ISlam",
//                        'description' => "Hi, I’m Kamrul ISlam.",
//                        'image'       => 'uploads/author.jpg',
//                    ]),
//                ],
//                [
//                    'id'         => 4,
//                    'widget_id'  => 'PopularPostsWidget',
//                    'sidebar_id' => 'footer_sidebar',
//                    'theme'      => $theme,
//                    'position'   => 3,
//                    'data'       => json_encode([
//                        'id'             => 'PopularPostsWidget',
//                        'name'           => 'Most popular',
//                        'number_display' => 5,
//                    ]),
//                ],
//                [
//                    'id'         => 5,
//                    'widget_id'  => 'GalleriesWidget',
//                    'sidebar_id' => 'footer_sidebar',
//                    'theme'      => $theme,
//                    'position'   => 2,
//                    'data'       => [
//                        'id'             => 'GalleriesWidget',
//                        'name'           => 'Galleries',
//                        'number_display' => 6,
//                    ],
//                ],
            ];
        Widget::upsert($data, ['widget_id']);
    }
}
