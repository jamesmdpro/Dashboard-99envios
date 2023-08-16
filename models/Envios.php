<?php

namespace Models;

class Envios extends Model
{
    protected $table = 'envioscompleto';
    protected $primaryKey = 'codigo_sucursal';
    public $timestamps = false;
}