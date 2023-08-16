<?php

namespace Models;

class UsuariosOld extends Model
{
    protected $table = 'wp_users';
    protected $primaryKey = 'ID';
    public $timestamps = false;
}