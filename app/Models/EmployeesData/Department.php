<?php

namespace App\Models\EmployeesData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable=[
        'department_name',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $table='employees_departments';
}
