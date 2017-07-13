<?php

	require_once('Connections/conn_registro.php');
	require_once 'php_excel/Classes/PHPExcel.php';

		mysql_select_db($database_conn_registro, $conn_registro);

		$tpm_file = "data_clap_sucre_final.xlsx";
		$excelReader = PHPExcel_IOFactory::createReaderForFile($tpm_file);
		$excelObj = $excelReader->load($tpm_file);
		$worksheet = $excelObj->getSheet(0);
		$lastRow = $worksheet->getHighestRow();
		$con = 0;
		$conn_clap = 0;
		$clap = "";
		$id_clap = "";
		
		for ($row = 2; $row <= $lastRow; $row++) {
				if($conn_clap == 0)
				{
					
						$clap = $worksheet->getCell('B'.$row)->getValue();

						$sql = "INSERT INTO reg_usuarios(nom_usu,ape_usu,id_estado,id_municipio,id_parroquia,comunidad,inte,lider,status,grupo) 
					 																	VALUES(	 '".$worksheet->getCell('A'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('B'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('C'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('D'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('E'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('A'.$row)->getValue()."',
					 																					 2,
					 																					 1,
					 																					 1,
					 																					 '".$worksheet->getCell('H'.$row)->getValue()."'
					 																				)";

					 	if(mysql_query($sql, $conn_registro))
					 	{
					 		echo "primer_insert ".$con++."<br>";
					 	}
					 	else
					 	{
					 		echo "1fallido"." ".$con++."<br>";
					 	}

					 	$id_clap = mysql_insert_id($conn_registro);

					 	//echo "comparacion ".$clap." ".$worksheet->getCell('B'.$row)->getValue();
									
									//$clap = $worksheet->getCell('B'.$row)->getValue();

					 	$sql = "INSERT INTO reg_usuarios_det(id_usu,nom_usu,log_usu,cla_usu, nivel_usu, grupo) 
					 																	VALUES(	 '".$id_clap."',
					 																					 '".$worksheet->getCell('B'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('B'.$row)->getValue()."',
					 																					 123456789,
					 																					 5,
					 																					 '".$worksheet->getCell('H'.$row)->getValue()."'
					 																				)";

					 	if(mysql_query($sql, $conn_registro))
					 	{
					 		echo "segundo_insert ".$con."<br>";
					 	}
					 	else
					 	{
					 		echo "2fallido"." ".$con."<br>";
					 	}


					 	//$conn_clap++;



						$sql = "INSERT INTO reg_usuarios_det(id_usu,nom_usu,ape_usu,nac,ced,id_ente,telf,id_rol,otro_rol) 
					 																	VALUES(	 '".$id_clap."',
					 																					 '".$worksheet->getCell('I'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('J'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('K'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('L'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('M'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('N'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('O'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('P'.$row)->getValue()."'
					 																				)";			 	
					 	if(mysql_query($sql, $conn_registro))
					 	{
					 		echo "tercer_insert ".$con."<br>";
					 	}
					 	else
					 	{
					 		echo "3fallido"." ".$con."<br>";
					 	}

					 	$conn_clap++;

					
					 	
				}
				else
				{
					if($clap != $worksheet->getCell('B'.$row)->getValue())
					{

						//echo "comparacion ".$clap." ".$worksheet->getCell('B'.$row)->getValue();

						$clap = $worksheet->getCell('B'.$row)->getValue();

						$sql = "INSERT INTO reg_usuarios(nom_usu,ape_usu,id_estado,id_municipio,id_parroquia,comunidad,inte,lider,status,grupo) 
					 																	VALUES(	 '".$worksheet->getCell('A'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('B'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('C'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('D'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('E'.$row)->getValue()."',
					 																					 '".$worksheet->getCell('A'.$row)->getValue()."',
					 																					 2,
					 																					 1,
					 																					 1,
					 																					 '".$worksheet->getCell('H'.$row)->getValue()."'
					 																				)";

					 	if(mysql_query($sql, $conn_registro))
					 	{
					 		echo "primer_insert ".$con++."<br>";
					 	}
					 	else
					 	{
					 		echo "1fallido"." ".$con++."<br>";
					 	}

					 	$id_clap = mysql_insert_id($conn_registro);


					 	//echo "comparacion ".$clap." ".$worksheet->getCell('B'.$row)->getValue();
							
							//$clap = $worksheet->getCell('B'.$row)->getValue();

					 	$sql = "INSERT INTO reg_usuarios_det(id_usu,nom_usu,log_usu,cla_usu, nivel_usu, grupo) 
					 																	VALUES(	 '".$id_clap."',
				 																					 '".$worksheet->getCell('B'.$row)->getValue()."',
				 																					 '".$worksheet->getCell('B'.$row)->getValue()."',
				 																					 123456789,
				 																					 5,
				 																					 '".$worksheet->getCell('H'.$row)->getValue()."'
					 																			)";

					 	if(mysql_query($sql, $conn_registro))
					 	{
					 		echo "segundo_insert ".$con."<br>";
					 	}
					 	else
					 	{
					 		echo "2fallido"." ".$con."<br>";
					 	}

							$sql = "INSERT INTO reg_usuarios_det(id_usu,nom_usu,ape_usu,nac,ced,id_ente,telf,id_rol,otro_rol) 
											VALUES(	 '".$id_clap."',
															 '".$worksheet->getCell('I'.$row)->getValue()."',
															 '".$worksheet->getCell('J'.$row)->getValue()."',
															 '".$worksheet->getCell('K'.$row)->getValue()."',
															 '".$worksheet->getCell('L'.$row)->getValue()."',
															 '".$worksheet->getCell('M'.$row)->getValue()."',
															 '".$worksheet->getCell('N'.$row)->getValue()."',
															 '".$worksheet->getCell('O'.$row)->getValue()."',
															 '".$worksheet->getCell('P'.$row)->getValue()."'
														)";	

						 	if(mysql_query($sql, $conn_registro))
						 	{
						 		echo "tercer_insert ".$con."<br>";
						 	}
						 	else
						 	{
						 		echo "3fallido"." ".$con."<br>";
						 	}
					 	
					 	$conn_clap++;		

					}
				}
		}
?>