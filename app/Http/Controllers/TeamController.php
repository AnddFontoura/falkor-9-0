<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    protected $viewFolder = 'admin.team';
    protected $saveRedirect = 'admin.team.index';
    protected $model;
    protected $modelRelated = [];
    protected $requestFields = [
        'teamName',
    ];

    public function __construct()
    {
        $this->model = new Team();
    }
}
