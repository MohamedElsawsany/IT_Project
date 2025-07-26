<?php

namespace App\Models\Places;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'activity_name',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
