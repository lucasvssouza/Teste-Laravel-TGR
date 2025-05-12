@extends('app')

@section('title', 'Lista de Produtos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Produtos</h2>
        <a href="{{ route('produtos.create') }}" class="btn btn-success">Novo Produto</a>
    </div>

    <div class="mb-3">
        <input type="text" id="input-busca" class="form-control" placeholder="Buscar por nome do produto">
    </div>

    <table class="table table-bordered table-hover rounded shadow-sm small p-2" id="tabela-produtos">
        <thead class="table-dark text-center align-middle">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr id="loading-row">
                <td colspan="6" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status" aria-hidden="true"></div>
                    <div class="mt-2">Carregando produtos...</div>
                </td>
            </tr>
        </tbody>
    </table>

    <div id="paginacao" class="d-flex justify-content-center mt-3"></div>
@endsection

@section('scripts')
<script>
    $(function () {
        const tbody = $('#tabela-produtos tbody');
        const paginacao = $('#paginacao');
        const inputBusca = $('#input-busca');
        const produtosPorPagina = 10;
        let produtosFiltrados = [], paginaAtual = 1;

        function renderLinhaProduto(produto) {
            return `
                <tr class="text-center align-middle">
                    <td>${produto.id}</td>
                    <td>${produto.nome}</td>
                    <td>${produto.descricao ?? '-'}</td>
                    <td>${Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(produto.preco)}</td>
                    <td>${Intl.NumberFormat('pt-BR').format(produto.quantidade)}</td>
                    <td>
                        <a href="/produtos/${produto.id}/edit" class="btn btn-sm btn-primary" title="Editar" aria-label="Editar">
                            <i class="bi bi-pencil-fill text-white"></i>
                        </a>
                        <button data-id="${produto.id}" class="btn btn-sm btn-danger btn-deletar" title="Excluir" aria-label="Excluir">
                            <i class="bi bi-trash-fill text-white"></i>
                        </button>
                        <a href="/produtos/${produto.id}" class="btn btn-sm btn-info" title="Ver detalhes" aria-label="Detalhes">
                            <i class="bi bi-eye-fill text-white"></i>
                        </a>
                    </td>
                </tr>`;
        }

        function buscarProdutos(termo = '') {
            tbody.html(`
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <div class="spinner-border text-primary"></div>
                        <div class="mt-2">Buscando produtos...</div>
                    </td>
                </tr>
            `);

            const rota = "{{ route('produtos.list', ['termo' => '__TERMO__']) }}".replace('__TERMO__', encodeURIComponent(termo));

            $.get(rota, function (response) {
                if (response.status === 'success') {
                    produtosFiltrados = response.data;
                    renderTabela(1);
                } else {
                    alertaErro('Erro', 'Erro ao buscar produtos.');
                }
            }).fail(() => alertaErro('Erro', 'Erro ao conectar com o servidor.'));
        }

        function renderTabela(pagina) {
            tbody.empty();
            paginaAtual = pagina;

            if (!produtosFiltrados.length) {
                return tbody.html(`<tr><td colspan="6" class="text-center">Nenhum produto encontrado.</td></tr>`);
            }

            const inicio = (pagina - 1) * produtosPorPagina;
            const fim = inicio + produtosPorPagina;
            const paginaAtualProdutos = produtosFiltrados.slice(inicio, fim);

            paginaAtualProdutos.forEach(produto => {
                tbody.append(renderLinhaProduto(produto));
            });

            renderPaginacao(produtosFiltrados.length);
        }

        function renderPaginacao(total) {
            paginacao.empty();
            const totalPaginas = Math.ceil(total / produtosPorPagina);
            if (totalPaginas <= 1) return;

            const maxVisiveis = 3;
            let inicio = Math.max(1, paginaAtual - 1);
            let fim = Math.min(totalPaginas, inicio + maxVisiveis - 1);

            if (fim - inicio + 1 < maxVisiveis && inicio > 1) {
                inicio = Math.max(1, fim - maxVisiveis + 1);
            }

            if (paginaAtual > 1) {
                paginacao.append(`<button class="btn btn-sm btn-outline-primary mx-1" data-pagina="1">&laquo;</button>`);
            }

            if (inicio > 1) paginacao.append(`<span class="mx-1">...</span>`);

            for (let i = inicio; i <= fim; i++) {
                paginacao.append(`
                    <button class="btn btn-sm mx-1 ${i === paginaAtual ? 'btn-primary' : 'btn-outline-primary'}" data-pagina="${i}">${i}</button>
                `);
            }

            if (fim < totalPaginas) paginacao.append(`<span class="mx-1">...</span>`);

            if (paginaAtual < totalPaginas) {
                paginacao.append(`<button class="btn btn-sm btn-outline-primary mx-1" data-pagina="${totalPaginas}">&raquo;</button>`);
            }
        }

        inputBusca.on('input', function () {
            buscarProdutos($(this).val());
        });

        $(document).on('click', '#paginacao button', function () {
            renderTabela(parseInt($(this).data('pagina')));
        });

        $(document).on('click', '.btn-deletar', function () {
            const id = $(this).data('id');
            alertaConfirmacao('Tem certeza?', 'Essa ação não pode ser desfeita!', () => {
                $.ajax({
                    url: `/produtos/${id}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        alertaSucesso('Excluído!', res.message || 'Produto excluído com sucesso.');
                        buscarProdutos(inputBusca.val());
                    },
                    error: function (xhr) {
                        const mensagem = xhr.status === 404 ? 'Produto não encontrado.' :
                            (xhr.responseJSON?.message || 'Erro ao excluir o produto.');
                        alertaErro('Erro', mensagem);
                    }
                });
            });
        });

        // Busca inicial
        buscarProdutos();
    });
</script>
@endsection
