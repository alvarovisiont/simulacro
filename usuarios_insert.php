<?php require_once('Connections/conn_registro.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formNuevo")) {
  $insertSQL = sprintf("INSERT INTO sim_users (log_usu, cla_usu, nivel_usu,id_mun_user) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['txtnom'], "text"),
                       GetSQLValueString($_POST['txtcla'], "text"),
                       GetSQLValueString($_POST['sniv'], "text"),
					   GetSQLValueString($_POST['id_municipio_resp'], "text"));

  mysql_select_db($database_conn_registro, $conn_registro);
  $Result1 = mysql_query($insertSQL, $conn_registro) or die(mysql_error());
}
?>