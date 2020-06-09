lib={
    settings:{
        dtEs:{
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando del _START_ al _END_ | _TOTAL_ ",
            "sInfoEmpty":      "Mostrando del 0 al 0 | Total: 0",
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
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        }
    },
    onLoad:function(){
        $('.loader-container').fadeOut(1000);
        
        if($('.alert-container').length  > 0){
            setTimeout(function(){$('.alert-container').fadeOut()},5000);
        }

        $('table').DataTable({
            "language": lib.settings.dtEs,
            "scrollX": true,
            "order": [[0, "asc"]],
            "lengthMenu": [5, 10, 15],
            autoWidth: false,
        }).columns.adjust().draw();

        $('table').attr('style','100% !important');
    }
}


// ON READY
$(document).ready(function(){
    lib.onLoad();
});

// AJAX CONFIG
$.ajaxSetup({
	beforeSend: function () {
		$('.loader-container').css({ 'display': 'flex' });
	},
	success: function () {
		$('.loader-container').fadeOut();
	},
	error: function () {
		alert("Ocurrió un error inesperado, por favor contacte al soporte técnico para mayor información");
	}
});

// WINDOW RESIZE TRICKS
$(window).on('resize', function() {
    $('table').DataTable().columns.adjust().draw();
});