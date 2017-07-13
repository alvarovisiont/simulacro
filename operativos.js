// JavaScript Document
$(document).ready(function (e) {
		
// Configuración de la Tabla	
  $('#tabla').dataTable( {
	    "bProcessing": true, 
		"aaSorting": [],    
		"sDom": '<Tlf>t<"F"ip>', /* Acomoda los elementos en el header y footer de la tabla */
        "oTableTools": { /*  Para importar a PDF xsl imprimir, etc */
			"sRowSelect": "single",
			"sSwfPath" : "swf/copy_csv_xls_pdf.swf",
            "aButtons": [
                {
                    "sExtends": "copy",
                    "sButtonText": "Copiar"
                },
                {
                    "sExtends":    "collection",
                    "sButtonText": "Guardar como",
                    "aButtons":    [ 
                {
                    "sExtends": "csv",
                    "sButtonText": "Archivo CSV"
                },
				{
                    "sExtends": "xls",
                    "sButtonText": "Archivo Excel"
                },
				{
                    "sExtends": "pdf",
                    "sButtonText": "Archivo PDF"
                } ]
                },
				{
                    "sExtends": "print",
                    "sButtonText": "Imprimir"
                },
            ]
        },
		"sPaginationType": "full_numbers",
		"bAutoWidth": false,
			responsive: true, /*  Para activar el diseño responsive */
			language: { /*  Para traducir las etiquetas del la bliblioteca */
				processing:     "Procesando...",
				search:         "Buscar:",
				lengthMenu:     "Mostrar _MENU_ registros",
				info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
				infoFiltered:   "(filtrado de un total de _MAX_ registros)",
				infoPostFix:    "",
				loadingRecords: "Cargando...",
				zeroRecords:    "No se encontraron resultados",
				emptyTable:     "Ningún dato disponible en esta tabla",
				paginate: {
					first:      "Primero",
					previous:   "Anterior",
					next:       "Siguiente",
					last:       "Último"
				},
				aria: {
					sortAscending:  ": Activar para ordenar la columna de manera ascendente",
					sortDescending: ": Activar para ordenar la columna de manera descendente"
				}
			},
	} );

// lanzar ventana modal Nuevo	
  $('#modNuevo').on('show.bs.modal', function(e) { 
  });

/// Rutina Nuevo Registro Ajax+Ventana modal de Alerta
$('#formNuevo').submit(function() { //funcion de envio del formulario
	$.ajax({ // uso ajax para enviar las variables
		type: 'POST',
		url: $(this).attr('action'), 
		data: $(this).serialize(),
		success: function(data) { //envio la data si tengo las variables
			swal({ // ventana modal de control
			   title: 'Operativos registrado!',
			   type: 'success',
			   showCancelButton: true,
			   confirmButtonText: 'Registar otro operativo',
			   cancelButtonText: 'Salir',
			   confirmButtonClass: 'btn btn-success',
			   cancelButtonClass: 'btn btn-danger',
			   closeOnConfirm: true,
			   closeOnCancel: false 
			},
			 function(isConfirm) { // si confirmo limpio los campos 
			   if (isConfirm) {
				$('#txtope').val('');
			   } else { // si no confirmo cierro y actualizo la tabla
				window.location.reload(false);// actualizo el cache
				$('#modNuevo').hide('slow');//ocualto el modal
			   }
			 });// fin de la ventana modal de control          
		} //fin del envio de la data
	}) // fin del ajax
	return false;
});// fin de la funcion del envio

// lanzar ventana modal Editar	
  $('#modEditar').on('show.bs.modal', function(e) {   
     var id = $(e.relatedTarget).data().idop;
      $(e.currentTarget).find('#id_op').val(id);
     var ope = $(e.relatedTarget).data().ope;
      $(e.currentTarget).find('#txtope').val(ope);
     var sta = $(e.relatedTarget).data().sta;
      $(e.currentTarget).find('#seltxsta').val(sta);
  });
  
/// Rutina Editar Registro Ajax+Ventana modal de Alerta
$('#formEditar').submit(function() { //funcion de envio del formulario
	$.ajax({ // uso ajax para enviar las variables
		type: 'POST',
		url: $(this).attr('action'), 
		data: $(this).serialize(),
		success: function(data) { //envio la data si tengo las variables
			swal({ // ventana modal de control
			   title: 'Registro Actualizado!',
			   type: 'success',
			   confirmButtonClass: 'btn btn-success',
			   closeOnConfirm: true,
			},
			 function(isConfirm) { // si confirmo limpio los campos 
				window.location.reload(false);// actualizo el cache
				$('#modEditar').hide('slow');//ocualto el modal
			 });// fin de la ventana modal de control          
		} //fin del envio de la data
	}) // fin del ajax
	return false;
});// fin de la funcion del envio  
  
// lanzar ventana modal Eliminar	
  $('#modEliminar').on('show.bs.modal', function(e) {   
     var id = $(e.relatedTarget).data().idop;
      $(e.currentTarget).find('#id_op').val(id);
     var ope = $(e.relatedTarget).data().ope;
      $(e.currentTarget).find('#txtope').val(ope);	
  }); 

/// Rutina Eliminar Registro Ajax+Ventana modal de Alerta
$('#formEliminar').submit(function() { //funcion de envio del formulario
	$.ajax({ // uso ajax para enviar las variables
		type: 'POST',
		url: $(this).attr('action'), 
		data: $(this).serialize(),
		success: function(data) { //envio la data si tengo las variables
			swal({ // ventana modal de control
			   title: 'Registro Eliminado!',
			   type: 'error',
			   confirmButtonClass: 'btn btn-success',
			   closeOnConfirm: true,
			},
			 function(isConfirm) { // si confirmo limpio los campos 
				window.location.reload(false);// actualizo el cache
				$('#modEliminar').hide('slow');//ocualto el modal
			 });// fin de la ventana modal de control          
		} //fin del envio de la data
	}) // fin del ajax
	return false;
});// fin de la funcion del envio
		
} );// fin document.ready
