// Lógica para el filtrado dinámico y carga de datos
document.addEventListener('DOMContentLoaded', function () {
    // Lógica para el filtrado dinámico
    const filtroCliente = document.getElementById('filtroCliente');
    const filtroNumeroFormato = document.getElementById('filtroNumeroFormato');
    const filtroAnio = document.getElementById('filtroAnio');

    const listaRecibos = document.getElementById('listaRecibos');

    [filtroCliente, filtroNumeroFormato, filtroAnio].forEach(input => {
        input.addEventListener('input', () => {
            const cliente = filtroCliente.value.trim().toLowerCase();
            const numeroFormato = filtroNumeroFormato.value.trim().toLowerCase();
            const anio = filtroAnio.value.trim().toLowerCase();

            Array.from(listaRecibos.children).forEach(recibo => {
                const clienteRecibo = recibo.querySelector('.cliente').textContent
                    .trim().toLowerCase();
                const numeroFormatoRecibo = recibo.querySelector('.numero-formato')
                    .textContent.trim().toLowerCase();
                const fechaRecibo = recibo.querySelector('.fecha').textContent
                    .trim();

                const mostrarRecibo =
                    (!cliente || clienteRecibo.includes(cliente)) &&
                    (!numeroFormato || numeroFormatoRecibo.includes(
                        numeroFormato)) &&
                    (!anio || fechaRecibo.includes(anio));

                recibo.style.display = mostrarRecibo ? 'block' : 'none';
            });
        });
    });

    

});
