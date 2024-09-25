<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class MessageTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'type',  
        'messageCategoryId',
        'campusId',
        'gradeLevels',
        'created_by',
        'updated_by',
        'content_ok',
        'grammar_ok',
        'spelling_ok',
        'comments',
        'approved_by',
    ];

    protected $dates = ['deleted_at'];
}
