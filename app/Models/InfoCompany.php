<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','company_name','user_id'
    ];   

    protected $hidden = [
        'created_at',
        'updated_at'   
    ];

    protected $casts = [
        
    ];
}
