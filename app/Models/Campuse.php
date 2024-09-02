<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campuse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 
        'code', 
        'yearsOfEsta', 
        'level', 
        'country',
        'city',
        'subcity',        
        'wereda',
        'telephone',
        'mobile',
        'website',
        'email',
        'status',
    ];

    protected $dates = ['deleted_at'];
}
