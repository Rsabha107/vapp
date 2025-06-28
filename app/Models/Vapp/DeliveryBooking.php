<?php

namespace App\Models\Vapp;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryBooking extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'mds_booking';

    public static function boot(){

        parent::boot();

        static::creating(function($model){
            $numGen = DeliveryNumGen::firstOrFail();
            $last_number = $numGen->max('last_number') + 1;
            $numGen->update(['last_number' => $last_number]);

            $model->booking_ref_number = 'MDS'.'-'.str_pad($last_number, 5, '0', STR_PAD_LEFT);
        });
    }

    public function created_by_who()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user_name()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(MdsEvent::class, 'event_id');
    }

    public function venue()
    {
        return $this->belongsTo(DeliveryVenue::class, 'venue_id');
    }

    public function status()
    {
        return $this->belongsTo(DeliveryBookingStatus::class, 'delivery_status_id');
    }

    public function rsp()
    {
        return $this->belongsTo(DeliveryRsp::class, 'rsp_id');
    }

    public function client()
    {
        return $this->belongsTo(FunctionalArea::class, 'client_id');
    }

    public function cargo()
    {
        return $this->belongsTo(DeliveryCargoType::class, 'cargo_id');
    }

    // public function schedule_period()
    // {
    //     return $this->belongsTo(DeliverySchedulePeriod::class, 'schedule_period_id');
    // }

    public function schedule()
    {
        return $this->belongsTo(BookingSlot::class, 'schedule_period_id');
    }

    public function driver()
    {
        return $this->belongsTo(MdsDriver::class, 'driver_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(DeliveryVehicle::class, 'vehicle_id');
    }

    public function vehicle_type()
    {
        return $this->belongsTo(DeliveryVehicleType::class, 'vehicle_type_id');
    }

    public function delivery_type()
    {
        return $this->belongsTo(DeliveryType::class, 'dispatch_id');
    }

    public function zone()
    {
        return $this->belongsTo(DeliveryZone::class, 'loading_zone_id');
    }

    public function notes()
    {
        return $this->hasMany(DeliveryBookingNote::class, 'booking_id')->orderBy('created_at', 'desc');
    }
}
