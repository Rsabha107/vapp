<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VappDriver extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table="vapp_drivers";


    public function status()
    {
        return $this->belongsTo(DriverStatus::class, 'status_id');
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->first_name} {$this->last_name}",
            set: fn ($value) => [
                'first_name' => explode(' ', $value)[0],
                'last_name' => explode(' ', $value)[1] ?? ''
            ]
        );
    }

}
