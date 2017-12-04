<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campeonato extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        '',
    ];

    public function equipes() 
    {
        return $this->belongsToMany('App\Equipe', 'equipe_campeonato', 'campeonato_id', 'equipe_id');
    }

    public function rodadas()
    {
        return $this->hasMany('App\Rodada');
    }
}
