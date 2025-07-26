<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouterInventory extends Model
{
    use HasFactory;
    protected $fillable=[
        'serial_number',
        'model_id',
        'ports',
        'flag_id',
        'site_activity_id',
        'created_by',
    ];

    protected $table = 'routers_inventory';
}
