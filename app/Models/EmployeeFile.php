<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFile extends Model
{
    use HasFactory;

    public function emps()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
