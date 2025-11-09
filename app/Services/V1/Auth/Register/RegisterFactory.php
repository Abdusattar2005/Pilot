<?php

namespace App\Services\V1\Auth\Register;

use App\Models\Role;
use App\ValueObject\Register\RegisterRole1Vo;
use App\ValueObject\Register\RegisterRole2Vo;
use App\ValueObject\Register\RegisterRole3Vo;
use App\ValueObject\Register\RegisterRole4Vo;

class RegisterFactory
{
    public static function createUser(int $role_id, array $request): AbstractRegister
    {
        return match ($role_id) {
            Role::ROLE_COMPANY => new RegisterRole1Service($role_id, new RegisterRole1Vo($request)),
            Role::ROLE_PILOT => new RegisterRole2Service($role_id, new RegisterRole2Vo($request)),
            Role::ROLE_FILIGHT_ATTENDANT => new RegisterRole3Service($role_id, new RegisterRole3Vo($request)),
            Role::ROLE_TECH_STAFF => new RegisterRole4Service($role_id, new RegisterRole4Vo($request)),
           default => CustomException(1012)
        };
    }
}
