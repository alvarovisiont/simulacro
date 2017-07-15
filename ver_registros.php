<?php require_once('Connections/conn_registro.php'); ?>
<?php require_once('Connections/conn_rep.php'); ?>
<?php

if(!isset($_SESSION)) 
{
  session_start();
}

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
$id_municipio = $_SESSION['MM_UserMun'];
/*CONSULTA PARROQUIA*/
/* menu */
 require('menu.php');


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
  <title>Personas Registradas</title>
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
<body>

  <div class="row">
    <div class="container" id="ppal">
      <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h2 style="color: white;">Registros de Votantes&nbsp;<span class="glyphicon glyphicon-user"></span></h2>
          </div>
          <div class="panel-body">
              <br>
            <table class="table table-striped table-condensed" id="tabla_estadistica">
              <thead>
                <tr>
                  <th class="text-center">Municipio</th>
                  <th class="text-center">Votantes</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
            <br>
            <div class="col-md-6 col-md-offset-3" id="barra_oculta">
              <div class="progress progress-striped active">
                    <div class="progress-bar progress-bar-success" role="progressbar"
                       aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"
                       style="width: 100%">
                       <span>Cargando...</span>
                      <span class="sr-only">45% completado</span>
                  </div>
              </div>
            </div>
            <div class="col-md-6 col-md-offset-3" id="barra_oculta1" style="display: none">
              <div class="progress progress-striped active">
                    <div class="progress-bar progress-bar-success" role="progressbar"
                       aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"
                       style="width: 100%">
                       <span>Actualizando...</span>
                      <span class="sr-only">45% completado</span>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
          </div>
        </div>
  <div class="modal fade" id="modal_detalles" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #317eac; color: white;">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
              <h3 class="modal-title custom_align" id="Heading" style="color: white">Detalle de Personas</h3>
            </div><!-- /.modal-header -->
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-striped table-hover" id="tabla_personas">
                    <thead>
                      <tr>
                        <th class="text-center">Nac</th>
                        <th class="text-center">Cédula</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Télefono</th>
                        <th class="text-center">Carnet Patria</th>
                        <th class="text-center">Serial Carnet</th>
                        <th class="text-center">Trabajador Gobierno</th>
                        <th class="text-center">Posición</th>
                        <th class="text-center">Parroquía</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div><!-- /.modal-body -->
            <div class="modal-footer">
            </div>
        </div><!-- /.modal-footer -->
      </div><!-- /.modal-content -->    
  </div><!-- /.modal-Eliminar --> 
  
  <script src="ver_registros.js"></script>  
  <script src="js/jquery-1.11.3.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/dataTables.bootstrap.js"></script>
  <script src="js/dataTables.responsive.js"></script>
</body>
</html>
<script>
  $(function(){
    
    $("#tabla_estadistica").dataTable({
      language: {url: 'json/esp.json'}
    })

    var aprueba = true;
    

    setInterval(function(){

      if(aprueba)
      {
        $("#barra_oculta").hide()
        aprueba = false
      }
      
      actualizar_registros()

    }, 5000)

    $("#modal_detalles").on('show.bs.modal', function(e){
      
      var municipio = $(e.relatedTarget).data().municipio
      ver_detalles(municipio)

    })
  })
</script>