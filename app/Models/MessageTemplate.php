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
        'status',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];
}
