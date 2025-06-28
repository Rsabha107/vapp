<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchList extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'vapp_matches';
    protected $appends = [
        'match_code_date',
        'match_venue',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function getMatchCodeDateAttribute()
    {
        return $this->match_code . ' - (' . format_date($this->match_date). ')';
    }

    public function getMatchVenueAttribute()
    {
        return $this->match_code . ' (' . $this->venue?->title . ')';
    }
    public function match_category()
    {
        return $this->belongsTo(MatchCategory::class, 'match_category_id');
    }
}
