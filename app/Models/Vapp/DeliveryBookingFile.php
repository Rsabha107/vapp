<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryBookingFile extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'mds_booking_files';
}
