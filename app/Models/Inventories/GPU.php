<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPU extends Model
{
    use HasFactory;
    protected $fillable = [
        'gpu_name',
        'created_by'
    ];

    protected $table = 'gpu_tb';
}
