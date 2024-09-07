<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'survey_id',
        'question',  
        'options',  
        'type',  
        'is_required',  
        'campusId',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];
}
