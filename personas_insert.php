<?php require_once('Connections/conn_registro.php'); 



foreach ($_POST as $campo => $valor) {
  $$campo=$valor;
}
date_default_timezone_set('America/Caracas'); 
$fecha = date('d-m-Y');
$hora = date("H:i:s:a", time());
$estacion = gethostbyaddr($_SERVER['REMOTE_ADDR']); 

mysql_select_db($database_conn_registro, $conn_registro);

$sql = "INSERT INTO sim_reg(nac, cedula, nombre, telefono, id_usuario,id_estado, id_mun, id_parro, id_op_reg, fecha, hora, estacion, organizacion, sector, id_centro_v) 
VALUES ('$nac', '$cedula', '$nombre', '$telefono', '$id_usuario',17, '$id_mun', '$id_parro', '$id_op_reg', '$fecha', '$hora', '$estacion', '$organizacion', '$sector', '$id_centro_v')";

mysql_query($sql, $conn_registro) or die(mysql_error());

 ?>
