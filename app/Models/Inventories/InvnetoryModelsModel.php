<?php

namespace App\Models\Inventories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvnetoryModelsModel extends Model
{
    use HasFactory;

    protected $fillable =[
        'category_name',
        'brand_id',
        'model_name',
        'created_by'
    ];

    protected $table = 'inventory_models';
}
