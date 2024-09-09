<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class DataGrant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'userId',
        'campusId',
        'appId',
        'gradeLevelId',
        'sectionId',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];
}
