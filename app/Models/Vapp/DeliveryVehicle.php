<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryVehicle extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'mds_vehicles';

    public function vehicle_type()
    {
        return $this->belongsTo(DeliveryVehicleType::class, 'vehicle_type_id');
    }

    public function status()
    {
        return $this->belongsTo(DriverStatus::class, 'status_id');
    }
}
