<?php

namespace App\Helpers;


class miPrint
{

	public static function printPanel($contenido, $titulo)
	{

		$temp = '<div class="panel panel-default">
			  <div class="panel-heading coPanel" >' . $titulo . '</div>
			  <div class="panel-body" style="display:none">
			    ' . $contenido . '
			  </div>
			</div>';
		return $temp;
	}

	public static function fechaAEspanol($fechaYmd, $sinDia)
	{
		$resul = "";
		$FechaStamp  = strtotime($fechaYmd);
		$ano = date('Y', $FechaStamp);
		$mes = date('n', $FechaStamp);
		$dia = date('d', $FechaStamp);
		$diasemana = date('w', $FechaStamp);
		$diassemanaN = array(
			"Domingo", "Lunes", "Martes", "Miércoles",
			"Jueves", "Viernes", "Sábado"
		);
		$mesesN = array(
			1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
			"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
		);

		if ($sinDia) {
			$resul =   $mesesN[$mes] . " de $ano";
		} else {
			$resul = $diassemanaN[$diasemana] . ", $dia de " . $mesesN[$mes] . " de $ano";
		}
		return $resul;
	}

	public static function printLink($descripcion, $ruta, $target)
	{
		$temp = '<a class="btn btn-info" target=' . $target . '  href=/' . $ruta . ' >' . $descripcion . '</a> ';
		return  $temp;
	}

	public static function printInputBoostrap($anchoBoostrap, $tipo, $class, $id, $textoLabel, $placeHolder, $value)
	{
		$temp = ' <div class="' . $anchoBoostrap . '">
                <div class="form-group">
                  <label for="' . $id . '">' . $textoLabel . '</label>';

		if ($tipo == "text") {
			$temp .= '         <input type="text" class="' . $class . '" id="' . $id . '" name="' . $id . '" maxlength=""
                  placeholder="' . $placeHolder . '" value="' . $value . '"  >';
		}

		if ($tipo == "date") {
			$temp .= '         <input type="date" class="' . $class . '" id="' . $id . '" name="' . $id . '" maxlength=""
                  placeholder="' . $placeHolder . '" value="' . $value . '"  >';
		}



		$temp .= '        </div>
              </div>';
		return  $temp;
	}

	public static function printMensaje($msg, $tipo)
	{
		$TempMensaje = '<div class="alert alert-' . $tipo . ' alert-dismissible fade show" role="alert">
                        ' . $msg . '
					  	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="float: right;" >&times;</span></button>
					</div>';
		echo $TempMensaje;
	}

	public static function printDebugPanel($dato, $descripcion, $ejecExit, $mostrarEnPagina505)
	{


		// habilitar el logue (por archivo) en en casos que se determine por configuracuon
		// habilitar mostar o no los mensajes en caso que el usuario se logue en modo depuracion

		// por default debería ir a una 404 con la descripcion  de mensaje, AGREGAR UN PARAMETRO MAS PARA INDICAR SI ES UN 
		//ERROR QUE REQUIERE REDIRECCION Y 404
		echo '<div style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #a94442; background-color: #f2dede; border-color: #ebccd1;">';
		echo "<pre>";
		$tmpresul = "<h2>" .	$descripcion . ": </h2>";

		echo $tmpresul;
		echo "<pre style='font-size: 13px;border-color: #c3ddfb;background-color: #79797911;border-style: outset;' >";

		if (is_array($dato)) {
			print_r($dato);
		} elseif (is_object($dato)) {
			$tmparray = get_object_vars($dato);
			print_r($tmparray);
			var_dump($dato);
		} else {
			echo $dato;
		}

		echo "</pre>";

		echo "</pre>";
		echo "</div>";

		if ($mostrarEnPagina505 == true) {
			header('location: /controllers/errores.php?msg=' . $dato);
		}

		if ($ejecExit == true) {
			exit(1);
		}
	}

	public static function arrayAsocToTable($array)
	{

		$temp = "";
		if (!empty($array)) {
			$temp = "<div class='table-responsive' >";
			$temp .= "<table class='table table-bordered'>";
			//printDebugPanel($array, "array", false);
			foreach ($array as $r => $row) {

				$temp .= "<tr>";

				foreach ($row as $c => $col) {
					$temp .= "<td class='grow'>";
					$temp .= $array[$r][$c];
					$temp .= "</td>";
				}
				$temp .= "</tr>";
			}
			$temp .= "</table>";
			$temp .= "</div>";
		}
		return $temp;
	}

	public static function arrayToTable($array)
	{

		$temp = "";

		if (!empty($array)) {
			//$temp = "<div class='table-responsive' >";

			$temp .= '<table class="table table-bordered table-responsive">';

			$cols = array_keys($array[0]);
			$temp .= ' <thead> <tr>';
			foreach ($cols as $col) $temp .= '<th>' . $col . '</th>';
			$temp .= '</tr></thead>';
			$temp .= '<tbody>';
			foreach ($array as $i => $item) {
				$temp .= '<tr>';
				foreach ($cols as $col) $temp .= '<td>' . $array[$i][$col] . '</td>';
				$temp .= '</tr>';
			}
			$temp .= '</tbody>';
			$temp .= '</table>';


			//$temp .= "</div>";       
		}
		return $temp;
	}

	public static function leerCSV($archivo)
	{
		//xdebug_break();
		$resul;
		$row = 1;
		if (($handle = fopen($archivo, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				//echo "<p> $num fields in line $row: <br /></p>\n";
				foreach ($data as $k => $value) {
					$resul[$row][$k] = $value;
				}
				$row++;
				/*for ($c=0; $c < $num; $c++) {
 					echo $data[$c] . "<br />\n";
 					}**/
			}
			fclose($handle);
		}

		return $resul;
	}

	public static function escribirCSV($array, $archivo, $tieneCabecera)
	{

		ob_clean();
		/*
 	    header("Content-type: text/csv");
 	    **/
		$cols = array();
		if ($tieneCabecera == true) {
			//con cabecera 	        
			$cols = array_keys($array[0]);
			//foreach ($cols as $col) $tempCabecera .=  $col . '\t'; 	         	         	      
		}

		header("Content-Disposition: attachment; filename=$archivo");
		header("Content-Type: application/vnd.ms-excel;");
		header("Pragma: no-cache");
		header("Expires: 0");
		$out = fopen("php://output", 'w');

		if ($tieneCabecera == true) {
			fputcsv($out, $cols, "\t");
		}

		foreach ($array as $data) {
			fputcsv($out, $data, "\t");
		}

		fclose($out);
	}

	public static function escribirCSVSinOutput($array, $archivo, $tieneCabecera)
	{

		/*
 	    header("Content-type: text/csv");
 	    **/
		if (count($array) == 0) {
			return "";
		}

		$cols = array();
		if ($tieneCabecera == true) {
			//con cabecera 	        
			$cols = array_keys($array[0]);
			//foreach ($cols as $col) $tempCabecera .=  $col . '\t'; 	         	         	      
		}

		if (!file_exists(ROOT_PATH . '/download_data/')) {
			mkdir(ROOT_PATH . '/download_data/', 0777, true);
		}

		$logPath = ROOT_PATH . '/download_data/' . $archivo;

		$out = fopen($logPath, 'w');

		if ($tieneCabecera == true) {
			fputcsv($out, $cols, "\t");
		}

		foreach ($array as $data) {
			fputcsv($out, $data, "\t");
		}

		fclose($out);
	}

	public static function randomColor()
	{
		$chars = 'ABCDEF0123456789';
		$color = '#';
		for ($i = 0; $i < 6; $i++) {
			$color .= $chars[rand(0, strlen($chars) - 1)];
		}
		return $color;
	}

	public static function traerMesNombrePorNumero($mes)
	{
		$tmparray =  array(
			1 => "Enero",
			2 => "Febrero",
			3 => "Marzo",
			4 => "Abril",
			5 => "Mayo",
			6 => "Junio",
			7 => "Julio",
			8 => "Agosto",
			9 => "Septiembre",
			10 => "Octubre",
			11 => "Noviembre",
			12 => "Diciembre",
		);
		return $tmparray[$mes];
	}

	public static function traerColorPorOrden($orden)
	{

		$tmparray1 =  array(
			1 => "#4dc9f6",
			2 => "#f67019",
			3 => "#f53794",
			4 => "#537bc4",
			5 => "#acc236",
			6 => "#166a8f",
			7 => "#00a950",
			8 => "#58595b",
			9 => "#8549ba",
			10 => "#4A2634",
			11 => "#D7351C",
			12 => "#EEDF08",
			13 => "#B09723",
			14 => "#4A2634",
			15 => "#0F9139",
			16 => "#E3C4D3",
			17 => "#112F53",
			18 => "#DA0D40",
			19 => "#BED271",
			20 => "#0A5E3A"

		);



		$tmparray2 =  array(
			1 => "#D06735",
			2 => "#9AC542",
			3 => "#2D91F5",
			4 => "#EDE433",
			5 => "#E78E3D",
			6 => "#DF897C",
			7 => "#6E5EF5",
			8 => "#5E91EC",
			9 => "#78F9FA",
			10 => "#6AB544",
			11 => "#C73533",
			12 => "#EEDF08"
		);

		$tmparray = $tmparray2;

		if ($orden == 0) {
			return $tmparray;
		} else {
			if ($orden < 1 || $orden > 12) {
				return "#ffffff";
			} else {
				return $tmparray[$orden];
			}
		}
	}

	public static function traerColorPorCentroAlmacen($centroalmacen)
	{


		$tmpColorTexot =  array(
			"SA01-7003" => ["Administración", "DE6B48"],
			"SA01-7010" => ["Depósito Central", "E5B181"],
			"SA02-9012" => ["Santa Clara Quil", "F4B9B2"],
			"SA02-9022" => ["Santa Clara Vare", "DAEDBD"],
			"SA03-0030" => ["Sec Avellaneda", "7DBBC3"],
			"SA03-9032" => ["Policli Reg Ave", "BA1200"],
			"SA04-0040" => ["Sec Bahia Blanca", "031927"],
			"SA04-0080" => ["Sec Campana", "9DD1F1"],
			"SA04-0110" => ["Sec Lujan", "508AA8"],
			"SA04-0270" => ["Sec Chivilcoy", "C8E0F4"],
			"SA04-0420" => ["Sec Junin", "FAFAFA"],
			"SA04-0470" => ["Sec Mar del Plat", "DB5461"],
			"SA04-0510" => ["Sec Mercedes", "721817"],
			"SA04-0530" => ["Sec Moron", "FA9F42"],
			"SA04-0550" => ["Sec 9 de Julio", "2B4162"],
			"SA04-0600" => ["Sec Pergamino", "0B6E4F"],
			"SA04-0820" => ["Sec San Miguel", "E0E0E2"],
			"SA04-0920" => ["Sec Tandil", "3F403F"],
			"SA04-0940" => ["Sec Trenque Lauq", "475841"],
			"SA04-0970" => ["Sec Vicent Lopez", "81C14B"],
			"SA04-1310" => ["Sec Bragado", "ECBA82"],
			"SA04-1460" => ["Sec 3 de Feb", "FBB02D"],
			"SA04-8011" => ["Poli Ciudadela", "5C8001"],
			"SA04-8021" => ["Poli Merlo", "7CB518"],
			"SA04-8031" => ["Policon San Mig", "F3DE2C"],
			"SA04-8041" => ["Policon Grand Bo", "FB6107"],
			"SA04-8051" => ["Policon Vice Lop", "3F88C5"],
			"SA04-8061" => ["Policon Caseros", "A2AEBB"],
			"SA04-8072" => ["Cli Evita de Hae", "FFBA08"],
			"SA04-8081" => ["Poli Villa Rosa", "D00000"],
			"SA04-9042" => ["Policli Vandor", "1C3144"],
			"SA04-9052" => ["San Carlos Miner", "DD403A"],
			"SA05-0800" => ["Sec San Martin", "3E363F"],
			"SA05-9062" => ["San San Martin", "FFFCE8"],
			"SA06-7003" => ["General", "697A21"],
			"SA07-7003" => ["General", "B8B42D"],
			"SA08-9072" => ["Cli SC Mendoza", "8DDBE0"],
			"SA09-0090" => ["Sec Cañada de Go", "D3FFE9"],
			"SA09-0650" => ["Sec Rafaela", "9BC4BC"],
			"SA09-0720" => ["Sec Rosario", "697A21"],
			"SA09-0770" => ["Sec El Trebol", "090909"],
			"SA09-0800" => ["Sec Firmat", "ACBED8"],
			"SA09-0960" => ["Sec Venado Tuert", "E8EBF7"],
			"SA09-1810" => ["Sec Las Parejas", "9BC4BC"],
			"SA09-8121" => ["Poli Venado Tuer", "697A21"],
			"SA09-9082" => ["San Rosendo Garc", "DE1A1A"],
			"SA10-0500" => ["Sec Mendoza", "EF5B5B"],
			"SA10-0520" => ["Sec Villa Merced", "20A39E"],
			"SA10-0790" => ["Sec San Luis", "9BC4BC"],
			"SA10-0850" => ["Sec San Rafael", "697A21"],
			"SA10-8091" => ["Poli Mendoza", "FFBA49"],
			"SA10-9112" => ["Cli Santa Clara", "EF5B5B"],
			"SA11-0490" => ["Sec Matanza", "747274"],
			"SA11-8101" => ["Poli Isidro Casa", "9BC4BC"],
			"SA11-9122" => ["Policli Regi Eva", "7C90A0"],
			"SA11-9132" => ["Cli S Clara Just", "4E5166"],
			"SA11-9192" => ["Sta Clara Ramos", "EF5B5B"],
			"SA12-0780" => ["Sec San Juan", "6F584B"],
			"SA12-9142" => ["Cli S Clara Juan", "9BC4BC"],
			"SA13-9152" => ["Cli S C Don Torc", "48ACF0"],
			"SA14-7003" => ["General", "343F3E"],
			"SA15-9162" => ["Soc Esp S M Mend", "255C99"],
			"SA16-9172" => ["San Ramón Cereij", "9BC4BC"],
			"SA17-7003" => ["Deposito Serca", "262626"],
			"SA17-A087" => ["GEI 087 A2-26", "B3001B"],
			"SA17-A088" => ["GEI 088 P-24", "36C9C6"],
			"SA17-A620" => ["IEU 620 A3-30", "E6EBE0"],
			"SA17-A631" => ["HIX 631 T-14", "9BC4BC"],
			"SA17-A675" => ["KOW 675 A4-32", "F4F1BB"],
			"SA17-A996" => ["OPZ 996 A1-34", "ED6A5A"],
			"SA18-0100" => ["Sec Capital", "6E675F"],
			"SA18-0450" => ["Sec Bell Ville", "EDEBD7"],
			"SA18-0680" => ["Sec Rio Cuarto", "9BC4BC"],
			"SA18-0760" => ["Sec San Francisc", "E3B23C"],
			"SA18-0830" => ["Sec Tucuman", "423E37"],
			"SA18-1010" => ["Sec Villa Maria", "FE5F00"],
			"SA18-1690" => ["Sec La Rioja", "FF9B71"],
			"SA18-2000" => ["Sec Catamarca", "FFFD82"],
			"SA18-7003" => ["Policlinico Cent", "2D3047"],
			"SA18-7011" => ["Depósito Central", "ED217C"],
			"SA18-8111" => ["Policon Tucuman", "1B998B"],
			"SA18-9192" => ["Clinica Rucci", "8F2D56"],
			"SA19-7003" => ["General", "D81159"],
			"SA20-7003" => ["Prepaga Central", "FFBC42"],
			"SA21-7003" => ["General", "0496FF"],
			"SA22-7003" => ["General", "006BA6"],
			"SA23-0130" => ["Sec Casilda", "111D4A"],
			"SA23-9100" => ["Sec Rafaela", "8380B6"],
			"SA23-9910" => ["San Julian Moren", "C2CAE8"]
		);

		return $tmpColorTexot[$centroalmacen];
	}

	public static function traerColorPorFinanciador($financiador)
	{

		$tmpColor =  array(

			"BASA" => "#445E93",
			"O. SOCIAL" => "#7EB2DD",
			"OTROS" => "#F93943",
			"PAMI" => "#FCB0B3",
			"UOM" => "#FCECC9"

		);
		return $tmpColor[$financiador];
	}

	public static function escribirArchivoTemporal($nombre)
	{


		$fecha = new DateTime();
		$tmpfecha =  $fecha->format('Y_m_d_H_i_s');
		$formatoDeCarpeta = urlEncode(date("Y_m")) . "/";

		if (!file_exists(ROOT_PATH . '/files_data/' . $formatoDeCarpeta)) {
			mkdir(ROOT_PATH . '/files_data/' . $formatoDeCarpeta, 0777, true);
		}

		$archivo = ROOT_PATH . '/files_data/' . $formatoDeCarpeta . uniqid() . "_" . $nombre;

		touch($archivo);

		return $archivo;
	}



	public static function callApiSAP($method, $url, $data)
	{
		$curl = curl_init();

		switch ($method) {
			case "POST":
				curl_setopt($curl, CURLOPT_POST, true);
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			default:
				//pasa la info por query string
				if ($data)
					$url = sprintf("%s?%s", $url, http_build_query($data));
		}


		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

		// EXECUTE:
		try {

			$result = curl_exec($curl);
			if (!$result) {
				throw new Exception("No se devolvieron resultados ");
			}

			$curl_info_arr =  curl_getinfo($curl);

			if ($curl_info_arr["http_code"] != "200") {

				miPrint::printDebugPanel(curl_getinfo($curl), "Error en llamada por curl -- info", false, false);
				throw new Exception("Error en la llamada al servicio, código (" . $curl_info_arr["http_code"] . ") : ");
			}
		} catch (Exception $e) {
			throw $e;
		}

		curl_close($curl);
		return $result;
	}

	public static function formatMonedaADecimalMysql($textoMoneda)
	{

		$formatoDecimal = $textoMoneda;
		$formatoDecimal =  str_replace("$", "", $formatoDecimal);
		$formatoDecimal =  str_replace(" ", "", $formatoDecimal);
		$formatoDecimal =  str_replace(".", "", $formatoDecimal);
		$formatoDecimal =  str_replace(",", ".", $formatoDecimal);
		return $formatoDecimal;
	}

	public static function formatMonedaDecimalParaVista($textoMoneda)
	{
		return number_format($textoMoneda, 2, ',', '.');
	}

	public static function logEnArchivos($data, $archivoNombre)
	{

		if (!file_exists(public_path() . '/logs_data/')) {
			mkdir(public_path() . '/logs_data/', 0777, true);
		}

		$logPath = public_path() . '/logs_data/' . $archivoNombre . ".txt";
		$mode = (!file_exists($logPath)) ? 'w' : 'a';
		$logfile = fopen($logPath, $mode);
		fwrite($logfile, "\r\n" . date("d/m/Y H:i:s") . " >> " . $data);
		fclose($logfile);
	}

	public static function hexToStr($hex)
	{
		$string = '';
		for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
			$string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
		}
		return $string;
	}

	public static function dd($ob, $tit)
	{
		miPrint::printDebugPanel($ob, $tit, false, false);
	}

	public static function jsonArrayToTable($data)
	{
		$table =  "";
		$table .= '<table class="table table-bordered table-sm" style="font-size:12px"  width="400px">';
		foreach ($data as $key => $value) {
			$table .= '<tr valign="top">';
			if (!is_numeric($key)) {
				$table .= ' <td>
                                <strong>' . $key . ':</strong>
                            </td>
                            <td>';
			} else {
				$table .= '<td colspan="2">';
			}
			if (is_object($value) || is_array($value)) {
				$table .= miPrint::jsonArrayToTable($value);
			} else {
				$table .= $value;
			}
			$table .= '</td></tr>';
		}
		$table .= '</table>';
		return $table;
	}

	public static function queryMysqlDesdeEnv($sql,$servername,$username, $password, $dbname )
	{		
		$conn = new \mysqli($servername, $username, $password, $dbname);		
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}		
		$result = $conn->query($sql);
		$resulados = [];
		if ($result->num_rows > 0) {			
			while ($row = $result->fetch_assoc()) {				
				$resulados[] = $row; 
			}
		} else {			
		}
		$conn->close();
		return $resulados;
	}
}
