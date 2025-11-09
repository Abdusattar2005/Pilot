<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderWorkingDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id','day'
    ];   

    protected $hidden = [        
            'created_at',
            'updated_at'        
    ];

    protected $casts = [
        
    ];
}
