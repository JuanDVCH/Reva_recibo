// public/js/form-validation.js

//Pulpo
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('pulpoForm');

    form.addEventListener('submit', function (event) {
        var orderNumSelect = document.getElementById('inputOrderNum');
        if (orderNumSelect.value === '' || orderNumSelect.value === null) {
            alert('Por favor, selecciona un número de recibo.');
            event.preventDefault(); // Evita que el formulario se envíe
        }
    });
});


//recibo

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('reciboForm');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        // Realizar la validación de todos los campos aquí
        const deliveryDate = document.getElementById('inputdelivery_date').value.trim();
        const deliveryDateError = document.getElementById('deliveryDateError');

        if (deliveryDate === '') {
            deliveryDateError.textContent = 'Por favor, selecciona una fecha.';
            deliveryDateError.style.display = 'block';
        } else {
            // Si el campo es válido, ocultar el mensaje de error
            deliveryDateError.textContent = '';
            deliveryDateError.style.display = 'none';

            // Puedes enviar el formulario aquí
            form.submit();
        }
    });
});