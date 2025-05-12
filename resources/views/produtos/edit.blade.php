@extends('app')

@section('title', 'Editar Produto')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Editar Produto: {{ $produto->nome }}</h2>

        @include('produtos._form', [
            'route' => route('produtos.update', $produto->id),
            'method' => 'PUT',
            'produto' => $produto,
            'botao' => 'Atualizar',
        ])
    </div>
@endsection

@section('scripts')
    <x-mask />

    <script>
        $(function () {
            const form = $('form');

            mascararPreco('#preco');
            mascararInteiro('#quantidade');

            form.on('submit', function (e) {
                e.preventDefault();
                $('.text-danger').remove();

                const data = form.serialize();

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    beforeSend: () => {
                        form.find('button[type="submit"]').prop('disabled', true).text('Atualizando...');
                    },
                    success: (res) => {
                        alertaSucesso('Sucesso!', res.message || 'Produto atualizado com sucesso.', "{{ route('produtos.index') }}");
                    },
                    error: (xhr) => {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                const input = $(`#${field}`);
                                if (input.length) {
                                    input.after(`<small class="text-danger">${errors[field][0]}</small>`);
                                }
                            }
                        } else {
                            alertaErro('Erro', 'Erro inesperado ao atualizar o produto.');
                        }
                    },
                    complete: () => {
                        form.find('button[type="submit"]').prop('disabled', false).text('Atualizar');
                    }
                });
            });
        });
    </script>
@endsection
