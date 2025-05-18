<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centre extends Model
{
    protected $fillable = [
    'name',
    'address',
    'phone',
    'email',
    'password',
    'role',
    'capacite_max',
];

    
    public function rendezVous(){
        return $this->hasMany(RendezVous::class, 'id_centre');
    }


}
