// Lógica para mostrar la alerta al marcar un recibo como finalizado
const marcarFinalizadoForms = document.querySelectorAll('.marcar-finalizado-btn');
marcarFinalizadoForms.forEach(form => {
    form.addEventListener('click', (e) => {
        e.preventDefault();
        const alertaFinalizado = document.getElementById('finalizadoAlert');
        alertaFinalizado.classList.remove('hidden');
        setTimeout(() => {
            alertaFinalizado.classList.add('hidden');
        }, 3000);
        form.parentElement.submit();
    });
});