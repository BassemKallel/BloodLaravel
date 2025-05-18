<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Centre;

class RendezVous extends Model
{
    protected $table = 'rendez_vous';

    protected $fillable = [
        'dateRendezVous',
        'dernierRendezVous',
        'id_donneur',
        'id_centre'
        
    ];

    function user(){
        return $this->belongTo(User::class);
    }
    public function centre()
    {
        return $this->belongsTo(Centre::class, 'id_centre');
    }

}
