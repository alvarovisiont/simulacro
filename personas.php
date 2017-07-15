<?php require_once('Connections/conn_registro.php'); ?>
<?php require_once('Connections/conn_rep.php'); ?>
<?php
/// Rutina para Evitar la inyeccion de Codigo
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
session_start();
$id_municipio = $_SESSION['MM_UserMun'];
/*CONSULTA PARROQUIA*/
mysql_select_db($database_conn_registro, $conn_registro);
$query_rsOpe = "SELECT * FROM parroquias WHERE id_municipio = '$id_municipio' and id_estado = 17";
$rsOpe = mysql_query($query_rsOpe, $conn_rep) or die(mysql_error());
$row_rsOpe = mysql_fetch_assoc($rsOpe);
$totalRows_rsOpe = mysql_num_rows($rsOpe);
/* menu */
 require('menu.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
  <title>Registro de Personas</title>
  <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="css/sweetalert2.css">
  <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/dataTables.tableTools.min.css">
  <link rel="stylesheet" type="text/css" href="css/dataTables.responsive.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/personal.css">
  <link rel="stylesheet" type="text/css" href="css/select2.css">
  <link rel="stylesheet" type="text/css" href="css/select2-bootstrap.css">
  
  
</head>
<body style="background-color:#ddd">
<div class="container" id="ppal">
<section>




<!-- ventana modal Nuevo -->

    <div class="modal-dialog">
        <div class="modal-content form-horizontal">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            <h4 class="modal-title custom_align" id="Heading">Nuevo Registro de Personas: </h4>
            </div><!-- /.modal-header -->
            <div class="modal-body">
			<fieldset>
                <div class="form-group"><!-- selectoperat -->
                <label class="col-md-3 control-label input-sm" for="sop">Parroquia:</label>
                    <div class="col-lg-9">
                      <select id="bqsop" name="id_parroquia"  onchange="document.getElementById('txparro').value=document.getElementById('bqsop').value" class="form-control input-sm" autofocus required>
                        <option value="" disabled selected>Seleccione...</option>
                        <?php 
                        do { 
                        ?>
                        <option value="<?php echo $row_rsOpe['id_parroquia']?>"><?php echo $row_rsOpe['parroquia']?></option>
                        <?php
                          } while ($row_rsOpe = mysql_fetch_assoc($rsOpe));
                            $rows = mysql_num_rows($rsOpe);
                            if($rows > 0) {
                              mysql_data_seek($rsOpe, 0);
                              $row_rsOpe = mysql_fetch_assoc($rsOpe);
                            }
                          ?>
                      </select>
                    </div>
                </div>  
                <div class="form-group"><!--txtcedula-->
        <label class="col-md-3 control-label input-sm" for="txced">Cédula:</label> 
                <div class="col-lg-9">
                    <div class="input-group">
                    <div class="input-group-btn">
                    <select id="bqnac" class="form-control input-sm" style="width:55px" onChange="document.getElementById('txnac').value=document.getElementById('bqnac').value">
              <option value="V" selected>V</option>
              <option value="E">E</option>
            </select>
                     </div>
                      <input id="bqced" name="bqced" type="number" min="1" pattern="[0-9]{1,8}" placeholder="Cédula , (solo números)" class="form-control input-sm" required max="8" onKeyUp="document.getElementById('txced').value=document.getElementById('bqced').value">
                      <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" onClick="busqREP();">Buscar <span class="glyphicon glyphicon-search"></span></button>
                      </span>                      
                    </div><!-- /input-group -->
                  <h4><div id="estado" class="label" hidden="true"></div></h4>
                 </div><!-- /.col-lg-6 -->
                </div><!-- ./ txtcedula -->
                               
<form method="POST" action="personas_insert.php" id="formNuevo" name="formNuevo" >
        
        <input id="txnac" name="nac" type="hidden" value="V">
        <input id="txced" name="cedula" type="hidden">
        <input name="id_usuario" type="hidden" value="<?php echo $_SESSION['MM_UserId'] ?>">
        <input name="id_mun" type="hidden" value="<?php echo $_SESSION['MM_UserMun'] ?>">       
        <input id="txparro" name="id_parro" type="hidden" >    
        <input id="sop" name="id_op_reg" type="hidden" value="12"> 
        <input id="txcentro" name="id_centro_v" type="hidden">
      
<div id="formu" style="display:none;">
                
                <div class="form-group" id="centro" style="display:none;"><!-- selectoperat -->
                  <label class="col-md-3 control-label input-sm" for="sop">Centro de Votación:</label>
                      <div class="col-lg-9">
                        <select id="id_centro_v" name="id_centro_v" onchange="document.getElementById('txcentro').value=document.getElementById('id_centro_v').value" class="form-control input-sm" autofocus required>
                          <option value="" disabled selected>Seleccione...</option>
                        </select>
                    </div>
                </div>                     

                <div id="txnomb" class="form-group"><!--txtnombre-->
                <label class="col-md-3 control-label input-sm" for="txnom">Nombre Completo:</label>  
                    <div class="col-lg-9">
                        <input id="txnom" name="nombre" readonly type="text" placeholder="Nombre" class="form-control input-sm" required >
                    </div>
                </div>   

                <div class="form-group"><!--txttelefono-->
                <label class="col-md-3 control-label input-sm" for="txtel">Teléfono Móvil:</label>  
                    <div class="col-md-6">
                        <input id="txtel" name="telefono" type="tel" pattern="[0-9]{11}" placeholder="####-###-##-##" required class="form-control input-sm" >
                    </div>  
                        
                </div>    

                <div class="form-group">
                  <label for="" class="col-md-3 control-label input-sm">Carnet de la Patria: </label>
                  <div class="col-md-1">
                    <label for="carnet1" class="radio-inline">
                      <input type="radio" id="carnet1" name="carnetpatria" value="1" required="">
                      Si
                    </label>
                  </div>
                  <div class="col-md-1">
                    <label for="carnet2" class="radio-inline control-label">
                      <input type="radio" id="carnet2" name="carnetpatria" value="0" required="">
                      No
                    </label>
                  </div>
                </div>

                <fieldset id="field_hide" style="display: none">
                  <div class="form-group">
                    <label for="" class="col-md-3 control-label input-sm">Serial del Carnet: </label>
                    <div class="col-md-6">
                      <input type="text" id="seria_carnet" name="serial_carnet" pattern="[0-9]{10}" class="form-control input-sm">
                    </div>
                  </div>
                </fieldset>

                <div class="form-group">
                  <label for="" class="col-md-3 control-label input-sm">Trabajador del Gobierno: </label>
                  <div class="col-md-1">
                    <label for="trabaja_gobierno1" class="radio-inline">
                      <input type="radio" id="trabaja_gobierno1" name="trabaja_gobierno" value="1" required="">
                      Si
                    </label>
                  </div>
                  <div class="col-md-1">
                    <label for="trabaja_gobierno2" class="radio-inline control-label">
                      <input type="radio" id="trabaja_gobierno2" name="trabaja_gobierno" value="0" required="">
                      No
                    </label>
                  </div>
                </div>

                <fieldset id="field_hide1" style="display: none">
                  <div class="form-group">
                    <label for="" class="col-md-3 control-label input-sm">Nivel: </label>
                  <div class="col-md-2">
                    <label for="posicion1" class="radio-inline">
                      <input type="radio" id="posicion1" name="posicion_trabajo" value="1">
                      Fijo
                    </label>
                  </div>
                  <div class="col-md-2">
                    <label for="posicion2" class="radio-inline control-label">
                      <input type="radio" id="posicion2" name="posicion_trabajo" value="0">
                      Contratado
                    </label>
                  </div>
                  </div>
                </fieldset>

                <div class="modal-footer">
                  <div class="form-group"><!-- Button (Double) -->
                  <label class="col-md-3 control-label" for="buttonenviar"></label>
                      <div class="col-md-9">
                      	<button id="buttonenviar" name="buttonenviar" class="btn btn-primary" type="submit" >Registrar <span class="glyphicon glyphicon-thumbs-up"></span></button>
                        <button id="buttoncancelar" name="buttoncancelar" class="btn btn-danger" type="button"   data-dismiss="modal" aria-hidden="true" onClick="javascrip: location.reload(false)">Cancelar  <span class="glyphicon glyphicon-remove"></span></button>
                  	    <input type="hidden" name="MM_insert" id="MM_insert" value="MM_insert">
                      </div>
                  </div>
                </div>
              </form>
</div> 


</section>
</div>
<script src="js/jquery-1.11.3.min.js"></script>
  <script src="personas.js"></script>
  <script src="js/sweetalert2.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/select2.js"></script>
  <script src="js/select2_locale_es.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/dataTables.bootstrap.js"></script>
  <script src="js/dataTables.responsive.js"></script>
</body>
</html>

<script>
 
$(document).ready(function() {

  $("#id_centro_v").select2()

  $('#bqced').keypress(function(e){   
   if(e.which == 13){      
     busqREP();      
   }   
  });  

});  
function busqcentro(){ 

      document.getElementById('id_centro_v').innerHTML='';

      var valparr = $('#bqsop').val();

    htttml = '<option value="" selected> Seleccione Centro de Votación</option>'
     
         var consulta = $.ajax({
            type:'POST',      
            url:'_busqcentro.php',
            data:{id_parroquia:valparr},
            dataType:'JSON'     
         }); 
 
         /* En caso de que se haya retornado bien.. */
         consulta.done(function(data){

             for (var i = data.length - 1; i >= 0; i--) {
                    $.each( data[i] , function(k, v){
                      cod_cv = data[i]['cod_cv']
                      descripcion = data[i]['descripcion']                      
                    });
                    htttml += '<option value='+cod_cv+'>'+descripcion+'</option>'
                };  
               //$('#mun').show('slow/2000/fast');
               $('#id_centro_v').html(htttml);
               $('#centro').show('slow/2000/fast')
               return true;
            });
 
         /* Si la consulta ha fallado.. */
         consulta.fail(function(){
          alert('Seleccione Una Parroquia Válida')
            return false;

         });

    }
	 


   function busqREP(){ 
   
       /*$('#cliente').on("blur",'#nombre',function(){ 
         Obtenemos el valor del campo 
      var valor = this.value;*/
      var nac = document.getElementById('txnac').value

      var ced = document.getElementById('txced').value
	     var valsop = document.getElementById('sop').value;
      /* Si la longitud del valor es mayor a 2 caracteres.. */
	  
    var selop =  document.getElementById('bqsop').value;

      if(ced != "" && selop != ""){ 
    
         $('#formu').hide('slow/2000/fast')
         $('#txtel').val('');
         $('#txnom').val('');
         $('#sector').val('');
         $('#organizacion').val('');
               /* Cambiamos el estado.. */
    		 $('#estado').attr('style',"text-shadow:0 2px 2px rgba(0,0,0, .7)");
    		 $('#estado').attr('hidden',false);
    		 $('#estado').removeClass();
    		 $('#estado').addClass("label label-info");
         $('#estado').html('Cargando datos de servidor... <i class="fa fa-circle-o-notch fa-spin"></i>'); 
		 
         /* Hacemos la consulta ajax */
         var consulta = $.ajax({
            type:'POST',			
            url:'busqregistro.php',
            data:{nac: nac , ced: ced , parroquia: selop, operat:valsop},
            dataType:'JSON',			
         })  
  
         /* En caso de que se haya retornado bien.. */
         consulta.done(function(data){
            if(data.error!==undefined)
            {
    				   if (data.swformu >= 1) 
               {				   		  
    						  $('#formu').hide('slow/2000/fast')
                }
    				    else 
                { 
    						   $('#formu').show('slow/2000/fast')
                }
      			   $('#estado').attr('style',"text-shadow:0 2px 2px rgba(0,0,0, .7)");
      			   $('#estado').attr('hidden',false);
      			   $('#estado').removeClass();
      			   $('#estado').addClass("label label-danger");
               $('#estado').html(data.error);
      			   $('#exist').val('NoExiste');		   
      			   $('#txnom').attr('hidden',false);
               $('#txnom').attr('readonly',false);
               
               var filas = "<option></option>"
               $.grep(data.centros, function(i,e){
                  filas+= '<option value="'+i.ctro_prop+'">'+i.nombre_centro+'</option>'
               })
               $("#id_centro_v").html(filas)
               $("#id_centro_v").prop('disabled', false)
               $("#centro").show()
                return false
            } 
			     else 
           {
               $("#centro").hide()
               $("#id_centro_v").prop('disabled', true)

			         $('#formu').show('slow/2000/fast')
              if(data.txnom!==undefined){ 
    			   		  if ((data.txnom).length >= 1) {
    						  $('#txnom').val(data.txnom);
    						  $('#txnom').removeClass("alert-danger");
    						  $('#txnomb').attr('hidden',false);
                }
    				    else 
                {
    						  $('#txnom').addClass("alert-danger");
    					  	$('#txnom').attr('hidden',false);
                }
						  }

              if(data.centro_v!==undefined){ 
                $("#txcentro").val(data.centro_v)
              }		   	

      			   $('#exist').val(data.exist);
      			   $('#estado').attr('style',"text-shadow:0 2px 2px rgba(0,0,0, .7)");
      			   $('#estado').attr('hidden',false);
      			   $('#estado').removeClass();
      			   $('#estado').addClass("label label-success");
               $('#estado').html('Datos del elector encontrados');
               return true;
            }
         });
 
         /* Si la consulta ha fallado.. */
         consulta.fail(function(){
    			$('#estado').attr('style',"text-shadow:0 2px 2px rgba(0,0,0, .7)");
    			$('#estado').attr('hidden',false);
    			$('#estado').removeClass();
    			$('#estado').addClass("label label-danger");
            $('#estado').html('Ha habido un error contactando el servidor.');
            return false;
         });
      
      } 
      else 
      {
         /* Mostrar error */
         $('#estado').attr('style',"text-shadow:0 2px 2px rgba(0,0,0, .7);visibility:visible");
         $('#estado').removeClass();
         $('#estado').addClass("label label-warning");
         $('#estado').html('Debe Rellenar Todos los Campos...');
         return false;
      }

      $('[name="carnetpatria"]').click(function(){
        var val = $(this).val()
        if(val == 1)
        {
          $("#field_hide").show('slow/400/fast',function(e){
              $("#serial_carnet").prop('required',true)
          })
        }
        else
        {
          $("#field_hide").hide('slow/400/fast',function(e){
              $("#serial_carnet").prop('required',false)
          }) 
        }
      })

      $('[name="trabaja_gobierno"]').click(function(){
        var val = $(this).val()
        if(val == 1)
        {
          $("#field_hide1").show('slow/400/fast',function(e){
              $('#posicion1').prop('required',true)
          })
        }
        else
        {
          $("#field_hide1").hide('slow/400/fast',function(e){
              $('#posicion1').prop('required',false)
          }) 
        }
      })

 };
   
   </script>



