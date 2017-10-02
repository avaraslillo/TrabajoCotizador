<?php require_once('Connections/ConexionCotizador.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType,  $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
	mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
	$query_BuscarAJAX = "SELECT * FROM movil WHERE MODELO LIKE '%".$_GET['palabra']."%'
ORDER BY ID_MOVIL ASC";
	$BuscarAJAX = mysqli_query( 	$ConexionCotizador, $query_BuscarAJAX) or die(mysqli_error($BuscarAJAX));
	$row_BuscarAJAX = mysqli_fetch_assoc($BuscarAJAX);
	$totalRows_BuscarAJAX = mysqli_num_rows($BuscarAJAX);
	do{
	
		print ($row_BuscarAJAX['MODELO']."<br>");
	} while ($row_BuscarAJAX = mysqli_fetch_assoc($BuscarAJAX));
}
?>
<?php
mysqli_free_result($BuscarAJAX);
?>











