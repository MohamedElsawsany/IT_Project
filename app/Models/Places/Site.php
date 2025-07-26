<?php

namespace App\Models\Places;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;
    protected $fillable = [
        'site_name',
        'governorate_id',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
