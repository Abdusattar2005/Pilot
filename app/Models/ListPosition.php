<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListPosition extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','role_id'
    ];   

    protected $hidden = [
        
    ];

    protected $casts = [
        
    ];
}
