<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class DeliveredAccessPointInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'access_point_id',
        'employee_id',
        'updated_at',
        'created_at',
        'backed_by',
        'created_by'
    ];
    public $timestamps = false;

    protected $table = 'delivered_access_points_inventory';
}
