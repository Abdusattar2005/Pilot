<?php

namespace App\Services\V1\EditUser;

use App\Models\Role;
use App\Models\User;
use App\ValueObject\EditUser\EditUserRole1Vo;
use App\ValueObject\EditUser\EditUserRole2Vo;
use App\ValueObject\EditUser\EditUserRole3Vo;
use App\ValueObject\EditUser\EditUserRole4Vo;

class EditUserFactory
{
    public static function edit(User $user, array $request): AbstractEditUser
    {
        return match ($user->role_id) {
            Role::ROLE_COMPANY => new EditUserRole1Service($user, new EditUserRole1Vo($request)),
            Role::ROLE_PILOT => new EditUserRole2Service($user, new EditUserRole2Vo($request)),
            Role::ROLE_FILIGHT_ATTENDANT => new EditUserRole3Service($user, new EditUserRole3Vo($request)),
            Role::ROLE_TECH_STAFF => new EditUserRole3Service($user, new EditUserRole4Vo($request)),
           default => CustomException(1012)
        };
    }
}
