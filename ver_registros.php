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
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-body">
            <button class="btn btn-block btn-success" data-toggle="modal" data-target="#mod_estadisticas">Ver estadísticas</button>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 >Registros de Votantes</h3>
          </div>
          <div class="panel-body">
            <table class="table table-striped table-condensed" id="tabla">
            <thead>
              <tr>
                <th class="text-center">Nac</th>
                <th class="text-center">Céd</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Teléfono</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Municipio</th>
                <th class="text-center">Parroquía</th>
              </tr>
            </thead>
            <tbody class="text-center">
                <?
                    $sql = "SELECT *, 
                    (SELECT parroquia from parroquias where id_estado = 17 and id_municipio = sim_reg.id_mun and id_parroquia = sim_reg.id_parro) as parroquia,
                    (SELECT municipio from municipios where id_estado = 17 and id_municipio = sim_reg.id_mun) as municipio
                     from sim_reg where id_estado = 17";

                     $res = mysql_query($sql, $conn_registro);
                     while ($rs = mysql_fetch_assoc($res))
                     {
                       echo '<tr>
                              <td>'.$rs['nac'].'</td>
                              <td>'.$rs['cedula'].'</td>
                              <td>'.$rs['nombre'].'</td>
                              <td>'.$rs['telefono'].'</td>
                              <td>'.$rs['fecha'].'</td>
                              <td>'.$rs['municipio'].'</td>
                              <td>'.$rs['parroquia'].'</td>';
                     }
                ?>
            </tbody>
          </table>
          </div>
        </div>
        <br>
      </div>
    </div>
  </div>
  <div class="modal fade" id="mod_estadisticas" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: darkred; color: white;">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
              <h3 class="modal-title custom_align" id="Heading" style="color: white">Estadísticas por Municipios</h3>
            </div><!-- /.modal-header -->
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-striped table-hover" id="tabla_estadistica">
                    <thead>
                      <tr>
                        <th class="text-center">Municipio</th>
                        <th class="text-center">Cantidad</th>
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
    
  <script src="js/jquery-1.11.3.min.js"></script>
  <script src="js/sweetalert2.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/select2.js"></script>
  <script src="js/select2_locale_es.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/dataTables.bootstrap.js"></script>
  <script src="js/dataTables.tableTools.min.js"></script>
  <script src="js/dataTables.responsive.js"></script>
  <script src="js/dataTables.responsive.js"></script>
</body>
</html>
<script>
  $(function(){
    $("#tabla").dataTable({
      language: {url: 'json/esp.json'}
    })

    $("#mod_estadisticas").on('show.bs.modal', function(e){

      $("#tabla_estadistica").DataTable().destroy()

      $("#tabla_estadistica").dataTable({
        language: {url: 'json/esp.json'},
        ajax :{
          url: 'buscar_estadisticas.php',
          type: 'GET',
          "dataSrc" : ""
        },
        columns:[
          {"data" : "municipio"},
          {"data" : "cantidad"}
        ]
      })
    })
  })
</script>