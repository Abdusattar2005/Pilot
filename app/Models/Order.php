<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'position_id',
        'contract_id',
        'plane_id',
        'comment',
        'total_flight_time',
        'salary_min',
        'salarie_type_id',
        'departure',
        'departure_date',
        'arrival',
        'arrival_date',
    ];   

    protected $hidden = [
        //'created_at',
        //'updated_at'   
    ];

    protected $casts = [
        
    ];

    public function workingDays()
    {
        return $this->hasMany(OrderWorkingDay::class,'order_id','id');
    }

    public function licenses()
    {
        return $this->hasMany(OrderLicense::class,'order_id','id');
    }

    public function responses()
    {
        return $this->hasMany(OrderRespond::class,'order_id','id');
    }
}
