<?
	
	require_once('Connections/conn_registro.php');
	include_once("mpdf/mpdf.php");
	mysql_select_db($database_conn_registro, $conn_registro);

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fecha = $dias[date('w',strtotime("- 6 hour"))]." ".date('d',strtotime("- 6 hour"))." de ".$meses[date('n')-1]. " del ".date('Y');

	$municipio = $_GET['municipio'];
	$extra = "";

	if(!empty($municipio))
	{
		$extra = " and id_mun = ".$municipio;
	}

$data ='
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title></title>
<link rel="stylesheet" type="text/css" href="css/personal.css">
<style type="text/css">
html {
  margin: 0;
}
body {
  font-family: "Arial", serif;
  margin: 20mm 8mm 15mm 8mm;
}

table {     font-family: "Arial", "Lucida Grande", Sans-Serif;
    font-size: 12px;    margin: 45px;     width: 480px; text-align: center;    border-collapse: collapse; }

th {     font-size: 13px;     font-weight: bold;     padding: 8px;
    border-top: 4px solid #aabcfe;    border-bottom: 1px solid black; }

td {    padding: 8px; border-bottom: 1px solid black;
    border-top: 1px solid transparent; }

</style>
</head>
<body>
<script type="text/php"> 
if (isset($pdf))
    {
    $w = $pdf->get_width(); 
	$h = $pdf->get_height(); 
	$font = Font_Metrics::get_font("helvetica", "bold"); 
	$pdf->page_text($w - 120, $h - 40, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font, 9, array(0,0,0));  
    }

</script>  
<img src="imagenes/logo_militante.png" alt="" width="100%" height="100px">
<br>
<br>'.$fecha.'
<br>
<br>			
</header>
	<section>
			<table width="100%" cellpadding="" border="1" cellspacing="">
  			<thead>
  			<tr>
    			<td colspan="12" style="font-size: 15px"><CENTER><strong style="text-decoration: underline;">Registro De Votantes</strong></CENTER></td>
  			</tr>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Nac</th>
		          <th class="text-center">Céd</th>
		          <th class="text-center">Nombre</th>
		          <th class="text-center">Teléfono</th>
		          <th class="text-center">Fecha</th>
		          <th class="text-center">Carnet Patria</th>
		          <th class="text-center">Serial</th>
		          <th class="text-center">Trab.Gobierno</th>
		          <th class="text-center">Posición Trabajo</th>
		          <th class="text-center">Municipio</th>
		          <th class="text-center">Parroquía</th>
				</tr>
			</thead>
			<tbody>';
				$sql = "SELECT *, 

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
		 					WHEN 1 THEN 'Fijo'
		 					WHEN 0 THEN 'Contratado'
		 				end as posicion_trabajo,
					      (SELECT parroquia from parroquias where id_estado = 17 and id_municipio = sim_reg.id_mun and id_parroquia = sim_reg.id_parro) as parroquia,
					      (SELECT municipio from municipios where id_estado = 17 and id_municipio = sim_reg.id_mun) as municipio
					       from sim_reg where id_estado = 17".$extra;
				$res = mysql_query($sql, $conn_registro);
				$conn = 1;
				while ($rs = mysql_fetch_assoc($res))
				{
 					$data.='
 						<tr>
 							<td>'.$conn.'</td>
              <td>'.$rs['nac'].'</td>
              <td>'.$rs['cedula'].'</td>
              <td>'.$rs['nombre'].'</td>
              <td>'.$rs['telefono'].'</td>
              <td>'.$rs['fecha'].'</td>
              <td>'.$rs['carnet_patria'].'</td>
              <td>'.$rs['serial_carnet'].'</td>
              <td>'.$rs['trabaja_gobierno'].'</td>
              <td>'.$rs['posicion_trabajo'].'</td>
              <td>'.$rs['municipio'].'</td>
              <td>'.$rs['parroquia'].'</td>
            </tr>';
            $conn++;
        }
			$data.='	
			</tbody>
			</table>
		</section>
</body>
</html>';
$mpdf = new mPDF('c', 'A4');
$mpdf->setFooter('{PAGENO}');
$mpdf->writeHTML($data);
ini_set("memory_limit","128M");
$mpdf->Output('Registro de Votantes', 'I');

	
?>