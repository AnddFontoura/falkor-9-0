<?php

namespace App\Http\Service;

use App\Models\User;

class DashboardService
{
    public function getUserModel(int $id): object
    {
        return $userModel = User::find($id);
    }

    public function getUserPlan(?User $user)
    {
        return $userPlan = $user->userPlan()->get();
    }
}