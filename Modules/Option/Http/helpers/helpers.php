<?php

use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\Option\Repositories\Interfaces\OptionSubjectInterface;
use Modules\KamrulDashboard\Packages\Supports\SortItemsWithChildrenHelper;

if (! defined('OPTION_MODULE_SCREEN_NAME')) {
    define('OPTION_MODULE_SCREEN_NAME', 'option');
}
//add_next_line
if (! defined('OPTIONBLOODGROUP_MODULE_SCREEN_NAME')) {
    define('OPTIONBLOODGROUP_MODULE_SCREEN_NAME', 'optionbloodgroup');
}

if (! defined('OPTIONSET_MODULE_SCREEN_NAME')) {
    define('OPTIONSET_MODULE_SCREEN_NAME', 'optionset');
}

if (! defined('OPTIONSUBJECT_MODULE_SCREEN_NAME')) {
    define('OPTIONSUBJECT_MODULE_SCREEN_NAME', 'optionsubject');
}

if (! defined('OPTIONGENDER_MODULE_SCREEN_NAME')) {
    define('OPTIONGENDER_MODULE_SCREEN_NAME', 'optiongender');
}

if (! defined('OPTIONRELIGION_MODULE_SCREEN_NAME')) {
    define('OPTIONRELIGION_MODULE_SCREEN_NAME', 'optionreligion');
}

if (! defined('OPTIONSECTION_MODULE_SCREEN_NAME')) {
    define('OPTIONSECTION_MODULE_SCREEN_NAME', 'optionsection');
}

if (! defined('OPTIONGROUP_MODULE_SCREEN_NAME')) {
    define('OPTIONGROUP_MODULE_SCREEN_NAME', 'optiongroup');
}

if (! defined('OPTIONYEAR_MODULE_SCREEN_NAME')) {
    define('OPTIONYEAR_MODULE_SCREEN_NAME', 'optionyear');
}

if (! defined('OPTIONCLASS_MODULE_SCREEN_NAME')) {
    define('OPTIONCLASS_MODULE_SCREEN_NAME', 'optionclass');
}


if (! function_exists('get_subject_list_class')) {
    function get_subject_list_class($adminboard = 'Eleven'): array
    {
//        'adminboard' => $adminboard,
        $Subjects = app(OptionSubjectInterface::class)
            ->allBy(['status' => DboardStatus::PUBLISHED], [], ['id', 'name']);

//        $allSubjectRepository = app(OptionSubjectInterface::class);
//        $allSubject = $allSubjectRepository->advancedGet([
//            'condition' => ['status' => DboardStatus::PUBLISHED],
//            'order_by'  => ['order' => 'asc'],
//        ])->pluck('name', 'id')->toArray();
//        return $allSubject;
        return app(SortItemsWithChildrenHelper::class)
            ->setChildrenProperty('child_cats')
            ->setItems($Subjects)
            ->sort();
    }
}
