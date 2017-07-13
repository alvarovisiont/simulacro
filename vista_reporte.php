<?php require_once('Connections/conn_registro.php'); ?>
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
 require('menu.php');


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
  <title>Generar Reportes</title>
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
  <br><br>
    <div class="col-md-offset-2 col-md-8">
      <form action="generar_reporte.php" class="form-horizontal" id="form_reporte">
        <div class="form-group">
          <label for="" class="control-label col-md-2">Municipio</label>
          <div class="col-md-4">
            <select name="municipio" id="municipio" class="form-control">
              <option value=""></option>
              <?
                $sql = "SELECT id_municipio, municipio from municipios where id_estado = 17";
                $res = mysql_query($sql, $conn_registro);
                while ($rs = mysql_fetch_assoc($res))
                {
                  echo '<option value="'.$rs['id_municipio'].'">'.$rs['municipio'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="col-md-6">
            <button class="btn btn-success btn-block">Generar&nbsp;<span class="glyphicon glyphicon-share"></span></button>
          </div>
        </div>
      </form>
    </div>
  </div>
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
      $("#form_reporte").submit(function(e){
        e.preventDefault()
        var datos = $(this).serialize(),
            ruta  = $(this).attr('action')

            ruta = ruta+"?"+datos

            window.open(ruta, '_blank')
      })
  })
</script>