<?php

namespace App\Models\Places;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'site_id',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $table = 'sites_activities';
}
