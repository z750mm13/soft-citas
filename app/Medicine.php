<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','expiration','barcode','stock',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'expiration' => 'datetime',
    ];
}
