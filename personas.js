// JavaScript Document
 
   
$(document).ready(function (e) {
	
// Configuración de la Tabla	
  $('#tabla').dataTable( {
	    "Processing": true, 
		"Sorting": [],    
		"Dom": '<Tlf>t<"F"ip>', /* Acomoda los elementos en el header y footer de la tabla */
        "TableTools": { /*  Para importar a PDF xsl imprimir, etc */
			"RowSelect": "single",
			"SwfPath" : "swf/copy_csv_xls_pdf.swf",
            "Buttons": [
                {
                    "Extends": "copy",
                    "ButtonText": "Copiar"
                },
                {
                    "Extends":    "collection",
                    "ButtonText": "Guardar como",
                    "Buttons":    [ 
                {
                    "Extends": "csv",
                    "ButtonText": "Archivo CSV"
                },
				{
                    "Extends": "xls",
                    "ButtonText": "Archivo Excel"
                },
				{
                    "Extends": "pdf",
                    "ButtonText": "Archivo PDF"
                } ]
                },
				{
                    "Extends": "print",
                    "ButtonText": "Imprimir"
                },
            ]
        },
		"PaginationType": "full_numbers",
		"AutoWidth": false,
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
			   title: 'Persona registrada con exito!',
			   type: 'success',
			   showCancelButton: true,
			   confirmButtonText: 'Registar otra Persona',
			   cancelButtonText: 'Salir',
			   confirmButtonClass: 'btn btn-success',
			   cancelButtonClass: 'btn btn-danger',
			   closeOnConfirm: true,
			   closeOnCancel: false 
			},
			 function(isConfirm) { // si confirmo limpio los campos 
			   if (isConfirm) {
			   	
			   $('#estado').html('');
			   $('#formu').hide('slow/2000/fast')   
			   		   
			   $('#bqced,#exist,#txtapellido,#txtnombre,#txfech,#txtel,#txsex,#txfech').val('');
			   $('#txtapellido,#txtnombre,#txfech,#txtel,#sCentro,#sSect,#txsex,#txfech,#sUbch,#sUbch_sel,#lbsCc,#lbsClp, #sClp_sel,#lbmpsuv,#lbmpob').addClass("alert-danger");				
			   $("#centro").hide()
			   $("#id_centro_v").empty().prop('disabled',false)
				
			   } else { // si no confirmo cierro y actualizo la tabla
				window.location.reload(false);// actualizo el cache
				
			   }
			 });// fin de la ventana modal de control          
		} //fin del envio de la data
	}) // fin del ajax
	return false;
});// fin de la funcion del envio

// lanzar ventana modal Editar	
  $('#modEditar').on('show.bs.modal', function(e) {   
     var id = $(e.relatedTarget).data().idpersona;
      $(e.currentTarget).find('#id_op').val(id);
     var ope = $(e.relatedTarget).data().ope;
      $(e.currentTarget).find('#sop').val(ope);	  
     var ced = $(e.relatedTarget).data().ced;
      $(e.currentTarget).find('#txced').val(ced);	  
     var nop = $(e.relatedTarget).data().nomb;
      $(e.currentTarget).find('#txnom').val(nop);
     var ape = $(e.relatedTarget).data().ape;
      $(e.currentTarget).find('#txape').val(ape);
     var tel = $(e.relatedTarget).data().tel;
      $(e.currentTarget).find('#txtel').val(tel);
     var cev = $(e.relatedTarget).data().cev;
      $(e.currentTarget).find('#sCentro').val(cev);		  	  
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
     var id = $(e.relatedTarget).data().idpersona;
      $(e.currentTarget).find('#id_op').val(id);
     var ced = $(e.relatedTarget).data().ced;
      $(e.currentTarget).find('#txced').val(ced);	  
     var nop = $(e.relatedTarget).data().nomb;
      $(e.currentTarget).find('#txnom').val(nop);
     var ape = $(e.relatedTarget).data().ape;
      $(e.currentTarget).find('#txape').val(ape);
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

// lanzar ventana modal Eliminar	
  $('#modBuscar').on('show.bs.modal', function(e) {   
     var ced = $(e.relatedTarget).data().ced;
      $(e.currentTarget).find('#txced').val(ced);	  
     var nac = $(e.relatedTarget).data().nac;
      $(e.currentTarget).find('#txnac').val(nac);

  }); 


		
} );// fin document.ready
