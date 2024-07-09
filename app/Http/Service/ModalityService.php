<?php

namespace App\Http\Service;

use App\Models\Modality;

class ModalityService extends BaseService
{
    public function __construct()
    {
        $this->model = new Modality();
    }
}
