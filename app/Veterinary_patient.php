<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Veterinary_patient extends Model
{
    public function tutor()
    {
        return $this->belongsTo('App\Veterinary_client', 'id_client');
    }

    public function agendamentos()
    {
        return $this->hasMany('App\Veterinary_dates_booked', 'id_client');
    }
}
