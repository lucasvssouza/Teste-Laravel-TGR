<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    function mascararPreco(selector) {
        $(selector).mask('000.000.000,00', { reverse: true }).on('input blur', function () {
            let raw = $(this).val().replace(/\./g, '').replace(',', '.');
            let floatVal = parseFloat(raw);
            if (floatVal && floatVal > 0) {
                $(this).val(floatVal.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            } else {
                $(this).val('');
            }
        });

        $(selector).trigger('input');
    }

    function mascararInteiro(selector) {
        $(selector).mask('000.000.000', { reverse: true }).on('input blur', function () {
            let raw = $(this).val().replace(/\./g, '');
            let intVal = parseInt(raw, 10);
            if (intVal && intVal > 0) {
                $(this).val(intVal.toLocaleString('pt-BR'));
            } else {
                $(this).val('');
            }
        });

        $(selector).trigger('input');
    }
</script>
