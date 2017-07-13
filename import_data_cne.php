<?php

	require_once 'php_excel/Classes/PHPExcel.php';
	require_once('Connections/conn_registro.php');

	$tpm_file = "13_excel.xlsx";
	$excelReader = PHPExcel_IOFactory::createReaderForFile($tpm_file);
	$excelObj = $excelReader->load($tpm_file);
	$worksheet = $excelObj->getSheet(0);
	$lastRow = $worksheet->getHighestRow();

	mysql_select_db($database_conn_registro, $conn_registro);

	for ($row = 1; $row <= 50000; $row++) {	


			$campos = "nacionalidad,cedula,primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,cod_centro";
			$values =  '"'.$worksheet->getCell('A'.$row)->getValue().'"'.","
								.$worksheet->getCell('B'.$row)->getValue().","
								.'"'.$worksheet->getCell('C'.$row)->getValue().'"'.","
								.'"'.$worksheet->getCell('D'.$row)->getValue().'"'.","
								.'"'.$worksheet->getCell('E'.$row)->getValue().'"'.","
								.'"'.$worksheet->getCell('F'.$row)->getValue().'"'.","
								.'"'.$worksheet->getCell('G'.$row)->getValue().'"';


			$sql = "INSERT INTO rep_sucre (".$campos.") VALUES (".$values.")";
			if(mysql_query($sql, $conn_registro)){
				echo $row."<br>";
			}
			else{
				echo $sql."<br>";
				echo $row."<br>";	
		}
	}
?>