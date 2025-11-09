<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRespond extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id','user_id','status_approved'
    ];   

    protected $hidden = [        
            //'created_at',
            //'updated_at'        
    ];

    protected $casts = [
        
    ];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
