<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestNumGen extends Model
{
    use HasFactory;
    protected $table = 'request_number_gen';
    protected $guarded = [];
}
