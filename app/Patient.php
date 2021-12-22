<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','lastname','postlastname','gender','age','address','weight','size','imc'
    ];

    public function appointments() {
        return $this -> hasMany('App\Appointment');
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
