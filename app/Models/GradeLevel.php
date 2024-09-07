<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GradeLevel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'level',
        'description',  
        'levelOrder',
        'status',
        'campusId',
        'created_by',
        'updated_by',
    ];
    
    protected $dates = ['deleted_at'];
}
