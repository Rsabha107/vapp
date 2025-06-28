<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'employees_all';

    public static function boot(){

        parent::boot();

        static::creating(function($model){
            $personNumGen = PersonNumGen::firstOrFail();
            $last_number = $personNumGen->max('last_number') + 1;
            $personNumGen->update(['last_number' => $last_number]);

            $model->employee_number = 'ABC'.'-'.str_pad($last_number, 5, '0', STR_PAD_LEFT);
        });
    }

    public function emp_files()
    {
        return $this->hasOne(EmployeeFile::class, 'employee_id');
    }

    public function employee_types()
    {
        return $this->hasOne(EmployeeType::class, 'id', 'employee_type');
    }

    public function departments()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    public function designations()
    {
        return $this->hasOne(Designation::class, 'id', 'designation_id');
    }

    public function genders()
    {
        return $this->hasOne(Gender::class, 'id', 'gender');
    }

    public function managers()
    {
        return $this->hasOne(Employee::class, 'id', 'reporting_to_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Event::class, 'employee_project');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'employee_task');
    }

    public function workspaces(){
        return $this->belongsToMany(Workspace::class, 'employee_workspace');
    }

}
