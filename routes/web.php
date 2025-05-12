<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

Route::get('/', function () {
    return view('produtos.index');
});

// Listagem de Produtos
Route::get('/produtos/list/{termo?}', [ProdutoController::class, 'list'])->name('produtos.list');

// CRUD completo
Route::resource('produtos', ProdutoController::class);
