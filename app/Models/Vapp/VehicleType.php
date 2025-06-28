<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'vehicle_types';

    public function vappSize()
    {
        return $this->belongsTo(VappSize::class, 'vapp_size_id');
    }
}
