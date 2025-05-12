@extends('app')

@section('title', 'Cadastrar Produto')

@section('content')
    <div class="container mt-4">
        <h2>Cadastrar Novo Produto</h2>

        @include('produtos._form', [
            'route' => route('produtos.store'),
            'method' => 'POST',
            'botao' => 'Salvar'
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
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        form.find('button[type="submit"]').prop('disabled', true).text('Salvando...');
                    },
                    success: function (res) {
                        alertaSucesso('Sucesso!', res.message || 'Produto cadastrado com sucesso.', "{{ route('produtos.index') }}");
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                const input = $(`#${field}`);
                                input.after(`<small class="text-danger">${errors[field][0]}</small>`);
                            }
                        } else {
                            alertaErro('Erro', 'Erro inesperado ao cadastrar o produto.');
                        }
                    },
                    complete: function () {
                        form.find('button[type="submit"]').prop('disabled', false).text('Salvar');
                    }
                });
            });
        });
    </script>
@endsection
