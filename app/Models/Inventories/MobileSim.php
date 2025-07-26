<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileSim extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'mobile_number',
        'ip',
        'assigned_to',
        'created_by'
    ];

    protected $table = 'mobiles_sim_inventories';
}
