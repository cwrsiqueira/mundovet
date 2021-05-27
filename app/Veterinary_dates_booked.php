<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Veterinary_dates_booked extends Model
{
    public function client()
    {
        return $this->belongsTo('App\Veterinary_client', 'id_client');
    }

    public function patient()
    {
        return $this->belongsTo('App\Veterinary_patient', 'id_patient');
    }
}
