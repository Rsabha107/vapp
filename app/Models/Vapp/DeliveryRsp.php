<?php

namespace App\Models\Vapp;

use App\Models\GlobalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryRsp extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'mds_delivery_rsp';

    public function active_status()
    {
        return $this->belongsTo(GlobalStatus::class, 'active_flag');
    }
}
