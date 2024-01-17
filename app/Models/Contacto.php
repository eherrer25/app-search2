<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;


    public static function validarContacto($data,$dni)
    {
        // 0 = verificado, 1 = por verificar, 2 = no verificado
        // $estados = [0 => 'verificado', 1 => 'por verificar', 2 => 'no verificado'];

        $favorite = Favorite::where('dni',$dni)->where('contact',$data)->orderBy('updated_at', 'DESC')->first();

        return $favorite ? $favorite->status : '';
    }
}
