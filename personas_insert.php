<?php require_once('Connections/conn_registro.php'); 



foreach ($_POST as $campo => $valor) {
  $$campo=$valor;
}
date_default_timezone_set('America/Caracas'); 
$fecha = date('d-m-Y');
$hora = date("H:i:s:a", time());
$estacion = gethostbyaddr($_SERVER['REMOTE_ADDR']); 

mysql_select_db($database_conn_registro, $conn_registro);

$serial = 0;

if($carnetpatria == 1)
{
	$serial = $serial_carnet;
}

$posicion_trabajoo = 2;

if($trabaja_gobierno == 1)
{
	$posicion_trabajoo = $posicion_trabajo;
}

$sql = "INSERT INTO sim_reg(nac, cedula, nombre, telefono, id_usuario,id_estado, id_mun, id_parro, id_op_reg, fecha, hora, estacion, carnet_patria, serial_carnet, trabaja_gobierno, posicion_trabajo, id_centro_v) 
VALUES ('$nac', '$cedula', '$nombre', '$telefono', '$id_usuario',17, '$id_mun', '$id_parro', '$id_op_reg', '$fecha', '$hora', '$estacion', $carnetpatria,'$serial', '$trabaja_gobierno', '$posicion_trabajoo', '$id_centro_v')";

mysql_query($sql, $conn_registro) or die(mysql_error());

 ?>
