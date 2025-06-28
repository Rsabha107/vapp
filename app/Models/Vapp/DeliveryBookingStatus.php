<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryBookingStatus extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'mds_booking_status';
}
