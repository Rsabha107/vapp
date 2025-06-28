<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingMaster extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'parking_master';


    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function functional_areas()
    {
        return $this->belongsToMany(FunctionalArea::class, 'parking_master_fa', 'parking_master_id', 'functional_area_id');
    }

        public function vapp_sizes()
    {
        return $this->belongsToMany(VappSize::class, 'parking_master_size', 'parking_master_id', 'vapp_size_id');
    }

    public function vapp_variations()
    {
        return $this->hasMany(VappVariation::class, 'parking_id');
    }


}
