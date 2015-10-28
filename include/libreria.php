<?php
function Moneda($cantidad,$divisa='MXN')
{
	switch ($divisa)
	{
		case 'MXN': { $simbolo = '$'; break; }
		case 'USD': { $simbolo = 'USD $'; break; }
	}
	$resultado = $simbolo.' '.number_format($cantidad,2);
	return $resultado;
}

function Limpia($val)
{
	if (get_magic_quotes_gpc())
	{
		$val = stripslashes($val);
	}
	$f = (function_exists('mysql_real_escape_string')) ? "mysql_real_escape_string" : ((function_exists('mysql_escape_string')) ? "mysql_escape_string" : "addslashes");
	return (!is_numeric($val)) ? "'".$f($val)."'" : $val;
}

function Fecha($fecha)
{
	$year = substr($fecha,0,4);
	$month = substr($fecha,5,2);
	$day = substr($fecha,8,2);
	switch ($month)
	{
		case "01": {$month = "Enero";	break; }
		case "02": {$month = "Febrero";	break; }
		case "03": {$month = "Marzo";	break; }
		case "04": {$month = "Abril";	break; }
		case "05": {$month = "Mayo";	break; }
		case "06": {$month = "Junio";	break; }
		case "07": {$month = "Julio";	break; }
		case "08": {$month = "Agosto";	break; }
		case "09": {$month = "Septiembre";	break; }
		case "10": {$month = "Octubre";	break; }
		case "11": {$month = "Noviembre";	break; }
		case "12": {$month = "Diciembre";	break; }
	}
	$resultado = $day." de ".$month." de ".$year;
	return $resultado;
}

function Alerta($texto,$destino)
{
	echo '<script type="text/javascript">';
	echo 'alert("'.$texto.'");';
	if ($destino <> "")
	{
		echo 'window.location = "'.$destino.'";';
	}
	else
	{
		echo 'history.go(-1);';
	}
	echo '</script>';
}

function ReDimensionaImagen($imgOriginal,$imgRedimensionada,$alto,$ancho,$directorio)
{
	$infoImagen = getimagesize($directorio.$imgOriginal);
	$altoOr = $infoImagen[1];
	$anchoOr = $infoImagen[0];
	$tipoImagenOr = $infoImagen[2];
 
	if($anchoOr > $ancho or $altoOr > $alto)
	{
		if(($altoOr - $alto) > ($anchoOr - $ancho))
		{
			$ancho = round($anchoOr * $alto / $altoOr,0) ;    
		}
		else
		{
			$alto = round($altoOr * $ancho / $anchoOr,0);  
		}
	}
	else
	{
		$alto = $altoOr;
		$ancho = $anchoOr;
	}
 
	switch ($tipoImagenOr)
	{
		case 1:
		{
			$imgNueva = imagecreatetruecolor($ancho,$alto);
			$imgVieja = imagecreatefromgif($directorio.$imgOriginal);
			imagecopyresampled($imgNueva, $imgVieja, 0, 0, 0, 0, $ancho, $alto, $anchoOr, $altoOr);
			if (!imagegif($imgNueva, $directorio.$imgRedimensionada)) return false;
			break;
		}
		case 2:
		{
			$imgNueva = imagecreatetruecolor($ancho, $alto);
			$imgVieja = imagecreatefromjpeg($directorio.$imgOriginal);
			imagecopyresampled($imgNueva, $imgVieja, 0, 0, 0, 0, $ancho, $alto, $anchoOr, $altoOr);
			if (!imagejpeg($imgNueva, $directorio.$imgRedimensionada)) return false;
			break;
		}
		case 3:
		{
			$imgNueva = imagecreatetruecolor($ancho, $alto);
			$imgVieja = imagecreatefrompng($directorio.$imgOriginal);
			imagecopyresampled($imgNueva, $imgVieja, 0, 0, 0, 0, $ancho, $alto, $anchoOr, $altoOr);
			if (!imagepng($imgNueva, $directorio.$imgRedimensionada)) return false;
			break;
		}
	}
	return true;
}

function FURL($string)
{
	$string = trim(utf8_encode($string));
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
	
	$string = str_replace(' ', '-', $string);
 
    $string = str_replace(
        array("\\", "¨", "º", "~", "#",
			"@", "|", "!", "\"", "·",
			"$", "%", "&", "/", "(",
			")", "?", "'", "¡", "¿",
			"[", "^", "`", "]", "+",
			"}", "{", "¨", "´", ">",
			"<", ";", ",", ":", "."),
        '',
        $string
    );
 
    return strtolower($string);
}
?>