<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListLicense extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];   

    protected $hidden = [
        
    ];

    protected $casts = [
        
    ];
}
