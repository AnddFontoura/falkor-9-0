<?php

namespace App\Http\Controllers;

use App\Http\Service\CityService;
use App\Http\Service\StateService;
use App\Http\Service\TeamService;
use App\Http\Service\UploadService;
use App\Http\Service\DateService;
use App\Models\City;
use App\Models\State;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected UploadService $uploadService;
    protected DateService $dateService;

    protected CityService $cityService;

    protected StateService $stateService;

    protected string $viewFolder = 'user.folder.';
    protected string $saveRedirect = 'user/folder';

    function __construct()
    {
        $this->uploadService = new UploadService();
        $this->dateService = new DateService();
        $this->cityService = new CityService();
        $this->stateService = new StateService();
    }
}
