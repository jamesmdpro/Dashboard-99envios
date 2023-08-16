<?php

namespace Models;

class User extends Model
{
    // Nombre de la tabla a la que está vinculado el modelo
    protected $table = 'new_user';
    public $timestamps = false;


    // Los campos que pueden ser llenados masivamente (en la inserción masiva)
    protected $fillable = [
        'nombre_completo',
        'correo',
        'usuario',
        'contrasena',
    ];


    // Los campos que se deben ocultar al convertir el modelo a un arreglo o JSON
    protected $hidden = [
        //'contrasena',
    ];
}
