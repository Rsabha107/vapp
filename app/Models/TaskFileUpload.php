<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskFileUpload extends Model
{
    use HasFactory;
    protected $table = 'task_files';
    protected $appends = ['user_name'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getUserNameAttribute(){
        return $this->users?->name;
    }

}
