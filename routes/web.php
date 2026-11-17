<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GerenciamentoController;
use App\Http\Controllers\RelatorioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rotas de Autenticação (Convidados)
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);

    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
});

// Rotas Protegidas (Utilizadores Autenticados)
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios');

    // Rotas de Gerenciamento (CRUD)
    Route::get('/gerenciamento', [GerenciamentoController::class, 'index'])->name('gerenciamento');

    Route::post('/gerenciamento/regiao', [GerenciamentoController::class, 'storeRegiao'])->name('gerenciamento.regiao.store');
    Route::delete('/gerenciamento/regiao/{id}', [GerenciamentoController::class, 'destroyRegiao'])->name('gerenciamento.regiao.destroy');

    Route::post('/gerenciamento/ponto', [GerenciamentoController::class, 'storePonto'])->name('gerenciamento.ponto.store');
    Route::delete('/gerenciamento/ponto/{id}', [GerenciamentoController::class, 'destroyPonto'])->name('gerenciamento.ponto.destroy');

    Route::post('/gerenciamento/vendedor', [GerenciamentoController::class, 'storeVendedor'])->name('gerenciamento.vendedor.store');
    Route::delete('/gerenciamento/vendedor/{id}', [GerenciamentoController::class, 'destroyVendedor'])->name('gerenciamento.vendedor.destroy');

    Route::post('/gerenciamento/veiculo', [GerenciamentoController::class, 'storeVeiculo'])->name('gerenciamento.veiculo.store');
    Route::delete('/gerenciamento/veiculo/{id}', [GerenciamentoController::class, 'destroyVeiculo'])->name('gerenciamento.veiculo.destroy');

    Route::post('/gerenciamento/vendedor-veiculo', [GerenciamentoController::class, 'storeVendedorVeiculo'])->name('gerenciamento.vendedor_veiculo.store');
    Route::delete('/gerenciamento/vendedor-veiculo/{vendedor}/{veiculo}/{data}', [GerenciamentoController::class, 'destroyVendedorVeiculo'])->name('gerenciamento.vendedor_veiculo.destroy');

    Route::post('/gerenciamento/produto', [GerenciamentoController::class, 'storeProduto'])->name('gerenciamento.produto.store');
    Route::delete('/gerenciamento/produto/{id}', [GerenciamentoController::class, 'destroyProduto'])->name('gerenciamento.produto.destroy');
});