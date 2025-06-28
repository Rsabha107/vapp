<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VappPrintBatch extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'vapp_print_batches';


    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function vapp_sizes()
    {
        return $this->belongsToMany(VappSize::class, 'vapp_variation_size', 'vapp_variation_id', 'vapp_size_id');
    }

    public function venues()
    {
        return $this->belongsToMany(Venue::class, 'vapp_variation_venue', 'vapp_variation_id', 'venue_id');
    }

    public function functional_areas()
    {
        return $this->belongsToMany(FunctionalArea::class, 'vapp_variation_fa', 'vapp_variation_id', 'fa_id');
    }

    public function matchs()
    {
        return $this->belongsToMany(MatchList::class, 'vapp_variation_match', 'vapp_variation_id', 'match_id')->orderBy('vapp_matches.match_code');
    }

    // public function match()
    // {
    //     return $this->belongsTo(MatchList::class, 'match_id');
    // }

    public function parking()
    {
        return $this->belongsTo(ParkingMaster::class, 'variation_id');
    }

        public function vapp_size()
    {
        return $this->belongsTo(VappSize::class, 'vapp_size_id');
    }
}
