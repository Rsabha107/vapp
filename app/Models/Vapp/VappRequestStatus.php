<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VappRequestStatus extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'request_statuses';

}
