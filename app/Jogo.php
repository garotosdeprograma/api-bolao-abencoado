<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jogo extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estadio',
        'equipe_casa',
        'equipe_visitante',
        'inicio',
        'fim',
        'campeonato_id',
        'rodada_id'
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
