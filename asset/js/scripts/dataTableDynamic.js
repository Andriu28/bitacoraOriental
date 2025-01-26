//data table dinamico para todas las tablas 
// Distrubuye el acho de las columnas a travez de un mapa de tamañas segun el data table

$(document).ready(function(){
    let table = $('table').DataTable();
    const formName = document.querySelector('table').id;
    let columnDefs = [];

    const columnWidthsMap = {//mapa de tamaños
        'faqTable': ['40%', '40%', '20%'],//3 campos
        'packgesTable': ['50%', '30%','20%'],//7 campos solo 3 se usan
        'pubEspecialTable': ['30%', '50%', '20%'],//4 campos solo 3 se usan 
        'routeTable': ['25%', '25%', '25%', '25%', ],//5 campos
        'tripTable': ['17%', '10%', '20%','16%', '20%', '17%'],//6 campos
        'userTable': ['10%', '15%', '15%','10%', '30%', '20%'],//6 campos
        'requestsReservation': ['10%', '10%','10%','10%','15%', '15%','10%', '20%'],//6 campos
        'webLogTable' :['25%','45%','15%','15%'],
        'commentTable': ['25%','35%','20%','20%'],
        'requestsReservationTourist':['30%','20%','10%','5%','20%','15%'],
        'historyTable':  ['20%', '15%', '30%', '10%', '15%','10%']
        // Agrega más configuraciones aquí si es necesario
    };

    
    //asignacion de los espacios del data table
    for (let i = 0; i < columnWidthsMap[formName].length; i++) {
    
        columnDefs.push({ "width": columnWidthsMap[formName][i], "targets": i });
    }

    table.destroy(); // Destruye la instancia existente de DataTable
    $('table').DataTable({
        "columnDefs": columnDefs,//columnas
        "language": {//para cambiar el idioma a español
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
        },
        "oAria": {
             "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
             "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
});




