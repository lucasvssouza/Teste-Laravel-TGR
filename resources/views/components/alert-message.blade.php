<script>
    function alertaSucesso(titulo = 'Sucesso', mensagem = '', redirect = false) {
        Swal.fire({
            icon: 'success',
            title: titulo,
            text: mensagem,
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        }).then(() => {
            if (redirect !== false) {
                window.location.href = redirect;
            }
        });
    }

    function alertaErro(titulo = 'Erro', mensagem = '') {
        Swal.fire({
            icon: 'error',
            title: titulo,
            timer: 3000,
            text: mensagem,
            timerProgressBar: true,
            showConfirmButton: false
        });
    }

    function alertaConfirmacao(titulo, texto, confirmCallback) {
        Swal.fire({
            title: titulo,
            text: texto,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, deletar!',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                confirmCallback();
            }
        });
    }
</script>
