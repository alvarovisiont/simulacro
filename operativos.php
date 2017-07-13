<?php require_once('Connections/conn_registro.php'); ?>
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
///Consulta para llenar la Tabla Princial
mysql_select_db($database_conn_registro, $conn_registro);
$query_rsOpe = "SELECT * FROM operativo";
$rsOpe = mysql_query($query_rsOpe, $conn_registro) or die(mysql_error());
$row_rsOpe = mysql_fetch_assoc($rsOpe);
$totalRows_rsOpe = mysql_num_rows($rsOpe);

/* menu */
 require('menu.php')
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
  <title>Registro de Personas</title>
  <script src="operativos.js"></script>
  <script src="js/sweetalert2.min.js"></script>
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/dataTables.tableTools.min.js"></script>
  <script src="js/dataTables.responsive.js"></script>
  <link rel="stylesheet" type="text/css" href="css/sweetalert2.css">
  
  <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="css/dataTables.tableTools.min.css">
  <link rel="stylesheet" type="text/css" href="css/dataTables.responsive.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
      <link rel="stylesheet" type="text/css" href="css/personal.css">

</head>
<body onLoad="#modNuevo()">
<div class="container" id="ppal">
<section>
<button  data-title="modNuevo" data-toggle="modal" data-target="#modNuevo" class="btn btn-success">Nuevo Registro <span class="glyphicon glyphicon-plus-sign"></span></button>
</br>
</br>
<div class="table-responsive">
<?php if ($_SESSION['MM_UserGroup']=="ope") { 
	$sbedit="disabled class='btn btn-default btn-xs'";
	$sbelim="disabled class='btn btn-default btn-xs'";
	} else {
	$sbedit="class='btn btn-primary btn-xs'";
	$sbelim="class='btn btn-danger btn-xs'";
	} ?>
<table id="tabla" class="table table-hover table-striped" width="100%">
  <thead>
  	<tr>
      <th width="5%"></th>
      <th width="75%">Descripción del Operativo</th>
      <th width="10%">Estado</th>
      <th width="5%">Editar</th>                      
     </tr>
  </thead>
  <tbody>
	<?php
	 do {
		  ?>
      <tr>
		<td><?php echo $row_rsOpe['id_op']; ?></td>
		<td><?php echo $row_rsOpe['operativo']; ?></td>
        <td><?php if ($row_rsOpe['activo']=='1'){
    echo '<h4><span style="text-shadow:0 2px 2px rgba(0,0,0, .7);vertical-align:text-top" class="label label-success">Operativo Activo</span></h4>';} else { echo '<h4><span style="text-shadow:0 2px 2px rgba(0,0,0, .7);vertical-align:text-top" class="label label-warning">Operativo Inactivo</span></h4>';} ?></td>
            <td><p data-placement="top" data-toggle="tooltip" title="Editar">
        <button <?php echo $sbedit ?> data-title="modEditar" data-toggle="modal" data-target="#modEditar" 
        	data-idop="<?php echo $row_rsOpe['id_op']; ?>"
        	data-ope="<?php echo $row_rsOpe['operativo']; ?>"
        	data-sta="<?php echo $row_rsOpe['activo']; ?>"
             ><span class="glyphicon glyphicon-pencil"></span></button></p></td>             
      </tr>
	  <?php } while ($row_rsOpe = mysql_fetch_assoc($rsOpe)); ?>
    </tbody>
</table>
</div>
</section>
</div>
</body>
</html>

<!-- ventana modal Nuevo -->
<div class="modal fade" id="modNuevo" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
<form method="POST" action="operativos_insert.php" id="formNuevo" name="formNuevo" >
    <div class="modal-dialog">
        <div class="modal-content form-horizontal">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            <h4 class="modal-title custom_align" id="Heading">Incluir un nuevo Operativo </h4>
            </div><!-- /.modal-header -->
            <div class="modal-body">
			<fieldset>
<div class="form-group">
  <label class="col-md-4 control-label" for="txtobv">Descripción:</label>
  <div class="col-md-8">                     
  <input id="txtope" name="txtope" type="text" placeholder="Nombre del Operativo" class="form-control input-md" required="">
  </div>
</div>            </fieldset>
           	</div><!-- /.modal-body -->
            <div class="modal-footer">
            <div class="form-group"><!-- Button (Double) -->
            <label class="col-md-4 control-label" for="buttonenviar"></label>
                <div class="col-md-8">
                	<button id="buttonenviar" name="buttonenviar" class="btn btn-primary" type="submit" >Incuir Datos <span class="glyphicon glyphicon-thumbs-up"></span></button>
                    <button id="buttoncancelar" name="buttoncancelar" class="btn btn-danger" type="button"   data-dismiss="modal" aria-hidden="true" onClick="javascrip: location.reload(false)">Cancelar  <span class="glyphicon glyphicon-remove"></span></button>
            	<input type="hidden" name="id_op" id="id_op" value="">
              </div>
            </div>
            </div><!-- /.modal-footer -->
        </div><!-- /.modal-content -->    
    </div><!-- /.modal-dialog -->
    <input type="hidden" name="txactivo" id="txactivo" value="1">
    <input type="hidden" name="MM_insert" value="formNuevo">
</form>
</div><!-- /.modal-Nuevo --> 

<!-- ventana modal Editar -->
<div class="modal fade" id="modEditar" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
<form method="POST" action="operativos_update.php" id="formEditar" name="formEditar" >
    <div class="modal-dialog">
        <div class="modal-content form-horizontal">
            <div class="modal-header modal-header-success">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            <h4 class="modal-title custom_align" id="Heading">Editar Operativos </h4>
            </div><!-- /.modal-header -->
            <div class="modal-body">
			<fieldset>
<div class="form-group">
  <label class="col-md-4 control-label" for="txtobv">Descripción:</label>
  <div class="col-md-8">                     
  <input id="txtope" name="txtope" type="text" placeholder="Nombre del Operativo" class="form-control input-md" required="">
  </div>
</div>
                <div class="form-group"><!--txtcedula-->
				<label class="col-md-4 control-label" for="seltxsta">Estatus del Operativo:</label> 
                <div class="col-md-8">
                    <select id="seltxsta" name="seltxsta"  class="form-control input-sm" onChange="document.getElementById('txsta').value=document.getElementById('seltxsta').value">
                    	  <option value="" disabled selected>Seleccione un Estatus</option>
						  <option value="1">Activo</option>
						  <option value="0">Inactivo</option>
						</select>
                 </div>
            </fieldset>
           	</div><!-- /.modal-body -->
            <div class="modal-footer">
            <div class="form-group"><!-- Button (Double) -->
            <label class="col-md-4 control-label" for="buttonenviar"></label>
                <div class="col-md-8">
                	<button id="buttonenviar" name="buttonenviar" class="btn btn-primary" type="submit" >Actualizar Datos <span class="glyphicon glyphicon-thumbs-up"></span></button>
                    <button id="buttoncancelar" name="buttoncancelar" class="btn btn-danger" type="button"   data-dismiss="modal" aria-hidden="true">Cancelar  <span class="glyphicon glyphicon-remove"></span></button>
            	<input type="hidden" name="id_op" id="id_op" value="">
                    </div>
            </div>
            </div><!-- /.modal-footer -->
        </div><!-- /.modal-content -->    
    </div><!-- /.modal-dialog -->
    <input type="hidden" name="MM_update" value="formEditar">
</form>
</div><!-- /.modal-Editar --> 


<?php
mysql_free_result($rsOpe);
?>