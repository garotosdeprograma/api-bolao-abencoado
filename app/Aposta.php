<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aposta extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jogo_id',
        'usuario_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        '',
    ];

    /**
     * Defining one to many inverse relationship with App\User.
     *
     * @var function
     */
    public function usuario()
    {
        return $this->belongsTo('App\Usuario');
    }

    /**
     * Defining many to many relationship with App\Jogo.
     *
     * @var function
     */
    public function jogoAposta() {
        return $this->belongsToMany('App\Jogo', 'jogo_aposta', 'aposta_id', 'jogo_id');
    }


    /**
     * Defining many to many relationship with App\JogoAposta.
     *
     * @var function
     */
    public function equipeInAposta() {
        return $this->hasMany('App\ApostaJogo');
    }
}
