<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResponseTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'messageTemplateId',  
        'campusId',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];
}
