<?php

namespace App\Models;

use App\Exceptions\CustomException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;  

    const ROLE_COMPANY = 1;
    const ROLE_PILOT = 2;
    const ROLE_FILIGHT_ATTENDANT = 3;
    const ROLE_TECH_STAFF = 4;    
    const ROLE_LIST  = [1,2,3,4];

    protected $fillable = [
        'name','guard_name'        
    ];   

    protected $hidden = [
        
    ];

    protected $casts = [
        
    ];
    
    public static function getRoleName(int $role_id):string {

        return match($role_id) { 
            self::ROLE_COMPANY => 'company',
            self::ROLE_PILOT => 'pilot',
            self::ROLE_FILIGHT_ATTENDANT => 'flight_attendant',
            self::ROLE_TECH_STAFF => 'tech_staff',
            default => CustomException(1001)
        };
        //return Role::where('id', $id)->first()->name;
    }

}
