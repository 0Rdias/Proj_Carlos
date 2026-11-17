<x-layouts.app title="Painel - Indústria Beleza Ltda">
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 space-y-6">
            
            <!-- Boas-vindas e Acesso Rápido -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Olá, {{ $user->name }}!</h3>
                    <p class="text-sm text-slate-600 mt-1">Sistema de Gestão de Vendas, Frota e Regiões — Indústria Beleza Ltda.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('gerenciamento') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-md text-sm shadow transition">
                        Gerenciar Cadastros (DER/MER)
                    </a>
                    <a href="{{ route('relatorios') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-md text-sm shadow transition">
                        Consultas e Relatórios (A a I)
                    </a>
                </div>
            </div>

            <!-- Cartões de Estatísticas baseados no DER/MER -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Clientes -->
                <div class="bg-white p-5 shadow-sm rounded-lg border-l-4 border-indigo-500">
                    <div class="text-xs font-semibold uppercase text-slate-500">Total de Clientes</div>
                    <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totais['clientes'] }}</div>
                </div>

                <!-- Produtos -->
                <div class="bg-white p-5 shadow-sm rounded-lg border-l-4 border-emerald-500">
                    <div class="text-xs font-semibold uppercase text-slate-500">Produtos Cadastrados</div>
                    <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totais['produtos'] }}</div>
                </div>

                <!-- Vendedores -->
                <div class="bg-white p-5 shadow-sm rounded-lg border-l-4 border-blue-500">
                    <div class="text-xs font-semibold uppercase text-slate-500">Vendedores Ativos</div>
                    <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totais['vendedores'] }}</div>
                </div>

                <!-- Notas Fiscais -->
                <div class="bg-white p-5 shadow-sm rounded-lg border-l-4 border-purple-500">
                    <div class="text-xs font-semibold uppercase text-slate-500">Notas Fiscais Emitidas</div>
                    <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totais['notas'] }}</div>
                </div>
            </div>

            <!-- Seção de Ações e Informações do Modelo -->
            <div class="bg-white p-6 shadow-sm rounded-lg">
                <h3 class="text-base font-bold text-slate-900 mb-4">Módulos do Sistema (DER / MER)</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-slate-600">
                    <div class="p-4 bg-slate-50 rounded border border-slate-200">
                        <strong class="text-slate-800 block mb-1">Regiões e Pontos</strong>
                        Gerenciamento das regiões de vendas e seus respectivos pontos estratégicos de entrega.
                    </div>
                    <div class="p-4 bg-slate-50 rounded border border-slate-200">
                        <strong class="text-slate-800 block mb-1">Vendedores e Frota</strong>
                        Controle de veículos próprios atribuídos aos vendedores por data de utilização.
                    </div>
                    <div class="p-4 bg-slate-50 rounded border border-slate-200">
                        <strong class="text-slate-800 block mb-1">Vendas e Notas Fiscais</strong>
                        Emissão de notas fiscais vinculando clientes, vendedores e itens de produtos ativos.
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>