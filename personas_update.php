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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formEditar")) {
  $updateSQL = sprintf("UPDATE reg_personas SET id_op_reg=%s, cedula=%s, primer_nom=%s, primer_ape=%s, telefono_movil=%s, id_centro_reg=%s WHERE id_persona=%s",
                       GetSQLValueString($_POST['sop'], "int"),
                       GetSQLValueString($_POST['txced'], "text"),
                       GetSQLValueString($_POST['txnom'], "text"),
                       GetSQLValueString($_POST['txape'], "text"),
                       GetSQLValueString($_POST['txtel'], "text"),
                       GetSQLValueString($_POST['sCentro'], "int"),
                       GetSQLValueString($_POST['id_op'], "int"));

  mysql_select_db($database_conn_registro, $conn_registro);
  $Result1 = mysql_query($updateSQL, $conn_registro) or die(mysql_error());
}
?>