<?php

namespace App\Http\Service;

use App\Models\State;

class StateService extends BaseService
{
    public function __construct() {
        $this->model = new State();
    }

}
