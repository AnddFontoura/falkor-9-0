<?php

namespace App\Http\Service;

use App\Models\City;

class CityService extends BaseService
{
    public function __construct() {
        $this->model = new City();
    }
}
