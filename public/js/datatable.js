$(document).ready(function () {
    // Inicialización de DataTable para la tabla #etiquetaTable
    $('#etiquetaTable').DataTable({
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar...",
            info: "Mostrando _START_ al _END_ de _TOTAL_ registros",
            lengthMenu: "Mostrar _MENU_ registros por página",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
        },
        initComplete: function () {
            // Configuración de filtros para cada columna
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement("input");
                $(input).appendTo($(column.header()))
                    .on('keyup change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
            });
        },
        "paging": true,
        "ordering": true,
        "info": true,
        "border": false,
    });

    // Inicialización de DataTable para la tabla #productsTable
    var table = $('#productsTable').DataTable({
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        pageLength: 5,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar...",
            info: "Mostrando _START_ al _END_ de _TOTAL_ registros",
            lengthMenu: "Mostrar _MENU_ registros por página",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
        },
        initComplete: function () {
            // Configuración de filtros para cada columna
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement("input");
                $(input).appendTo($(column.header()))
                    .on('keyup change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
            });
        },
        "paging": true,
        "ordering": true,
        "info": true,
        "border": false,
    });

    // Elimina los bordes de las columnas en #productsTable
    $('#productsTable').find('thead th').removeClass('sorting sorting_asc sorting_desc');
});