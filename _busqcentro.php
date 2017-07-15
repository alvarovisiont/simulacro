<?php  

require_once('Connections/conn_registro.php');

mysql_select_db($database_conn_registro, $conn_registro);

$sql = "SELECT ctro_prop, nombre_centro from centro_votaciones where estado = 17 and municipio = $_GET[mun] and parroquia = $_GET[parro]";

$result = mysql_query($sql, $conn_registro) or die(mysql_error());

$filas = [];

while ($row = mysql_fetch_assoc($result)) {
  $filas[] = $row;
}

echo json_encode($filas);

?>