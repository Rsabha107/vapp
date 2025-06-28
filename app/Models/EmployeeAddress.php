<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAddress extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'employee_addresses';

    public function employees()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}
