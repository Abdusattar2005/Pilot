<?php
namespace App\Services\V1\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AuthService
{
    
    public function getToken(User $user):User
    {
        $user->token = $user->createToken('LaravelSanctumAuth')->plainTextToken;
        return $user;
    }

 /* 
    public function checkRole(string $role):bool|CustomException
    {
        $all_roles_in_database = Role::all()->pluck('name')->toArray();
        if(!in_array($role,$all_roles_in_database)) CustomException::error(1000);
        return true;
    }

    public function getRolesName():array
    {
        return Role::all()->pluck('name')->toArray();
    }*/


}

