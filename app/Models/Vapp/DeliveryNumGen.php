<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNumGen extends Model
{
    use HasFactory;
    protected $table = 'mds_number_gen';
    protected $guarded = [];

}
