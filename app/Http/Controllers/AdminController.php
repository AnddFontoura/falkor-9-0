<?php

namespace App\Http\Controllers;

use App\Http\Service\AdminControllerService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Contracts\View\View;

class AdminController extends Controller
{
    protected $model;
    protected $adminService;

    public function __construct(User $model) {
        $this->model = $model;
        $this->adminService = new AdminControllerService();
        parent::__construct();
    }

    public function index(): View
    {
        $users = $this->model->paginate(20);
        return view('system.admin.index', compact('users'));
    }

    public function show(int $id): View
    {
        $user = $this->model->where('id', $id)->first();
        $tempo_cadastrado = $this->dateService->getRegistrationTime($user);
        return view('system.admin.show', compact('user', 'tempo_cadastrado'));
    }

    public function edit($id): View
    {
        $user = $this->model->where('id', $id)->first();
        return view('system.admin.edit', compact('user'));
    }

    public function update(Request $request, int $id)
    {
        $user = $this->model->where('id', $id)->first();
        $this->adminService->validateDataFromForm($request, $id);
        $this->adminService->updateUser($request, $id);

        return redirect()->route('admin.show', [$user->id]);
    }
    
    public function destroy($id)
    {
        //
    }
}
