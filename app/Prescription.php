<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dose', 'description','consultation_id','medicine_id'
    ];

    public function consultation() {
        return $this -> belongsTo('App\Consultation');
    }

    public function medicine() {
        return $this -> belongsTo('App\Medicine');
    }
}
