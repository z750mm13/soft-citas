<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type','description','datetime','user_id','patient_id',
    ];

    public function patient() {
        return $this -> belongsTo('App\Patient');
    }

    public function user() {
        return $this -> belongsTo('App\User');
    }

    public function consultation() {
        return $this -> hasOne('App\Consultation');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'datetime' => 'datetime',
    ];
}
