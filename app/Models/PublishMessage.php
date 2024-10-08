<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublishMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'campusId',
        'gradeLevelId',
        'sectionId',  
        'messageTemplateId',
        'status',
        'comment',
        'approved_by',
        'created_by',
        'updated_by',
        'academicYear',
    ];

    protected $dates = ['deleted_at'];
}