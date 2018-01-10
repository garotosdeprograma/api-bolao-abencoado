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

    /**
     * Defining many to many relationship with App\Aposta.
     *
     * @var function
     */
    public function apostas() {
        return $this->belongsToMany('App\Aposta', 'jogo_aposta', 'jogo_id', 'aposta_id');
    }

    /**
     * Obter campeonato do jogo.
     */
    public function campeonato()
    {
        return $this->hasOne('App\Campeonato');
    }

    /**
     * Obter rodada do jogo.
     */
    public function rodada()
    {
        return $this->belongsTo('App\Rodada');
    }

    /**
     * Obter equipes do jogo.
     */
    public function equipes()
    {
        return $this->hasMany('App\Equipe');
    }



}
