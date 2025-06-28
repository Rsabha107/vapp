<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class Event extends Model
{
    use HasFactory;
    protected $table = 'events';

    // protected static function booted(){
    //     // Log::info(auth()->user()->functional_area_id);
    //     self::addGlobalScope(function(EloquentBuilder $builder){
    //         $builder->when(session()->get('workspace_id'), function ($query, $workspace) {
    //             return $query->where('events.workspace_id', $workspace);
    //         });
    //     });
    // }
    // protected $casts = [
    //     'start_time' => 'datetime: H:i',
    //     'end_time' => 'datetime: H:i',
    //   ];
    protected $appends = ["open"];

    public function getOpenAttribute(){
        return true;
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'event_id', 'id');
    }

    public function attendances()
    {
        return $this->hasMany(EventAttendance::class, 'event_id', 'id');
    }

    public function actualTaskBudgetTotal()
    {
        return $this->belongsTo(EventCategory::class, 'category_id', 'id')
                ->selectRaw('sum(tasks.actual_budget_allocated) as sum_actual_budget');
    }

    public function categories()
    {
        return $this->belongsTo(EventCategory::class, 'category_id', 'id');
    }

    public function types()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id', 'id');
    }

    public function audiences()
    {
        return $this->belongsTo(Audience::class, 'audience_id', 'id');
    }

    public function planners()
    {
        return $this->belongsTo(Planner::class, 'planner_id', 'id');
    }

    public function venues()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }

    public function locations()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function fundCategories()
    {
        return $this->belongsTo(FundCategory::class, 'fund_category_id', 'id');
    }

    public function notes()
    {
        return $this->hasMany(EventNote::class);
    }

    public function files()
    {
        return $this->hasMany(FileUpload::class);
    }

    public function workspaces()
    {
        return $this->belongsTo(Workspace::class, 'workspace_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'event_status');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'event_tag');
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_project');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_project');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_project');
    }
}
