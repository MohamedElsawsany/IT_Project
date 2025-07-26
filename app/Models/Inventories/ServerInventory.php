<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ServerInventory extends Model
{
    use HasFactory;
    protected $fillable=[
        'serial_number',
        'model_id',
        'cpu_id',
        'gpu1_id',
        'gpu2_id',
        'os_id',
        'hdd_storage',
        'ssd_storage',
        'flag_id',
        'ram',
        'site_activity_id',
        'created_by',
    ];

    protected $table = 'servers_inventory';
}
