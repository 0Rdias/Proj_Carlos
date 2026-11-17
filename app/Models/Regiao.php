<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regiao extends Model
{
    protected $table = 'regiao';
    protected $primaryKey = 'cod_regiao';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['cod_regiao', 'nome', 'cep'];

    public function pontosEstrategicos()
    {
        return $this->hasMany(PontoEstrategico::class, 'cod_regiao', 'cod_regiao');
    }

    public function vendedores()
    {
        return $this->hasMany(Vendedor::class, 'cod_regiao', 'cod_regiao');
    }
}