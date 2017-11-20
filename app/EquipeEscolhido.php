<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipeEscolhido extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'equipe_id',
        'jogo_id',
        'aposta_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        '',
    ];

    protected $table = 'equipe_escolhidos';

    public function aposta()
    {
        return $this->belongsTo('App\Aposta');
    }

}
