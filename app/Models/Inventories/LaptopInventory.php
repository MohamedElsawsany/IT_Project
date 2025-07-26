<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaptopInventory extends Model
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
        'screen_inch',
        'site_activity_id',
        'created_by',
    ];

    protected $table = 'laptops_inventory';
}
