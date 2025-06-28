<?php

namespace App\Models\Vapp;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryBookingNote extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'mds_booking_notes';

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getUserNameAttribute(){
        return $this->users?->name;
    }

}
