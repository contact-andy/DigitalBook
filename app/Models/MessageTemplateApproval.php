<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageTemplateApproval extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'message_template_id',
        'content_ok',
        'grammar_ok',
        'spelling_ok',
        'comments',
        'approved_by',
    ];

    protected $dates = ['deleted_at'];
}
