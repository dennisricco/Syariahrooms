<?php

namespace App\Repositories\SuperAdmin\Profile;

use App\Models\User;

class ProfileRepository
{
    public function getUserProfile($userId)
    {
        return User::findOrFail($userId);
    }

    public function updateUserProfile($userId, $data)
    {
        $user = User::findOrFail($userId);
        $user->update($data);
        return $user;
    }
}