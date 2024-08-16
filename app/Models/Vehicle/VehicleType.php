<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    public function type()
    {
        return $this->belongsTo(VehicleType::class);
    }
}
