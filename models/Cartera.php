<?php

namespace Models;

class Cartera extends Model
{
    protected $table = 'cateracompleta';
    protected $primaryKey = 'codigo_sucursal';
    public $timestamps = false;
}