<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingCapacity extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'vapp_parking_capacity';

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function vehicle_type()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }
    public function parking_master()
    {
        return $this->belongsTo(ParkingMaster::class, 'parking_id');
    }
}
