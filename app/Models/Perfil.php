<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    //Relacion invertida perfil-usuario
    public function perfilUser(){
        return $this -> belongsTo(User::class, 'user_id');
    }
}


