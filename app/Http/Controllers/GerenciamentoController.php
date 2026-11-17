<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Regiao;
use App\Models\PontoEstrategico;
use App\Models\Vendedor;
use App\Models\Veiculo;
use App\Models\Produto;
use App\Models\Cliente;
use App\Models\NotaFiscal;
use App\Models\ItemNota;
use Illuminate\Support\Facades\DB;

class GerenciamentoController extends Controller
{
    public function index()
    {
        return view('gerenciamento', [
            'regioes' => Regiao::all(),
            'pontos' => PontoEstrategico::with('regiao')->get(),
            'vendedores' => Vendedor::with('regiao')->get(),
            'veiculos' => Veiculo::all(),
            'produtos' => Produto::all(),
            'clientes' => Cliente::all(),
            'vendedorVeiculo' => DB::table('vendedor_veiculo')
                ->join('vendedor', 'vendedor.cod_vendedor', '=', 'vendedor_veiculo.cod_vendedor')
                ->join('veiculo', 'veiculo.cod_veiculo', '=', 'vendedor_veiculo.cod_veiculo')
                ->select('vendedor_veiculo.*', 'vendedor.nome as vendedor_nome', 'veiculo.placa as veiculo_placa')
                ->get(),
        ]);
    }

    // --- CADASTROS (STORE) ---

    public function storeRegiao(Request $request)
    {
        $data = $request->validate([
            'cod_regiao' => 'required|integer|unique:regiao,cod_regiao',
            'nome' => 'required|string|max:100',
            'cep' => 'nullable|string|max:20',
        ]);
        Regiao::create($data);
        return back()->with('success', 'Região cadastrada com sucesso!');
    }

    public function storePonto(Request $request)
    {
        $data = $request->validate([
            'cod_ponto' => 'required|integer|unique:ponto_estrategico,cod_ponto',
            'cod_regiao' => 'required|integer|exists:regiao,cod_regiao',
            'descricao' => 'required|string|max:255',
        ]);
        PontoEstrategico::create($data);
        return back()->with('success', 'Ponto Estratégico cadastrado com sucesso!');
    }

    public function storeVendedor(Request $request)
    {
        $data = $request->validate([
            'cod_vendedor' => 'required|integer|unique:vendedor,cod_vendedor',
            'cod_regiao' => 'required|integer|exists:regiao,cod_regiao',
            'nome' => 'required|string|max:100',
        ]);
        Vendedor::create($data);
        return back()->with('success', 'Vendedor cadastrado com sucesso!');
    }

    public function storeVeiculo(Request $request)
    {
        $data = $request->validate([
            'cod_veiculo' => 'required|integer|unique:veiculo,cod_veiculo',
            'placa' => 'required|string|max:20',
            'descricao' => 'nullable|string|max:255',
        ]);
        Veiculo::create($data);
        return back()->with('success', 'Veículo cadastrado com sucesso!');
    }

    public function storeVendedorVeiculo(Request $request)
    {
        $request->validate([
            'cod_vendedor' => 'required|integer|exists:vendedor,cod_vendedor',
            'cod_veiculo' => 'required|integer|exists:veiculo,cod_veiculo',
            'data' => 'required|date',
        ]);
        DB::table('vendedor_veiculo')->insert([
            'cod_vendedor' => $request->cod_vendedor,
            'cod_veiculo' => $request->cod_veiculo,
            'data' => $request->data,
        ]);
        return back()->with('success', 'Utilização de veículo registrada com sucesso!');
    }

    public function storeProduto(Request $request)
    {
        $data = $request->validate([
            'cod_produto' => 'required|integer|unique:produtos,cod_produto',
            'descricao' => 'required|string|max:255',
            'estoque' => 'required|integer',
            'status_ativo' => 'required|boolean',
        ]);
        Produto::create($data);
        return back()->with('success', 'Produto cadastrado com sucesso!');
    }

    // --- EXCLUSÕES (DESTROY) ---

    public function destroyRegiao($id)
    {
        Regiao::where('cod_regiao', $id)->delete();
        return back()->with('success', 'Região removida com sucesso!');
    }

    public function destroyPonto($id)
    {
        PontoEstrategico::where('cod_ponto', $id)->delete();
        return back()->with('success', 'Ponto Estratégico removido com sucesso!');
    }

    public function destroyVendedor($id)
    {
        Vendedor::where('cod_vendedor', $id)->delete();
        return back()->with('success', 'Vendedor removido com sucesso!');
    }

    public function destroyVeiculo($id)
    {
        Veiculo::where('cod_veiculo', $id)->delete();
        return back()->with('success', 'Veículo removido com sucesso!');
    }

    public function destroyVendedorVeiculo($cod_vendedor, $cod_veiculo, $data)
    {
        DB::table('vendedor_veiculo')
            ->where('cod_vendedor', $cod_vendedor)
            ->where('cod_veiculo', $cod_veiculo)
            ->where('data', $data)
            ->delete();
        return back()->with('success', 'Registro de utilização removido!');
    }

    public function destroyProduto($id)
    {
        Produto::where('cod_produto', $id)->delete();
        return back()->with('success', 'Produto removido com sucesso!');
    }
}