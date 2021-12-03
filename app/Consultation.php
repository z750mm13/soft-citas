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

    public function prescriptions() {
        return $this -> hasMany('App\Prescription');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
