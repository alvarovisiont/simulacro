<?
	 require_once('Connections/conn_registro.php');

	 mysql_select_db($database_conn_registro, $conn_registro);

	 $sql = "SELECT COUNT(*) as cantidad, (SELECT municipio from municipios where id_estado = 17 and id_municipio = sim_reg.id_mun) as municipio from sim_reg where id_estado = 17 group by id_mun";
	 $res = mysql_query($sql, $conn_registro);
	 $data = [];
	 while ($rs = mysql_fetch_assoc($res)) 
	 {
	 		$data[] = $rs;
	 }

	 echo json_encode($data);

?>