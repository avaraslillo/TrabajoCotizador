
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

mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
$query_BuscarMoviles = "SELECT movil.ID_MOVIL, movil.MODELO, imagen.RUTA_IMAGEN, imagen.ORDEN_IMAGEN FROM movil, imagen WHERE movil.MODELO LIKE '%".$_GET['palabra']."%'  AND  imagen.ORDEN_IMAGEN='1' AND imagen.ID_MOVIL=movil.ID_MOVIL GROUP BY movil.ID_MOVIL";	
$BuscarMoviles = mysqli_query( $ConexionCotizador, $query_BuscarMoviles) or die(mysqli_error($BuscarMoviles));
$row_BuscarMoviles = mysqli_fetch_assoc($BuscarMoviles);
$totalRows_BuscarMoviles = mysqli_num_rows($BuscarMoviles);
?>
<?php
do{	
	print ('<div id="Resultado">
<a href="mostrar_movil.php?IDmovil='.$row_BuscarMoviles['ID_MOVIL'].'"><img src="'.$row_BuscarMoviles['RUTA_IMAGEN'].'" width="60%" height="60%" style="margin:10px 10px 10px 10px; display:block; left: 50%;"/></a>
<br /><span style"text-align:center;">'.$row_BuscarAvanzada['MODELO'].'</span></div>');
} while ($row_BuscarMoviles = mysqli_fetch_assoc($BuscarMoviles)); 

?>
<?php

mysqli_free_result($BuscarMoviles);
?>
