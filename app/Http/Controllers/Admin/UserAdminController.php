<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Service\AdminControllerService;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class UserAdminController extends Controller
{protected $model;
    protected $adminService;

    public function __construct(User $model) {
        $this->model = $model;
        $this->adminService = new AdminControllerService();
        parent::__construct();
    }

    public function index(Request $request): View
    {
        $users = $this->adminService->searchUserIndex($request, $this->model);
        
        return view('system.admin.user.index', compact('users'));
    }

    public function show(int $id): View
    {
        $user = $this->model->withTrashed()->where('id', $id)->first();
        $registeredTime = $this->dateService->toHuman($user->created_at);
        return view('system.admin.user.show', compact('user', 'registeredTime'));
    }

    public function edit($id): View
    {
        $user = $this->model->withTrashed()->where('id', $id)->first();
        return view('system.admin.user.edit', compact('user'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $user = $this->model->withTrashed()->where('id', $id)->first();
        $this->adminService->validateDataFromForm($request, $id);
        $this->adminService->updateUser($request, $id);

        return redirect()->route('admin.user.show', [$user->id]);
    }

    public function destroy(int $id)
    {
        $this->adminService->destroyUser($id);

        return redirect()->route('admin.user.show', [$id]);
    }

    public function restore(int $id): RedirectResponse
    {
        $this->adminService->restoreUser($id);

        return redirect()->route('admin.user.show', [$id]);
    }

    public function verify(int $id): RedirectResponse
    {
        $this->adminService->addEmailVerification($id);

        return redirect()->route('admin.user.show', [$id]);
    }

    public function removeVerified(int $id): RedirectResponse
    {
        $this->adminService->removeEmailVerification($id);

        return redirect()->route('admin.user.show', [$id]);
    }
}
