<?
	if(!isset($_SESSION))
	{
		session_start();
	}

	 require_once('Connections/conn_registro.php');

	 mysql_select_db($database_conn_registro, $conn_registro);

	 switch ($_REQUEST['action']) 
	 {
	
	 	case 'buscar_detalles':

	 		$municipio = $_GET['municipio'];

	 		$sql = "SELECT nac, cedula, nombre, telefono, 

	 				CASE carnet_patria
	 					WHEN 0 THEN 'N/P'
	 					ELSE 'Si'
	 				end as carnet_patria,

	 				CASE serial_carnet
	 					WHEN 0 THEN 'N/P'
	 					ELSE serial_carnet
	 				end as serial_carnet,

	 				CASE trabaja_gobierno
	 					WHEN 0 THEN 'No'
	 					ELSE 'Si'
	 				end as trabaja_gobierno,

	 				CASE posicion_trabajo
	 					WHEN 2 THEN 'N/P'
	 					WHEN 1 THEN 'Fijo/Jubilado/Pensionado'
	 					WHEN 0 THEN 'Contratado'
	 				end as posicion_trabajo,
					 
					 (SELECT parroquia from parroquias where id_estado = sim_reg.id_estado and id_municipio = sim_reg.id_mun and id_parroquia = sim_reg.id_parro) as parroquia,
					 (SELECT municipio from municipios where id_estado = sim_reg.id_estado and id_municipio = id_mun) as municipio

	 				 from sim_reg 
	 				 where id_estado = 17 and id_mun = '$municipio'";

	 		$res = mysql_query($sql, $conn_registro);
	 		$data = [];
	 		while ($rs = mysql_fetch_assoc($res)) 
	 		{
	 			$data[] = $rs;
	 		}

	 		echo json_encode($data);
	 	break;

	 	case 'buscar_estadisticas': 

	 		$data = [];

			 if ($_SESSION['MM_UserGroup']=="adm")
			 {
			 	$sql = "SELECT COUNT(*) as cantidad, id_mun as mun, (SELECT municipio from municipios where id_estado = 17 and id_municipio = sim_reg.id_mun) as municipio from sim_reg where id_estado = 17 group by id_mun";
				 $res = mysql_query($sql, $conn_registro);
				 while ($rs = mysql_fetch_assoc($res)) 
				 {
				 		$ver = '<a href="#modal_detalles" data-toggle="modal" data-municipio="'.$rs['mun'].'">'.$rs['cantidad'].'</a>';

				 		$data[] =[
				 			'municipio'  => $rs['municipio'],
				 			'cantidad' => $ver
				 		];
				 }	
			 }
			 else
			 {
			 	$sql = "SELECT COUNT(*) as cantidad, id_mun as mun, (SELECT municipio from municipios where id_estado = 17 and id_municipio = sim_reg.id_mun) as municipio from sim_reg where id_estado = 17 and id_mun = $_SESSION[MM_UserMun] group by id_mun";
				 $res = mysql_query($sql, $conn_registro);
				 while ($rs = mysql_fetch_assoc($res)) 
				 {

				 		$ver = '<a href="#modal_detalles" data-toggle="modal" data-municipio="'.$rs['mun'].'">'.$rs['cantidad'].'</a>';

				 		$data[] =[
				 			'municipio'  => $rs['municipio'],
				 			'cantidad' => $ver
				 		];
				 }		
			 }

			 echo json_encode($data);	
	 	break;
	 }

?>