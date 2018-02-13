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

    protected $with = ['equipes'];

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
        return $this->hasOne('App\Equipe');
    } 

    protected $table = 'jogo_aposta';
}
