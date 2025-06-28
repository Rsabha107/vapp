<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryCargoType extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'mds_cargo_types';
}
