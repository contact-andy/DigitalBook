<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DcbApplicationList extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'title', 
        'description', 
        'icon', 
        'url', 
        'status',
        'appCatId',        
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];
}
