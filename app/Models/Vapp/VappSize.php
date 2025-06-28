<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VappSize extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'vapp_sizes';
}
