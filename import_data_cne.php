<?php

	require_once 'php_excel/Classes/PHPExcel.php';
	require_once('Connections/conn_registro.php');

	$tpm_file = "carnet_patria3.xlsx";
	$excelReader = PHPExcel_IOFactory::createReaderForFile($tpm_file);
	$excelObj = $excelReader->load($tpm_file);
	$worksheet = $excelObj->getSheet(0);
	$lastRow = $worksheet->getHighestRow();

	mysql_select_db($database_conn_registro, $conn_registro);

	for ($row = 1; $row <= $lastRow; $row++) {	

			$nombre = $worksheet->getCell('I'.$row)->getValue()." ".$worksheet->getCell('J'.$row)->getValue()." ".$worksheet->getCell('K'.$row)->getValue()." ".$worksheet->getCell('L'.$row)->getValue();

			$campos = "estado, municipio, parroquia, sector_barrio,urbanismo,bloque,casa,calle,nombre_completo,nac,cedula,genero,movil,telefono";
			$values =    '"'.$worksheet->getCell('A'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('B'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('C'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('D'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('E'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('F'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('G'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('H'.$row)->getValue().'"'.","
						.'"'.$nombre.'"'.","
						.'"'.$worksheet->getCell('M'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('N'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('O'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('P'.$row)->getValue().'"'.","
						.'"'.$worksheet->getCell('Q'.$row)->getValue().'"';


			$sql = "INSERT INTO carnet_patria (".$campos.") VALUES (".$values.")";
			if(mysql_query($sql, $conn_registro)){
				echo $row."<br>";
			}
			else{
				echo $sql."<br>";
				echo $row."<br>";	
			}
	}
?>