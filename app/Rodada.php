<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rodada extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'numero',
        'inicio',
        'fim',
        'campeonato_id',
        'ano'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        '',
    ];
}
