<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $table = 'veiculo';
    protected $primaryKey = 'cod_veiculo';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['cod_veiculo', 'placa', 'descricao'];
}