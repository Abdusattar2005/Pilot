<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','position_id'
    ];   

    protected $hidden = [        
        'created_at',
        'updated_at'        
];

    protected $casts = [
        
    ];
}
