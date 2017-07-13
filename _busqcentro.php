<?php  
require_once('Connections/conn_rep.php'); 
require_once('_mquot.php'); 
extract($_POST);
mysql_select_db($database_conn_rep, $conn_rep);
$sql = "SELECT * FROM nucleacion WHERE id_parroquia = '$id_parroquia'";
$result = mysql_query($sql, $conn_rep) or die(mysql_error());
while ($row = mysql_fetch_assoc($result)) {
  $filas[] = $row;
}

$return = $filas;

die(json_encode($return)); 

?>