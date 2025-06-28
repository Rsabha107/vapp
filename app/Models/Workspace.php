<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;

class Workspace extends Model
{
    use HasFactory;
    protected $table='workspaces';
    protected $guarded = [];

    // protected static function booted(){

    //     Log::info(auth()->user()->functional_area_id);
    //     self::addGlobalScope(function(EloquentBuilder $builder){
    //         $builder->when(auth()->user()->functional_area_id, function ($query, $user_fa) {
    //             return $query->where('functional_areas.id', $user_fa);
    //         });
    //     });
    // }

    // public function users() : BelongsToMany
    // {
    //     return $this->belongsToMany(User::class, 'user_workspace');
    // }

    public function employees() : BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_workspace');
    }

    public function clients() : BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'client_workspace');
    }

}
