<x-layouts.app title="Relatórios (A a I) - Indústria Beleza Ltda">
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 space-y-6">

            <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
                <h2 class="font-bold text-lg text-slate-800">
                    Consultas e Relatórios Exigidos (A a I)
                </h2>
                <a href="{{ route('dashboard') }}" class="text-sm text-indigo-600 hover:underline font-medium">
                    &larr; Voltar ao Painel
                </a>
            </div>

            <!-- A & B: Regiões e Pontos Estratégicos -->
            <div class="bg-white p-6 shadow-sm rounded-lg">
                <h3 class="text-base font-bold text-indigo-600 mb-3">A & B - Regiões e Pontos Estratégicos</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-slate-700 text-sm">B - Nomes das Regiões Cadastradas</h4>
                        <ul class="list-disc pl-5 mt-2 text-sm text-slate-600 space-y-1">
                            @forelse($regioesNomes as $regiao)
                                <li><strong>{{ $regiao->nome }}</strong> (Cód: {{ $regiao->cod_regiao }} | CEP: {{ $regiao->cep }})</li>
                            @empty
                                <li class="italic text-slate-400">Nenhuma região cadastrada.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-700 text-sm">A - Pontos Estratégicos por Região</h4>
                        @forelse($regioesComPontos as $regiao)
                            <div class="mt-2 text-sm">
                                <span class="font-medium text-slate-800">{{ $regiao->nome }}:</span>
                                <ul class="list-disc pl-5 text-slate-600">
                                    @forelse($regiao->pontosEstrategicos as $ponto)
                                        <li>{{ $ponto->descricao }}</li>
                                    @empty
                                        <li class="italic text-slate-400">Nenhum ponto cadastrado</li>
                                    @endforelse
                                </ul>
                            </div>
                        @empty
                            <p class="italic text-slate-400 text-sm mt-2">Nenhum dado encontrado.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- C & D: Vendedores, Veículos e Regiões -->
            <div class="bg-white p-6 shadow-sm rounded-lg grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-base font-bold text-indigo-600 mb-3">C - Vendedores e Veículos Utilizados</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600 border border-slate-200">
                            <thead class="bg-slate-100 border-b border-slate-200">
                                <tr>
                                    <th class="p-2">Vendedor</th>
                                    <th class="p-2">Veículo (Placa)</th>
                                    <th class="p-2">Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vendedoresVeiculos as $item)
                                    <tr class="border-b border-slate-100">
                                        <td class="p-2">{{ $item->vendedor }}</td>
                                        <td class="p-2">{{ $item->veiculo }} ({{ $item->placa }})</td>
                                        <td class="p-2">{{ \Carbon\Carbon::parse($item->data)->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="p-2 italic text-slate-400">Nenhum registro encontrado.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <h3 class="text-base font-bold text-indigo-600 mb-3">D - Vendedores Responsáveis por Região</h3>
                    @forelse($vendedoresPorRegiao as $regiao)
                        <div class="mb-2 text-sm">
                            <strong class="text-slate-800">{{ $regiao->nome }}:</strong>
                            <span class="text-slate-600">
                                {{ $regiao->vendedores->pluck('nome')->join(', ') ?: 'Nenhum vendedor alocado' }}
                            </span>
                        </div>
                    @empty
                        <p class="italic text-slate-400 text-sm">Nenhuma região encontrada.</p>
                    @endforelse
                </div>
            </div>

            <!-- E: Produtos por Vendedor (Com Filtro) -->
            <div class="bg-white p-6 shadow-sm rounded-lg">
                <h3 class="text-base font-bold text-indigo-600 mb-3">E - Produtos Vendidos por um Determinado Vendedor</h3>
                <form method="GET" action="{{ route('relatorios') }}" class="flex flex-wrap gap-3 mb-4">
                    <input type="hidden" name="produto_id" value="{{ $produtoId }}">
                    <input type="hidden" name="veiculo_id" value="{{ $veiculoId }}">
                    <select name="vendedor_id" class="border-slate-300 rounded-md shadow-sm text-sm">
                        <option value="">Selecione um Vendedor...</option>
                        @foreach($todosVendedores as $v)
                            <option value="{{ $v->cod_vendedor }}" {{ $vendedorId == $v->cod_vendedor ? 'selected' : '' }}>{{ $v->nome }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">Filtrar</button>
                </form>
                @if($produtosVendedor !== null)
                    <ul class="list-disc pl-5 text-sm text-slate-600 space-y-1">
                        @forelse($produtosVendedor as $prod)
                            <li>Nota #{{ $prod->num_nota }} — <strong>{{ $prod->descricao }}</strong> (Qtd vendida: {{ $prod->quantidade }})</li>
                        @empty
                            <li class="italic text-slate-400">Nenhum produto vendido por este vendedor.</li>
                        @endforelse
                    </ul>
                @endif
            </div>

            <!-- F & G: Vendedores por Produto e Produtos não vendidos -->
            <div class="bg-white p-6 shadow-sm rounded-lg grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-base font-bold text-indigo-600 mb-3">F - Vendedores que Venderam um Produto</h3>
                    <form method="GET" action="{{ route('relatorios') }}" class="flex flex-wrap gap-3 mb-4">
                        <input type="hidden" name="vendedor_id" value="{{ $vendedorId }}">
                        <input type="hidden" name="veiculo_id" value="{{ $veiculoId }}">
                        <select name="produto_id" class="border-slate-300 rounded-md shadow-sm text-sm">
                            <option value="">Selecione um Produto...</option>
                            @foreach($todosProdutos as $p)
                                <option value="{{ $p->cod_produto }}" {{ $produtoId == $p->cod_produto ? 'selected' : '' }}>{{ $p->descricao }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">Filtrar</button>
                    </form>
                    @if($vendedoresProduto !== null)
                        <ul class="list-disc pl-5 text-sm text-slate-600 space-y-1">
                            @forelse($vendedoresProduto as $vp)
                                <li><strong>{{ $vp->nome }}</strong> (Nota #{{ $vp->num_nota }})</li>
                            @empty
                                <li class="italic text-slate-400">Nenhum vendedor comercializou este produto.</li>
                            @endforelse
                        </ul>
                    @endif
                </div>
                <div>
                    <h3 class="text-base font-bold text-indigo-600 mb-3">G - Produtos que Ainda NÃO Foram Vendidos</h3>
                    <ul class="list-disc pl-5 text-sm text-slate-600 space-y-1">
                        @forelse($produtosNaoVendidos as $prod)
                            <li>{{ $prod->descricao }} (Estoque: {{ $prod->estoque }})</li>
                        @empty
                            <li class="text-emerald-600 font-medium">Todos os produtos cadastrados já possuem vendas!</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- H & I: Histórico de Veículo e Quantidade de Itens por Nota -->
            <div class="bg-white p-6 shadow-sm rounded-lg grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-base font-bold text-indigo-600 mb-3">H - Histórico de Utilização de Veículo</h3>
                    <form method="GET" action="{{ route('relatorios') }}" class="flex flex-wrap gap-3 mb-4">
                        <input type="hidden" name="vendedor_id" value="{{ $vendedorId }}">
                        <input type="hidden" name="produto_id" value="{{ $produtoId }}">
                        <select name="veiculo_id" class="border-slate-300 rounded-md shadow-sm text-sm">
                            <option value="">Selecione um Veículo...</option>
                            @foreach($todosVeiculos as $veic)
                                <option value="{{ $veic->cod_veiculo }}" {{ $veiculoId == $veic->cod_veiculo ? 'selected' : '' }}>{{ $veic->placa }} - {{ $veic->descricao }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">Filtrar</button>
                    </form>
                    @if($historicoVeiculo !== null)
                        <ul class="list-disc pl-5 text-sm text-slate-600 space-y-1">
                            @forelse($historicoVeiculo as $h)
                                <li>Data: <strong>{{ \Carbon\Carbon::parse($h->data)->format('d/m/Y') }}</strong> — Utilizado por: {{ $h->vendedor }}</li>
                            @empty
                                <li class="italic text-slate-400">Sem histórico de uso para este veículo.</li>
                            @endforelse
                        </ul>
                    @endif
                </div>
                <div>
                    <h3 class="text-base font-bold text-indigo-600 mb-3">I - Quantidade de Itens por Nota Fiscal</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600 border border-slate-200">
                            <thead class="bg-slate-100 border-b border-slate-200">
                                <tr>
                                    <th class="p-2">Nota Fiscal</th>
                                    <th class="p-2">Qtd. Itens</th>
                                    <th class="p-2">Preço Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($quantidadeItensNota as $nota)
                                    <tr class="border-b border-slate-100">
                                        <td class="p-2 font-medium">#{{ $nota->num_nota }}</td>
                                        <td class="p-2">{{ $nota->total_itens }}</td>
                                        <td class="p-2">R$ {{ number_format($nota->preco_total, 2, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="p-2 italic text-slate-400">Nenhuma nota fiscal emitida.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>