<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
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

    public function campeonatos() {
        return $this->belongsToMany('App\Campeonato', 'equipe_campeonato', 'equipe_id', 'campeonato_id');
    }
}
