<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = 'vendedor';
    protected $primaryKey = 'cod_vendedor';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['cod_vendedor', 'cod_regiao', 'nome'];

    public function regiao()
    {
        return $this->belongsTo(Regiao::class, 'cod_regiao', 'cod_regiao');
    }
}