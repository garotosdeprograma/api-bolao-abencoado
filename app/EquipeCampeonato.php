<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipeCampeonato extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'equipe_id', 'campeonato_id'
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
     * Get the equipe that owns the EquipeCampeonto.
     */
    public function equipe()
    {
        return $this->belongsTo('App\Equipe');
    }

    /**
     * Get the campeonato that owns the EquipeCampeonto.
     */
    public function campeonato()
    {
        return $this->belongsTo('App\Campeonato');
    }
}
