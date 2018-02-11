<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckAposta extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rodada_id',
        'chave_aposta'
    ];

    protected $table = 'check_aposta';
}
