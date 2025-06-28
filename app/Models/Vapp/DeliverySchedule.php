<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverySchedule extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'mds_delivery_schedule';

    public function venue()
    {
        return $this->belongsTo(DeliveryVenue::class, 'venue_id');
    }

    public function rsp()
    {
        return $this->belongsTo(DeliveryRsp::class, 'rsp_id');
    }
}
