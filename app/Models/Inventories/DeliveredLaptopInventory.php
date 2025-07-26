<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveredLaptopInventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'laptop_id',
        'employee_id',
        'created_at',
        'updated_at',
        'created_by',
        'backed_by',
    ];
    public $timestamps = false;

    protected $table = 'delivered_laptops_inventory';
}
