<?php

namespace Modules\KamrulDashboard\Contracts;

interface HasTreeCategory
{
    public static function updateTree(array $data): void;
}
