<?php

namespace App\Policies;

use App\Models\Gaji;
use App\Models\User;

class GajiPolicy
{
    public function view(User $user, Gaji $gaji): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isTukang()) {
            return $user->tukang?->id === $gaji->tukang_id;
        }

        return false;
    }
}