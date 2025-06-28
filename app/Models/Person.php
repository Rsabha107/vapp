<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $table='person';

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'person_task');
    }

    public function todos()
    {
        return $this->belongsToMany(Todo::class, 'person_todo');
    }

    public function workspaces()
    {
        return $this->belongsToMany(Workspace::class, 'person_workspace');
    }


}

