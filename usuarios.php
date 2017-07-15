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
///Consulta para llenar la Tabla Princial
mysql_select_db($database_conn_registro, $conn_registro);
$query_rsUsu = "SELECT USUA.id_usu, USUA.log_usu, USUA.cla_usu, USUA.nivel_usu, (SELECT municipio from municipios where id_municipio = USUA.id_mun_user and municipios.id_estado = 17) as municipio FROM simulacro.sim_users as USUA ORDER BY USUA.nivel_usu ASC";
$rsUsu = mysql_query($query_rsUsu, $conn_registro) or die(mysql_error());
$row_rsUsu = mysql_fetch_assoc($rsUsu);
$totalRows_rsUsu = mysql_num_rows($rsUsu);


/*CONSULTA MUNICIPIOS*/
mysql_select_db($database_conn_registro, $conn_registro);
$query_rsOpe = "SELECT * FROM municipios WHERE id_estado = '17'";
$rsOpe = mysql_query($query_rsOpe, $conn_rep) or die(mysql_error());
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
  <title>Registro de Usuarios</title>
  <script src="usuarios.js"></script>
  <script src="js/sweetalert2.min.js"></script>
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/dataTables.bootstrap.js"></script>
  <script src="js/dataTables.responsive.js"></script>
    
  <link rel="stylesheet" type="text/css" href="css/sweetalert2.css">
  <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/dataTables.responsive.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/personal.css">

</head>
<body onLoad="busqmun();">
<div class="col-lg-3">
<div class="panel panel-default">
<div class="panel-heading">Agregar Usuarios:</div>
<br>
<div style="padding:0px 20px;">
<button  data-title="modNuevo" data-toggle="modal" data-target="#modNuevo" class="btn btn-success btn-block" style="text-shadow:0 2px 2px rgba(0,0,0, .7);">Nuevo Registro <span class="glyphicon glyphicon-plus-sign"></span></button>
</div>
<br><br>
</div><!-- ./panel panel-default -->
</div><!-- ./col-lg-6 -->


<div class="col-lg-9">
<div class="panel panel-default">
<div class="panel-heading">Lista de Usuarios:</div>
<br>
<div style="padding:0px 20px;">
<table id="tabla" class="table table-hover table-striped" width="100%">
  <thead>
  	<tr>
      <th width="10%"></th>
      <th width="20%">Municipio</th>
      <th width="40%">Usuario</th>
      <th width="20%">Nivel de Acceso</th>
      <th width="5%">Editar</th>                      
      <th width="5%">Borrar</th>
     </tr>
  </thead>
  <tbody>
	<?php
	 do {
		  ?>
      <tr>
		<td><?php echo $row_rsUsu['id_usu']; ?></td>
		<td><?php echo $row_rsUsu['municipio']; ?></td>
		<td><?php echo $row_rsUsu['log_usu']; ?></td>
		<td><?php if ($row_rsUsu['nivel_usu']=='adm'){
    echo 'Administrador';}elseif ($row_rsUsu['nivel_usu']=='ope'){ echo 'Operador';} else { echo "<p data-placement='top' data-toggle='tooltip' title='Editar'>
	<button style='text-shadow:0 2px 2px rgba(0,0,0, .7);' class='btn btn-warning btn-xs' data-title='modEditar' data-toggle='modal' data-target='#modEditar' 
        	data-idus=".$row_rsUsu["id_usu"]."
          	data-logg=".$row_rsUsu['log_usu']."
          	data-clav=".$row_rsUsu['cla_usu']."
          	data-niv=".$row_rsUsu['nivel_usu']." 
	>Asignar Nivel <span class='glyphicon glyphicon-warning-sign'></span></button></p>"	
	;} ?></td>
        <td><p data-placement="top" data-toggle="tooltip" title="Editar">
        <button style="text-shadow:0 2px 2px rgba(0,0,0, .7);" class="btn btn-primary btn-xs" data-title="modEditar" data-toggle="modal" data-target="#modEditar" 
        	data-idus="<?php echo $row_rsUsu['id_usu']; ?>"
          	data-logg="<?php echo $row_rsUsu['log_usu']; ?>"
           	data-clav="<?php echo $row_rsUsu['cla_usu']; ?>"
          	data-niv="<?php echo $row_rsUsu['nivel_usu']; ?>"
             ><span class="glyphicon glyphicon-pencil"></span></button></p></td>             
		<td><p data-placement="top" data-toggle="tooltip" title="Borrar">        
		<button style="text-shadow:0 2px 2px rgba(0,0,0, .7);" class="btn btn-danger btn-xs" data-title="modEliminar" data-toggle="modal" data-target="#modEliminar" 
        	data-idus="<?php echo $row_rsUsu['id_usu']?>"
          data-logg="<?php echo $row_rsUsu['log_usu'];?>"
            type="button"><span class="glyphicon glyphicon-trash"></span></button>                             
        </p></td>
      </tr>
	  <?php } while ($row_rsUsu = mysql_fetch_assoc($rsUsu)); ?>
    </tbody>
</table>
</div>
</div><!-- ./panel panel-default -->
</div><!-- ./col-lg-6 -->
<br>


</body>
</html>

<!-- ventana modal Nuevo -->
<div class="modal fade" id="modNuevo" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
<form method="POST" action="usuarios_insert.php" id="formNuevo" name="formNuevo" >
    <div class="modal-dialog">
        <div class="modal-content form-horizontal">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            <h4 class="modal-title custom_align" id="Heading">Incluir un nuevo Usuario </h4>
            </div><!-- /.modal-header -->
	<div class="modal-body">
	<fieldset>
<div class="form-group">
<label for="inputEmail3" class="col-sm-3 control-label">Estado: </label>
    <div class="col-sm-6">
      <input type="text" readonly name="id_estado" id="estado" class="form-control input-sm"  value="EDO. Sucre">
    </div>
    <input type="hidden" value="4" name="id_estado_resp">
    <label for="inputEmail3" class="col-sm-1 control-label"  style="font-size:12px">Circuito: </label>
    <div class="col-sm-2">
      <input type="number" readonly name="num_circuito" id="num_circuito" class="form-control input-sm"  value="3">
    </div>
</div>            
<div class="form-group">
<label for="inputEmail3" class="col-sm-3 control-label">Municipio: </label>
<div class="col-sm-9">
  <select required class="form-control input-sm" name="id_municipio_resp" id="municipio">
        <option value="" selected> Seleccione Municipio</option>
        <?php 
                        do { 
                        ?>
                        <option value="<?php echo $row_rsOpe['id_municipio']?>"><?php echo $row_rsOpe['municipio']?></option>
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
<div class="form-group"><!-- txtnombre -->
  <label class="col-sm-3 control-label" for="txtobv">Usuario:</label>
  <div class="col-sm-9">                     
  <input id="txtnom" name="txtnom" type="text" placeholder="Nombre" class="form-control input-sm" required="" autofocus>
  </div>
</div>	
<div class="form-group"><!-- txtaClave -->
  <label class="col-sm-3 control-label" for="txtobv">Clave:</label>
  <div class="col-sm-9">                     
  <input id="txtcla" name="txtcla" type="password" placeholder="Escriba una Clave" class="form-control input-sm" required="">
  </div>
</div>
<div class="form-group"><!-- txtaClave -->
  <label class="col-sm-3 control-label" for="txtobv">Repita la Clave:</label>
  <div class="col-sm-9">                     
  <input id="txtcla2" name="txtcla2" type="password" placeholder="Repita la Clave" class="form-control input-sm" required="">
  </div>
</div>

<div class="form-group"><!-- selectnivel -->
<label class="col-sm-3 control-label" for="sop">Nivel:</label>
    <div class="col-sm-9">
      <select id="sniv" name="sniv" class="form-control input-sm" autofocus required >
        <option value="" disabled selected>Seleccione un Nivel de Acceso</option>
        <option value="adm" >Administrador</option>
        <option value="ope" >Operador</option>
      </select>
    </div>
</div>
</fieldset>
</div><!-- /.modal-body -->
            <div class="modal-footer">
            <div class="form-group"><!-- Button (Double) -->
            <label class="col-md-4 control-label" for="buttonenviar"></label>
                <div class="col-md-8">
                	<button id="buttonenviar" name="buttonenviar" class="btn btn-primary btn-sm" type="submit" >Incluir Datos <span class="glyphicon glyphicon-thumbs-up"></span></button>
                    <button id="buttoncancelar" name="buttoncancelar" class="btn btn-danger btn-sm" type="button"   data-dismiss="modal" aria-hidden="true" onClick="javascrip: location.reload(false)">Cancelar  <span class="glyphicon glyphicon-remove"></span></button>
            	<input type="hidden" name="id_op" id="id_op" value="">
              </div>
            </div>
            </div><!-- /.modal-footer -->
        </div><!-- /.modal-content -->    
    </div><!-- /.modal-dialog -->
    <input type="hidden" name="MM_insert" value="formNuevo">
</form>
</div><!-- /.modal-Nuevo --> 


<!-- ventana modal Editar -->
<div class="modal fade" id="modEditar" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
<form method="POST" action="usuarios_update.php" id="formEditar" name="formEditar" >
    <div class="modal-dialog">
        <div class="modal-content form-horizontal">
            <div class="modal-header modal-header-success">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            <h4 class="modal-title custom_align" id="Heading">Editar Operativos </h4>
            </div><!-- /.modal-header -->
	<div class="modal-body">
			<fieldset>
<div class="form-group"><!-- txtnombre -->
  <label class="col-md-4 control-label" for="txtobv">Usuario:</label>
  <div class="col-md-8">                     
  <input id="txtnom" name="txtnom" type="text" placeholder="Nombre" class="form-control input-md" required="" autofocus>
  </div>
</div>	
<div class="form-group"><!-- txtaClave -->
  <label class="col-md-4 control-label" for="txtobv">Clave:</label>
  <div class="col-md-8">                     
  <input id="txtcla" name="txtcla" type="password" placeholder="Escriba una Clave" class="form-control input-md" required="">
  </div>
</div>
<div class="form-group"><!-- txtaClave -->
  <label class="col-md-4 control-label" for="txtobv">Repita la Clave:</label>
  <div class="col-md-8">                     
  <input id="txtcla2" name="txtcla2" type="password" placeholder="Repita la Clave" class="form-control input-md" required="">
  </div>
</div>
<div class="form-group"><!-- selectnivel -->
<label class="col-md-4 control-label" for="sop">Nivel:</label>
    <div class="col-lg-8">
      <select id="sniv" name="sniv" class="form-control input-sm" autofocus required >
        <option value="" disabled selected>Seleccione un Nivel de Acceso</option>
        <option value="adm" >Administrador</option>
        <option value="ope" >Operador</option>
      </select>
    </div>
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

<!-- ventana modal Eliminar -->
<div class="modal fade" id="modEliminar" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
<form method="POST" action="usuarios_delete.php" id="formEliminar" name="formEliminar" >
    <div class="modal-dialog">
        <div class="modal-content form-horizontal">
            <div class="modal-header modal-header-success">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            <h4 class="modal-title custom_align" id="Heading">Desea Eliminar?</h4>
            </div><!-- /.modal-header -->
            <div class="modal-body">
			<fieldset>
<div class="form-group">
  <label class="col-md-4 control-label" for="txtobv">Usuario:</label>
  <div class="col-md-8">                     
  <input id="txtope" name="txtope" type="text" placeholder="Nombre del Operativo" class="form-control input-md" required="">
  </div>
</div>            </fieldset>
           	</div><!-- /.modal-body -->
            <div class="modal-footer">
            <div class="form-group"><!-- Button (Double) -->
            <label class="col-md-4 control-label" for="buttonenviar"></label>
                <div class="col-md-8">
                	<button id="buttonenviar" name="buttonenviar" class="btn btn-primary" type="submit" >Eliminar <span class="glyphicon glyphicon-thumbs-up"></span></button>
                    <button id="buttoncancelar" name="buttoncancelar" class="btn btn-danger" type="button"   data-dismiss="modal" aria-hidden="true">Cancelar  <span class="glyphicon glyphicon-remove"></span></button>
            	<input type="hidden" name="idusu" id="idusu" value="">
                    </div>
            </div>
            </div><!-- /.modal-footer -->
        </div><!-- /.modal-content -->    
    </div><!-- /.modal-dialog -->
</form>
</div><!-- /.modal-Eliminar --> 
<script type="text/javascript">
  
$(document).ready(function (e) {



}); 



</script>
<?php
mysql_free_result($rsUsu);
?>