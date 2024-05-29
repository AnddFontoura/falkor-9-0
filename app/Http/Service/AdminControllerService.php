<?php

namespace App\Http\Service;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminControllerService
{
    public function validateDataFromForm(Request $request, int $id): void
    {
        $user = $this->getUser($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    public function updateUser(Request $request, int $id): void
    {
        $user = $this->getUser($id);
        $this->setNewDataForUser($request, $user);
        $user->save();
    }

    public function setNewDataForUser(Request $request, User $user): void
    {
        $is_admin = isset($request->is_admin) ? true : false;
        $user->is_admin = $is_admin;

        $user->password = Hash::make($request->password);

        $data = $request->only([
            'name',
            'email',
        ]);

        $user->fill($data);
    }

    public function getUser($id): ?User
    {
        return User::where('id', $id)->first();
    }
}