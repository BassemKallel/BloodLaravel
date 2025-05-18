<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    function centre(){
        return $this->belongsTo(Centre::class);
    }
}
