<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Veterinary_client extends Model
{
    public function pets()
    {
        return $this->hasMany('App\Veterinary_patient', 'id_client');
    }

    public function agendamentos()
    {
        return $this->hasMany('App\Veterinary_dates_booked', 'id_client');
    }
}
