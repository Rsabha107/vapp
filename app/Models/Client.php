<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Client extends Model
{
    use HasFactory;

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'client_project');
    }

    public function workspaces() : BelongsToMany
    {
        return $this->belongsToMany(Workspace::class, 'client_workspace');
    }
}
