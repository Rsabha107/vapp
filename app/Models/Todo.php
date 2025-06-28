<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Todo extends Model
{
    use HasFactory;

    protected static function booted(){
        // Log::info(auth()->user()->functional_area_id);
        self::addGlobalScope(function(EloquentBuilder $builder){
            $builder->when(session()->get('workspace_id'), function ($query, $workspace) {
                return $query->where('todos.workspace_id', $workspace);
            });
        });
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_todo');
    }
}
