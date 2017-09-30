<?php require_once('Connections/ConexionCotizador.php'); ?>
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

?>
<?php
if($_POST['so']=="" && $_POST['marca']=="" && $_POST['tienda']==""){
	print ('');
	}
else{
$buscarSO="";
if(isset($_POST['so']) && $_POST['so']!=""){
	$ar_SO=$_POST['so'];
	$buscarSO=" AND movil.SISTEMA_OPERATIVO IN (";
	$buscarSO=$buscarSO.$ar_SO;
	$buscarSO=$buscarSO.")";
}
$buscarMarca="";
if(isset($_POST['marca']) && $_POST['marca']!=""){
	$ar_Marca=$_POST['marca'];
	$buscarMarca=" AND movil.MARCA IN (";
	$buscarMarca=$buscarMarca.$ar_Marca;
	$buscarMarca=$buscarMarca.")";
}

$buscarTienda="";
if(isset($_POST['tienda']) && $_POST['tienda']!=""){
	$ar_Tienda=$_POST['tienda'];
	$buscarTienda=" AND tienda.NOMBRE_TIENDA IN (";	
		$buscarTienda=$buscarTienda.$ar_Tienda;
			$buscarTienda=$buscarTienda.") AND relacion_tm.ID_MOVIL=movil.ID_MOVIL AND tienda.ID_TIENDA=relacion_tm.ID_TIENDA";		
}
//echo $buscarMarca;
$consulta=$buscarSO.$buscarMarca.$buscarTienda."  AND imagen.ID_MOVIL=movil.ID_MOVIL";


mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
$query_BuscarAvanzada = "SELECT movil.MODELO, imagen.RUTA_IMAGEN, movil.ID_MOVIL FROM movil, imagen, relacion_tm, tienda WHERE  imagen.ORDEN_IMAGEN='1'".$consulta." GROUP BY movil.ID_MOVIL";
$BuscarAvanzada = mysql_query($query_BuscarAvanzada, $ConexionCotizador) or die(mysql_error());
$row_BuscarAvanzada = mysql_fetch_assoc($BuscarAvanzada);
$totalRows_BuscarAvanzada = mysql_num_rows($BuscarAvanzada);
	if($totalRows_BuscarAvanzada==0){
	print ("<h3 style='padding-left:10px; text-align:center;'>NO HAY RESULTADOS. INTENTE CON OTROS CRITERIOS DE BÚSQUEDA</h3>");
	}
else{	
	do{

	print ('<div id="Resultado">
<a href="mostrar_movil.php?IDmovil='.$row_BuscarAvanzada['ID_MOVIL'].'"><img src="'.$row_BuscarAvanzada['RUTA_IMAGEN'].'" width="60%" height="60%" style="margin:10px 10px 10px 10px; display:block; left: 50%;"/></a>
<br /><span style"text-align:center;">'.$row_BuscarAvanzada['MODELO'].'</span></div>');
	} while ($row_BuscarAvanzada = mysql_fetch_assoc($BuscarAvanzada));
}
?>
<?php

mysql_free_result($BuscarAvanzada);
}
?>
