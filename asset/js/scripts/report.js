// Obtén el botón por su id
var button = document.getElementById('getDataButton');

// Verifica si el botón existe antes de agregar el evento
if (button) {
    // Agrega un evento al botón que se ejecutará cuando se haga clic
    button.addEventListener('click', function() {
        // Obtén el elemento de la tabla por su id
        var table = document.querySelector('table');
        
        // Verifica si la tabla existe antes de continuar
        if (table) {
            // Inicializa un array para almacenar los datos de la tabla
            var tableData = [];

            // Obtén los encabezados de la tabla
            var headers = table.getElementsByTagName('thead')[0].getElementsByTagName('th');
            var headerData = [];
            for (var i = 0; i < headers.length-1; i++) {
                headerData.push('<th>' + headers[i].innerText + '</th>');
            }

            // Añade los encabezados al array de datos de la tabla
            tableData.push(headerData);

            // Recorre cada fila en el tbody
            var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            for (var i = 0; i < rows.length; i++) {
                var row = rows[i];
                var rowData = [];
                rowData.push('<tr>');
                // Recorre cada celda en la fila
                var cells = row.getElementsByTagName('td');
                for (var j = 0; j < cells.length-1; j++) {
                    rowData.push('<td>' + cells[j].innerText + '</td>');
                }
                
                rowData.push('</tr>');
                // Añade los datos de la fila al array de datos de la tabla
                tableData.push(rowData);
            }

            // Muestra los datos de la tabla en la consola
            console.log(tableData);

            // Envía los datos al servidor local
            sendDataToServer(tableData);
        }
    });
}

// Función para enviar los datos al servidor
function sendDataToServer(data) {
    fetch('http://localhost/bitacora_oriental/controller/controlador.php', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        console.log('Reporte generado:', result);
    })
    .catch(error => {
        console.error('Error al enviar datos:', error);
    });
}
