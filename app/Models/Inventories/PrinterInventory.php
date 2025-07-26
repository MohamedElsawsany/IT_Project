<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrinterInventory extends Model
{
    use HasFactory;
    protected $fillable=[
        'serial_number',
        'category_id',
        'model_id',
        'flag_id',
        'site_activity_id',
        'created_by',
    ];

    protected $table = 'printers_inventory';
}
