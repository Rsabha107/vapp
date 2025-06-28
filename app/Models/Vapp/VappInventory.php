<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VappInventory extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'vapp_inventories';

    public function getInventoryParkingCodeAttribute()
    {
        return "{$this->parking->parking_code}";
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function parking()
    {
        return $this->belongsTo(ParkingMaster::class, 'parking_id');
    }
    public function variation()
    {
        return $this->belongsTo(VappVariation::class, 'variation_id');
    }
    public function vapp_size()
    {
        return $this->belongsTo(VappSize::class, 'vapp_size_id');
    }

}
