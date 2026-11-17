<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'cod_cliente';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['cod_cliente', 'nome'];
}