<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','name','age','country','region','city',
        'total_flight_time','salary_min','salarie_type_id',
    ];   

    protected $hidden = [
        
    ];

    protected $casts = [
        'total_flight_time' => 'integer',
        'salary_min' => 'integer',
        'salarie_type_id' => 'integer',
    ];
}
