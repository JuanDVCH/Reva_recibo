
// Función para exportar datos a CSV
function exportToCSV() {
    // Recopila todos los datos, incluso aquellos en páginas no visibles
    var allRows = $('#productsTable').DataTable().rows().data().toArray();

    var aggregatedData = {};

    allRows.forEach(function (row) {
        var orderNum = row[1]; // Ajusta el índice según tu estructura de columna
        var sku = row[4]; // Ajusta el índice según tu estructura de columna
        var netWeight = parseFloat(row[5]) || 0; // Ajusta el índice según tu estructura de columna

        if (!aggregatedData[orderNum + sku]) {
            aggregatedData[orderNum + sku] = {
                supplier_code: row[0], // Ajusta el índice según tu estructura de columna
                order_num: orderNum,
                notes: row[2], // Ajusta el índice según tu estructura de columna
                delivery_date: row[3], // Ajusta el índice según tu estructura de columna
                sku: sku,
                requested_quantity: netWeight,
                criterium: row[6] // Ajusta el índice según tu estructura de columna
            };
        } else {
            aggregatedData[orderNum + sku].requested_quantity += netWeight;
        }
    });

    var aggregatedArray = Object.values(aggregatedData);

    var csv = Papa.unparse(aggregatedArray, {
        columns: ["supplier_code", "order_num", "notes", "delivery_date", "sku", "requested_quantity",
            "criterium"
        ]
    });

    var blob = new Blob([csv], {
        type: 'text/csv;charset=utf-8;'
    });
    var link = document.createElement('a');
    var url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', 'productos.csv');
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}