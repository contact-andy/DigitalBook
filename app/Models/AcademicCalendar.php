<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicCalendar extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 
        'description', 
        'start_date', 
        'end_date', 
        'eventCategoryId',
        'campusId',
        'status',
        'academicYear',        
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];
}
