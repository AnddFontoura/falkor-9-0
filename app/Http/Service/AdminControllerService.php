<?php

namespace App\Http\Service;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminControllerService
{
    public function searchUserIndex(Request $request, ?User $user)
    {
        
        $this->validateSearchIndex($request);
        $filter = request()->only([
            'userId',
            'userName',
            'userEmail',
            'email_verified_at',
            'deleted_at',
            'is_admin',
        ]);

        $users = $user->select('users.*');

        if(isset($filter['userId']) && $filter['userId'] != null) {
            $users = $users->where('users.id', '=' , $filter['userId']);
        }

        if(isset($filter['userName']) && $filter['userName'] != null) {
            $users = $users->where('users.name', 'like' , '%' . $filter['userName'] . '%');
        }

        if(isset($filter['userEmail']) && $filter['userEmail'] != null) {
            $users = $users->where('users.email', 'like' , '%' . $filter['userEmail'] . '%');
        }

        if(isset($filter['email_verified_at']) && $filter['email_verified_at']) {
            $users = $users->where('users.email_verified_at', '!=' , null);
        }

        if(isset($filter['deleted_at']) && $filter['deleted_at']) {
            $users = $users->where('users.deleted_at', '!=' , null);
        }

        if(isset($filter['is_admin']) && $filter['is_admin']) {
            $users = $users->where('users.is_admin', '=' , 1);
        }

        return $users->withTrashed()->paginate(20);
    }

    public function validateSearchIndex(Request $request)
    {
        $request->validate([
            'userId' => 'nullable|integer',
            'userName' => 'nullable|string|min:1|max:254',
            'userEmail' => 'nullable|max:254',
            'email_verified_at' => 'nullable|integer',
            'deleted_at' => 'nullable|integer',
            'is_admin' => 'nullable|integer'
        ]);
    }

    public function validateDataFromForm(Request $request, int $id): void
    {
        $user = $this->getUser($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        $isAdmin = isset($request->is_admin) ? true : false;
        $user->is_admin = $isAdmin;

        $user->password = Hash::make($request->password);

        $data = $request->only([
            'name',
            'email',
        ]);

        $user->fill($data);
    }

    public function destroyUser(int $id): void
    {  
        $user = $this->getUser($id);
        $user->delete();
    }

    public function restoreUser(int $id): void
    {
        $user = $this->getUser($id);
        $user->restore();
    }

    public function getUser($id): ?User
    {
        return User::withTrashed()->where('id', $id)->first();
    }

    public function getModel(): User
    {
        return new User();
    }
}