<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveredPCInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'pc_id',
        'employee_id',
        'created_at',
        'updated_at',
        'created_by',
        'backed_by'
    ];
    public $timestamps = false;

    protected $table = 'delivered_pc_inventory';
}
