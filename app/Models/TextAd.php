<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextAd extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'link',
        'status',
        'start_date',
        'end_date',
    ];
}
