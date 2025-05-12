<form action="{{ $route }}" method="POST">
    @csrf

    @if (!empty($method) && strtoupper($method) !== 'POST')
        @method($method)
    @endif

    <div class="mb-3">
        <label for="nome" class="form-label required">Nome *</label>
        <input type="text" class="form-control" id="nome" name="nome" required
            value="{{ old('nome', $produto->nome ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea class="form-control" id="descricao" name="descricao">{{ old('descricao', $produto->descricao ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="preco" class="form-label required">Preço *</label>
        <input type="text" class="form-control" id="preco" name="preco" required
            value="{{ old('preco', isset($produto->preco) ? number_format($produto->preco, 2, ',', '.') : '') }}">
    </div>

    <div class="mb-3">
        <label for="quantidade" class="form-label required">Quantidade *</label>
        <input type="text" class="form-control" id="quantidade" name="quantidade" required
            value="{{ old('quantidade', isset($produto->quantidade) ? number_format($produto->quantidade, 0, '', '.') : '') }}">
    </div>

    <button type="submit" class="btn btn-primary">
        {{ $botao  }}
    </button>

    <a href="{{ route('produtos.index') }}" class="btn btn-secondary ms-3">Cancelar</a>
</form>
