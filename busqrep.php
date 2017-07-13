<?php require_once('Connections/conn_rep.php'); ?>

<?php
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

$colced_rsRep = "-1";
if (isset($_POST['naccedula'])) {
  $colced_rsRep = $_POST['naccedula'];
}
mysql_select_db($database_conn_rep, $conn_rep);
$query_rsRep = sprintf("SELECT * FROM rep WHERE CONCAT(nac,'-',cedula) = %s ORDER BY cedula ASC", GetSQLValueString($colced_rsRep, "text"));
$rsRep = mysql_query($query_rsRep, $conn_rep) or die(mysql_error());
$row_rsRep = mysql_fetch_assoc($rsRep);
$totalRows_rsRep = mysql_num_rows($rsRep);

if(!empty($_POST['naccedula'])){
 
   $nombre = $_POST['naccedula'];
 
 	if ($totalRows_rsRep > 0) {
      $return = array(
	  'exist'=>$row_rsRep['id'],
	  'txnom'=>$row_rsRep['nombre'],
	  'txsex'=>$row_rsRep['sexo'],
	  'txfech'=>$row_rsRep['fecha_nac'],
	  'txtel'=>$row_rsRep['telefono'],
	  'sCentro'=>$row_rsRep['cod_cv'],	 
	  'sSect'=>$row_rsRep['id_sec'],	   
	  'sUbch'=>$row_rsRep['id_cargo_ubch'],
	  'sUbch_sel'=>$row_rsRep['cod_ubch'],
	  'sCc'=>$row_rsRep['m_cc'],
	  'mpsuv'=>$row_rsRep['m_psuv'],
	  'sClp_sel'=>$row_rsRep['cod_clp'],
	  'sClp'=>$row_rsRep['clp']);
	} else {
      $return = array('error'=>'No se encuentra en el Registro Electoral del Municipio');
   }
      die(json_encode($return));
}

mysql_free_result($rsRep);
?>
