<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description','appointment_id',
    ];

    public function appointment() {
        return $this -> belongsTo('App\Appointment');
    }

    public function prescription() {
        return $this -> hasOne('App\Prescription');
    }
}
