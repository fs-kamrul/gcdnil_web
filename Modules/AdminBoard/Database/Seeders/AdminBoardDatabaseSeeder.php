<?php

namespace Modules\AdminBoard\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AdminBoardDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(
            [
                AdminBoardPermissionSeeder::class,
                AdminClubPermissionSeeder::class,
                AdminGalleryBoardPermissionSeeder::class,
                AdminStudentGuidelinePermissionSeeder::class,
                AdminAcademicGroupPermissionSeeder::class,
                AdminEducationPermissionSeeder::class,
                AdminNoticeBoardPermissionSeeder::class,
                AdminPartnerPermissionSeeder::class,
                AdminTestimonialPermissionSeeder::class,
                AdminFacilityPermissionSeeder::class,
                AdminCareerNavigatorPermissionSeeder::class,
                AdminCategoryPermissionSeeder::class,
                AdminTeamPermissionSeeder::class,
                AdminEventPermissionSeeder::class,
                AdminNewsPermissionSeeder::class,
                AdminWorkshopPermissionSeeder::class,

//                AdminClubSeeder::class,
//                AdminEventSeeder::class,
//                AdminNewsSeeder::class,
//                AdminWorkshopSeeder::class,
                AdminTeamSeeder::class,
                AdminEducationSeeder::class,
//                AdminCareerNavigatorsSeeder::class,
//                AdminFacilitySeeder::class,
//                AdminTestimonialSeeder::class,
//                AdminPartnerSeeder::class,
//                AdminNoticeBoardSeeder::class,
//                AdminAcademicGroupSeeder::class,
//                AdminGalleryBoardSeeder::class,

            ]
        );
    }
}
