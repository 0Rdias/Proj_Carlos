<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    protected $primaryKey = 'cod_produto';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['cod_produto', 'descricao', 'estoque', 'status_ativo'];
}