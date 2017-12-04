<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApostaJogo extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'aposta_id',
        'jogo_id',
        'equipe_id'
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
