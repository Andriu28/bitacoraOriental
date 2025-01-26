$('#routeTableT').DataTable({
    "columnDefs": [{ "width": "25%", "targets": 0 }, 
        { "width": "25%", "targets": 1 }, 
        { "width": "25%", "targets": 2 }, 
        { "width": "25%", "targets": 3 }],
    "language": { "sProcessing": "Procesando...", 
        "sLengthMenu": "Mostrar _MENU_ registros",
         "sZeroRecords": "No se encontraron resultados", 
         "sEmptyTable": "Ningún dato disponible en esta tabla", 
         "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros", 
         "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered": "(filtrado de un total de _MAX_ registros)", "sInfoPostFix": "", 
          "sSearch": "Buscar:", "sUrl": "",
           "sInfoThousands": ",", 
           "sLoadingRecords": "Cargando...",
            "oPaginate": { "sFirst": "Primero", "sLast": "Último", 
                "sNext": "Siguiente", "sPrevious": "Anterior" }, 
                "oAria": { "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                     "sSortDescending": ": Activar para ordenar la columna de manera descendente" } }
});

$('#packgesTableT').DataTable({
    "columnDefs": [{ "width": "50%", "targets": 0 }, { "width": "25%", "targets": 1 }, { "width": "25%", "targets": 2 }],
    "language": { "sProcessing": "Procesando...", "sLengthMenu": "Mostrar _MENU_ registros", "sZeroRecords": "No se encontraron resultados", "sEmptyTable": "Ningún dato disponible en esta tabla", "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros", "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros", "sInfoFiltered": "(filtrado de un total de _MAX_ registros)", "sInfoPostFix": "", "sSearch": "Buscar:", "sUrl": "", "sInfoThousands": ",", "sLoadingRecords": "Cargando...", "oPaginate": { "sFirst": "Primero", "sLast": "Último", "sNext": "Siguiente", "sPrevious": "Anterior" }, "oAria": { "sSortAscending": ": Activar para ordenar la columna de manera ascendente", "sSortDescending": ": Activar para ordenar la columna de manera descendente" } }
});
$('#packagesTable').DataTable({
    "columnDefs": [
        { "width": "14%", "targets": 0 }, 
        { "width": "14%", "targets": 1 }, 
        { "width": "14%", "targets": 2 }, 
        { "width": "14%", "targets": 3 },
        { "width": "14%", "targets": 4 }, 
        { "width": "14%", "targets": 5 }, 
        { "width": "26%", "targets": 6 }
    ],
    "language": { "sProcessing": "Procesando...", 
        "sLengthMenu": "Mostrar _MENU_ registros",
         "sZeroRecords": "No se encontraron resultados", 
         "sEmptyTable": "Ningún dato disponible en esta tabla", 
         "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros", 
         "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered": "(filtrado de un total de _MAX_ registros)", "sInfoPostFix": "", 
          "sSearch": "Buscar:", "sUrl": "",
           "sInfoThousands": ",", 
           "sLoadingRecords": "Cargando...",
            "oPaginate": { "sFirst": "Primero", "sLast": "Último", 
                "sNext": "Siguiente", "sPrevious": "Anterior" }, 
                "oAria": { "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                     "sSortDescending": ": Activar para ordenar la columna de manera descendente" } }
});


