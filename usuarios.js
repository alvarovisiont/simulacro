// JavaScript Document
$(document).ready(function (e) {
	
	
// Configuración de la Tabla /////
  $('#tabla').dataTable( {
        "paging":			true,
	    "Processing":		true, 
		"Sorting":			[],    
		"lengthMenu": 		[ [5, 10, 25, -1], [5, 10, 25, "Todos"] ],
		"displaylength":	5,
		"Dom":				'<Tlf>t<"F"ip>', /* Acomoda los elementos en el header y footer de la tabla */
		"AutoWidth":		false,
			responsive: true,
		"sPaginationType": 	"simple_numbers",
		"language":			{"url": "json/esp.json"}
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
			   title: 'Usuario registrado!',
			   type: 'success',
			   showCancelButton: true,
			   confirmButtonText: 'Registar otro Usuario',
			   cancelButtonText: 'Salir',
			   confirmButtonClass: 'btn btn-success',
			   cancelButtonClass: 'btn btn-danger',
			   closeOnConfirm: true,
			   closeOnCancel: false 
			},
			 function(isConfirm) { // si confirmo limpio los campos 
			   if (isConfirm) {
				$('#txtnom').val('');
				$('#txtcla').val('');								
				$('#txtcla2').val('');								
				$('#sniv').val('');				
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
     var id = $(e.relatedTarget).data().idus;
      $(e.currentTarget).find('#id_op').val(id);	  
     var llog = $(e.relatedTarget).data().logg;
      $(e.currentTarget).find('#txtnom').val(llog);	  
     var cla = $(e.relatedTarget).data().clav;
      $(e.currentTarget).find('#txtcla').val(cla);
      var cla = $(e.relatedTarget).data().clav;
      $(e.currentTarget).find('#txtcla2').val(cla);
     var nivl = $(e.relatedTarget).data().niv;
      $(e.currentTarget).find('#sniv').val(nivl);
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
     var id = $(e.relatedTarget).data().idus;
      $(e.currentTarget).find('#idusu').val(id);
     var llog = $(e.relatedTarget).data().logg;
      $(e.currentTarget).find('#txtope').val(llog);	
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

