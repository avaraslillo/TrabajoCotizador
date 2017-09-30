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
if($_GET['palabra']==''){
	print('');	
}
else{	
	mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
	$query_BuscarAJAX = "SELECT * FROM movil WHERE MODELO LIKE '%".$_GET['palabra']."%'
ORDER BY ID_MOVIL ASC";
	$BuscarAJAX = mysql_query($query_BuscarAJAX, 	$ConexionCotizador) or die(mysql_error());
	$row_BuscarAJAX = mysql_fetch_assoc($BuscarAJAX);
	$totalRows_BuscarAJAX = mysql_num_rows($BuscarAJAX);
	do{
	
		print urlencode("<a href=mostrar_movil.php?IDmovil=".$row_BuscarAJAX['ID_MOVIL'].">".$row_BuscarAJAX['MODELO']."</a><br>");
	} while ($row_BuscarAJAX = mysql_fetch_assoc($BuscarAJAX));
}
?>
<?php
mysql_free_result($BuscarAJAX);
?>











