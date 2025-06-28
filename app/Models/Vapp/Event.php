<?php

namespace App\Models\Vapp;

use App\Models\GlobalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = "events";
    protected $guarded = [];


    public function active_status()
    {
        return $this->belongsTo(GlobalStatus::class, 'active_flag');
    }

    public function venues()
    {
        return $this->belongsToMany(Venue::class, 'venue_event', 'venue_id', 'event_id');
    }
}
