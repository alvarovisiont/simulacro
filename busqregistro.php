
<?php require_once('Connections/conn_registro.php'); ?>
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

if(!isset($_SESSION))
{
  session_start();
}

$colced_rsRegist = "-1";
if (isset($_POST['nac'])) {
  $colced_rsRegist = $_POST['nac'].'-'.$_POST['ced'];
}
$colsop_rsRegist = "-1";
if (isset($_POST['operat'])) {
  $colsop_rsRegist = $_POST['operat'];
}
mysql_select_db($database_conn_registro, $conn_registro);
$query_rsRegist = sprintf("SELECT * FROM sim_reg WHERE CONCAT(nac,'-',cedula) = %s AND id_op_reg=%s ORDER BY cedula ASC", GetSQLValueString($colced_rsRegist, "text"),GetSQLValueString($colsop_rsRegist, "int"));
$rsRegist = mysql_query($query_rsRegist, $conn_registro) or die(mysql_error());
$row_rsRegist = mysql_fetch_assoc($rsRegist);
$totalRows_rsRegist = mysql_num_rows($rsRegist);

if(!empty($_POST['nac'])){
 
 	if ($totalRows_rsRegist > 0) {
      $return = array('error'=>'Ya Esta Registrado en este Operativo','swformu'=>'1');

	} 
  else 
  {
			$colced_rsRep = "-1";
			if (isset($_POST['nac'])) {
			  $colced_rsRep = $_POST['nac'].'-'.$_POST['ced'];
			}
			mysql_select_db($database_conn_registro, $conn_registro);

      $sql ="SELECT id, nombre_completo, movil, telefono from carnet_patria where cedula = $_POST[ced]";
      $res = mysql_query($sql, $conn_registro);
      if(mysql_num_rows($res) > 0)
      {
        $rs = mysql_fetch_assoc($res);
        
        $movil = strtoupper($rs['movil']);

        if( ($movil == "") || ($movil == "SN"))
        {
          $movil = $rs['telefono'];
        }

        $return = [
          'exist' => $rs['id'],
          'txnom' => $rs['nombre_completo'],
          'telefono' => $movil,
          'carnet' => 1
        ];
      }
      else
      {
        $query_rsRep = "SELECT id, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido FROM rep_sucre WHERE nacionalidad  = '$_POST[nac]' and cedula = $_POST[ced] ORDER BY cedula ASC";
        $rsRep = mysql_query($query_rsRep, $conn_registro) or die(mysql_error());
        $row_rsRep = mysql_fetch_assoc($rsRep);
        $totalRows_rsRep = mysql_num_rows($rsRep);
        
        if(!empty($_POST['nac']))
        {
         
           $nombre = $_POST['nac'].'-'.$_POST['ced'];
         
          if ($totalRows_rsRep > 0) {
            $return = array(
            'exist'=>$row_rsRep['id'],
            'txnom'=>$row_rsRep['primer_nombre']." ".$row_rsRep['segundo_nombre']." ".$row_rsRep['primer_apellido']." ".$row_rsRep['segundo_apellido'],
            'carnet' => 0,
            'telefono' => ''
            );
           } 
           else 
           {
           
            $array = ['error'=>'No se encuentra en el Registro Electoral del Circuito','swformu'=>'0'];
            $return = $array;
           }
        }
        mysql_free_result($rsRep);
      }
  }
      die(json_encode($return));
}
mysql_free_result($rsRegist);
?>
