<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Regiao;
use App\Models\PontoEstrategico;
use App\Models\Vendedor;
use App\Models\Veiculo;
use App\Models\Produto;
use App\Models\NotaFiscal;
use App\Models\ItemNota;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function index(Request $request)
    {
        $vendedorId = $request->input('vendedor_id');
        $produtoId = $request->input('produto_id');
        $veiculoId = $request->input('veiculo_id');

        // A - Listar todos os pontos estratégicos de cada região
        $regioesComPontos = Regiao::with('pontosEstrategicos')->get();

        // B - Listar os nomes das regiões cadastradas
        $regioesNomes = Regiao::select('cod_regiao', 'nome', 'cep')->get();

        // C - Listar todos os vendedores e quais veículos que eles utilizaram
        $vendedoresVeiculos = DB::table('vendedor_veiculo')
            ->join('vendedor', 'vendedor.cod_vendedor', '=', 'vendedor_veiculo.cod_vendedor')
            ->join('veiculo', 'veiculo.cod_veiculo', '=', 'vendedor_veiculo.cod_veiculo')
            ->select('vendedor.nome as vendedor', 'veiculo.placa', 'veiculo.descricao as veiculo', 'vendedor_veiculo.data')
            ->orderBy('vendedor_veiculo.data', 'desc')
            ->get();

        // D - Listar todos os vendedores responsáveis por cada região
        $vendedoresPorRegiao = Regiao::with('vendedores')->get();

        // E - Todos os produtos vendidos por um determinado vendedor
        $produtosVendedor = null;
        if ($vendedorId) {
            $produtosVendedor = DB::table('item_nota')
                ->join('nota_fiscal', 'nota_fiscal.num_nota', '=', 'item_nota.num_nota')
                ->join('produtos', 'produtos.cod_produto', '=', 'item_nota.cod_produto')
                ->where('nota_fiscal.cod_vendedor', $vendedorId)
                ->select('produtos.cod_produto', 'produtos.descricao', 'item_nota.quantidade', 'nota_fiscal.num_nota')
                ->distinct()
                ->get();
        }

        // F - Todos os vendedores que venderam um determinado produto
        $vendedoresProduto = null;
        if ($produtoId) {
            $vendedoresProduto = DB::table('item_nota')
                ->join('nota_fiscal', 'nota_fiscal.num_nota', '=', 'item_nota.num_nota')
                ->join('vendedor', 'vendedor.cod_vendedor', '=', 'nota_fiscal.cod_vendedor')
                ->where('item_nota.cod_produto', $produtoId)
                ->select('vendedor.cod_vendedor', 'vendedor.nome', 'nota_fiscal.num_nota')
                ->distinct()
                ->get();
        }

        // G - Todos os produtos que ainda não foram vendidos
        $produtosNaoVendidos = Produto::whereNotIn('cod_produto', function($query) {
            $query->select('cod_produto')->from('item_nota');
        })->get();

        // H - Histórico de utilização de um determinado veículo
        $historicoVeiculo = null;
        if ($veiculoId) {
            $historicoVeiculo = DB::table('vendedor_veiculo')
                ->join('vendedor', 'vendedor.cod_vendedor', '=', 'vendedor_veiculo.cod_vendedor')
                ->join('veiculo', 'veiculo.cod_veiculo', '=', 'vendedor_veiculo.cod_veiculo')
                ->where('vendedor_veiculo.cod_veiculo', $veiculoId)
                ->select('veiculo.placa', 'veiculo.descricao as veiculo', 'vendedor.nome as vendedor', 'vendedor_veiculo.data')
                ->orderBy('vendedor_veiculo.data', 'desc')
                ->get();
        }

        // I - A quantidade de itens de cada nota fiscal
        $quantidadeItensNota = DB::table('item_nota')
            ->join('nota_fiscal', 'nota_fiscal.num_nota', '=', 'item_nota.num_nota')
            ->select('nota_fiscal.num_nota', 'nota_fiscal.preco_total', DB::raw('SUM(item_nota.quantidade) as total_itens'))
            ->groupBy('nota_fiscal.num_nota', 'nota_fiscal.preco_total')
            ->get();

        // Listas auxiliares para selects de filtro
        $todosVendedores = Vendedor::all();
        $todosProdutos = Produto::all();
        $todosVeiculos = Veiculo::all();

        return view('relatorios', compact(
            'regioesComPontos', 'regioesNomes', 'vendedoresVeiculos', 'vendedoresPorRegiao',
            'produtosVendedor', 'vendedoresProduto', 'produtosNaoVendidos', 'historicoVeiculo',
            'quantidadeItensNota', 'todosVendedores', 'todosProdutos', 'todosVeiculos',
            'vendedorId', 'produtoId', 'veiculoId'
        ));
    }
}