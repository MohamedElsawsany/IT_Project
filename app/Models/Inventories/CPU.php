<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CPU extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'cpu_name',
        'created_by',
    ];

    protected $table = 'cpu_tb';
}
