<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLicense extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id','license_id'
    ];   

    protected $hidden = [        
            'created_at',
            'updated_at'        
    ];

    protected $casts = [
        
    ];
}
