<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkingDay extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','day'
    ];   

    protected $hidden = [        
            'created_at',
            'updated_at'        
    ];

    protected $casts = [
        
    ];
}
