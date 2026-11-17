<x-layouts.app title="Gerenciamento - Indústria Beleza Ltda">
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 space-y-6">

            <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
                <div>
                    <h2 class="font-bold text-lg text-slate-800">Gerenciamento de Cadastros (DER / MER)</h2>
                    <p class="text-xs text-slate-500">Adicione ou remova registros das tabelas do banco de dados.</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('dashboard') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2 rounded-md text-sm shadow transition flex items-center gap-2">
                        <span>Salvar e Voltar ao Painel</span>
                    </a>
                    <a href="{{ route('relatorios') }}" class="text-sm bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-md font-medium">Relatórios (A-I)</a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 text-emerald-700 text-sm rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-rose-50 border-l-4 border-rose-500 p-4 text-rose-700 text-sm rounded shadow-sm">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- 1. Regiões -->
                <div class="bg-white p-5 rounded-lg shadow-sm space-y-4">
                    <h3 class="font-bold text-indigo-600 text-sm">Regiões</h3>
                    <form action="{{ route('gerenciamento.regiao.store') }}" method="POST" class="grid grid-cols-3 gap-2">
                        @csrf
                        <input type="number" name="cod_regiao" placeholder="Cód" class="border-slate-300 rounded text-sm p-1.5" required>
                        <input type="text" name="nome" placeholder="Nome" class="border-slate-300 rounded text-sm p-1.5" required>
                        <button type="submit" class="bg-indigo-600 text-white rounded text-sm font-medium">Adicionar</button>
                    </form>
                    <ul class="divide-y divide-slate-100 text-sm max-h-40 overflow-y-auto">
                        @foreach($regioes as $r)
                            <li class="py-1.5 flex justify-between items-center">
                                <span>{{ $r->cod_regiao }} - {{ $r->nome }}</span>
                                <form action="{{ route('gerenciamento.regiao.destroy', $r->cod_regiao) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-rose-600 hover:underline text-xs font-medium">Remover</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- 2. Pontos Estratégicos -->
                <div class="bg-white p-5 rounded-lg shadow-sm space-y-4">
                    <h3 class="font-bold text-indigo-600 text-sm">Pontos Estratégicos</h3>
                    <form action="{{ route('gerenciamento.ponto.store') }}" method="POST" class="grid grid-cols-4 gap-2">
                        @csrf
                        <input type="number" name="cod_ponto" placeholder="Cód" class="border-slate-300 rounded text-sm p-1.5" required>
                        <select name="cod_regiao" class="border-slate-300 rounded text-sm p-1.5" required>
                            <option value="">Região</option>
                            @foreach($regioes as $r)<option value="{{ $r->cod_regiao }}">{{ $r->nome }}</option>@endforeach
                        </select>
                        <input type="text" name="descricao" placeholder="Descrição" class="border-slate-300 rounded text-sm p-1.5" required>
                        <button type="submit" class="bg-indigo-600 text-white rounded text-sm font-medium">Add</button>
                    </form>
                    <ul class="divide-y divide-slate-100 text-sm max-h-40 overflow-y-auto">
                        @foreach($pontos as $p)
                            <li class="py-1.5 flex justify-between items-center">
                                <span>{{ $p->descricao }} (Região: {{ $p->regiao->nome ?? 'N/A' }})</span>
                                <form action="{{ route('gerenciamento.ponto.destroy', $p->cod_ponto) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-rose-600 hover:underline text-xs font-medium">Remover</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- 3. Vendedores -->
                <div class="bg-white p-5 rounded-lg shadow-sm space-y-4">
                    <h3 class="font-bold text-indigo-600 text-sm">Vendedores</h3>
                    <form action="{{ route('gerenciamento.vendedor.store') }}" method="POST" class="grid grid-cols-4 gap-2">
                        @csrf
                        <input type="number" name="cod_vendedor" placeholder="Cód" class="border-slate-300 rounded text-sm p-1.5" required>
                        <select name="cod_regiao" class="border-slate-300 rounded text-sm p-1.5" required>
                            <option value="">Região</option>
                            @foreach($regioes as $r)<option value="{{ $r->cod_regiao }}">{{ $r->nome }}</option>@endforeach
                        </select>
                        <input type="text" name="nome" placeholder="Nome" class="border-slate-300 rounded text-sm p-1.5" required>
                        <button type="submit" class="bg-indigo-600 text-white rounded text-sm font-medium">Add</button>
                    </form>
                    <ul class="divide-y divide-slate-100 text-sm max-h-40 overflow-y-auto">
                        @foreach($vendedores as $v)
                            <li class="py-1.5 flex justify-between items-center">
                                <span>{{ $v->nome }} (Região: {{ $v->regiao->nome ?? 'N/A' }})</span>
                                <form action="{{ route('gerenciamento.vendedor.destroy', $v->cod_vendedor) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-rose-600 hover:underline text-xs font-medium">Remover</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- 4. Veículos -->
                <div class="bg-white p-5 rounded-lg shadow-sm space-y-4">
                    <h3 class="font-bold text-indigo-600 text-sm">Veículos</h3>
                    <form action="{{ route('gerenciamento.veiculo.store') }}" method="POST" class="grid grid-cols-4 gap-2">
                        @csrf
                        <input type="number" name="cod_veiculo" placeholder="Cód" class="border-slate-300 rounded text-sm p-1.5" required>
                        <input type="text" name="placa" placeholder="Placa" class="border-slate-300 rounded text-sm p-1.5" required>
                        <input type="text" name="descricao" placeholder="Modelo" class="border-slate-300 rounded text-sm p-1.5">
                        <button type="submit" class="bg-indigo-600 text-white rounded text-sm font-medium">Add</button>
                    </form>
                    <ul class="divide-y divide-slate-100 text-sm max-h-40 overflow-y-auto">
                        @foreach($veiculos as $veic)
                            <li class="py-1.5 flex justify-between items-center">
                                <span>{{ $veic->placa }} - {{ $veic->descricao }}</span>
                                <form action="{{ route('gerenciamento.veiculo.destroy', $veic->cod_veiculo) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-rose-600 hover:underline text-xs font-medium">Remover</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- 5. Vendedor x Veículo (Utilização) -->
                <div class="bg-white p-5 rounded-lg shadow-sm space-y-4">
                    <h3 class="font-bold text-indigo-600 text-sm">Vincular Veículo a Vendedor</h3>
                    <form action="{{ route('gerenciamento.vendedor_veiculo.store') }}" method="POST" class="grid grid-cols-4 gap-2">
                        @csrf
                        <select name="cod_vendedor" class="border-slate-300 rounded text-sm p-1.5" required>
                            <option value="">Vendedor</option>
                            @foreach($vendedores as $v)<option value="{{ $v->cod_vendedor }}">{{ $v->nome }}</option>@endforeach
                        </select>
                        <select name="cod_veiculo" class="border-slate-300 rounded text-sm p-1.5" required>
                            <option value="">Veículo</option>
                            @foreach($veiculos as $veic)<option value="{{ $veic->cod_veiculo }}">{{ $veic->placa }}</option>@endforeach
                        </select>
                        <input type="date" name="data" class="border-slate-300 rounded text-sm p-1.5" required>
                        <button type="submit" class="bg-indigo-600 text-white rounded text-sm font-medium">Vincular</button>
                    </form>
                    <ul class="divide-y divide-slate-100 text-sm max-h-40 overflow-y-auto">
                        @foreach($vendedorVeiculo as $vv)
                            <li class="py-1.5 flex justify-between items-center">
                                <span>{{ $vv->vendedor_nome }} -> {{ $vv->veiculo_placa }} ({{ $vv->data }})</span>
                                <form action="{{ route('gerenciamento.vendedor_veiculo.destroy', [$vv->cod_vendedor, $vv->cod_veiculo, $vv->data]) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-rose-600 hover:underline text-xs font-medium">Remover</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- 6. Produtos -->
                <div class="bg-white p-5 rounded-lg shadow-sm space-y-4">
                    <h3 class="font-bold text-indigo-600 text-sm">Produtos</h3>
                    <form action="{{ route('gerenciamento.produto.store') }}" method="POST" class="grid grid-cols-5 gap-2">
                        @csrf
                        <input type="number" name="cod_produto" placeholder="Cód" class="border-slate-300 rounded text-sm p-1.5" required>
                        <input type="text" name="descricao" placeholder="Descrição" class="border-slate-300 rounded text-sm p-1.5" required>
                        <input type="number" name="estoque" placeholder="Qtd" class="border-slate-300 rounded text-sm p-1.5" required>
                        <select name="status_ativo" class="border-slate-300 rounded text-sm p-1.5" required>
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
                        </select>
                        <button type="submit" class="bg-indigo-600 text-white rounded text-sm font-medium">Add</button>
                    </form>
                    <ul class="divide-y divide-slate-100 text-sm max-h-40 overflow-y-auto">
                        @foreach($produtos as $prod)
                            <li class="py-1.5 flex justify-between items-center">
                                <span>{{ $prod->descricao }} (Estoque: {{ $prod->estoque }})</span>
                                <form action="{{ route('gerenciamento.produto.destroy', $prod->cod_produto) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-rose-600 hover:underline text-xs font-medium">Remover</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>

            <!-- Botão Inferior de Conclusão -->
            <div class="bg-white p-4 rounded-lg shadow-sm flex justify-end">
                <a href="{{ route('dashboard') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2.5 rounded-md text-sm shadow transition">
                    Salvar Alterações e Voltar ao Painel
                </a>
            </div>

        </div>
    </div>
</x-layouts.app>