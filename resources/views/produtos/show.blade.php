@extends('app')

@section('title', 'Detalhes do Produto')

@section('content')
    <div class="container mt-4">
        <h2>Detalhes do Produto</h2>
        <div class="card p-4">
            <p><strong>ID:</strong> {{ $produto->id }}</p>
            <p><strong>Nome:</strong> {{ $produto->nome }}</p>
            <p><strong>Descrição:</strong> {{ $produto->descricao ?: '-' }}</p>
            <p><strong>Preço:</strong> R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
            <p><strong>Quantidade:</strong> {{ number_format($produto->quantidade, 0, ',', '.') }}</p>
            <a href="{{ route('produtos.index') }}" class="btn btn-secondary btn-sm mt-3">Voltar</a>
        </div>
    </div>
@endsection
