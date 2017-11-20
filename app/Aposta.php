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

    public function equipeEscolhidos()
    {
        return $this->hasMany('App\EquipeEscolhido');
    }
}
