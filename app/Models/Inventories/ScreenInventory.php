<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenInventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'serial_number',
        'screen_inch',
        'model_id',
        'flag_id',
        'site_activity_id',
        'created_by',
    ];
    protected $table = 'screens_inventory';
}
