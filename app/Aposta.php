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
        'pagamento',
        'aposta_pago',
        'campeonato_id',
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
    public function users()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Defining many to many relationship with App\Jogo.
     *
     * @var function
     */
    public function jogos() {
        return $this->belongsToMany('App\jogo', 'jogo_aposta', 'aposta_id', 'jogo_id');
    }
}
