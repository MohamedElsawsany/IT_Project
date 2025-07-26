<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModemInventory extends Model
{
    use HasFactory;
    protected $fillable=[
        'serial_number',
        'model_id',
        'type_id',
        'flag_id',
        'site_activity_id',
        'created_by',
    ];
    protected $table = 'modems_inventory';
}
