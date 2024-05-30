<?php

namespace App\Http\Service;

use App\Models\User;

class IsAdminService
{   
    public static function isAdminCheck(int $id): bool
    {
        return self::userExists($id) && self::isUserAdmin($id);
    }

    protected static function isUserAdmin(int $id): bool
    {
        $userModel = self::returnUser($id);
        return $userModel !== null && $userModel->is_admin == 1;
    } 

    protected static function userExists(int $id): bool
    {
        return self::returnUser($id) !== null;
    }

    protected static function returnUser(int $id): ?User
    {
        return User::where('id', $id)->first();
    }
}