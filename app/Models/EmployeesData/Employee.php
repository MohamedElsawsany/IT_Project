<?php

namespace App\Models\EmployeesData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable=[
        'emp_name',
        'employee_number',
        'department_id',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
