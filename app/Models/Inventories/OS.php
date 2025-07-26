<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OS extends Model
{
    use HasFactory;
    protected $fillable = [
        'os_name',
        'created_by'
    ];

    protected $table = 'operating_systems';
}
