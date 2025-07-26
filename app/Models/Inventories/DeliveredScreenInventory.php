<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveredScreenInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'screen_id',
        'employee_id',
        'updated_at',
        'created_at',
        'backed_by',
        'created_by'
    ];

    public $timestamps = false;


    protected $table = 'delivered_screens_inventory';

}
