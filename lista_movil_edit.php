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
mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
$query_ListaMoviles = "SELECT movil.MODELO, imagen.RUTA_IMAGEN, movil.ID_MOVIL FROM movil, imagen WHERE  imagen.ORDEN_IMAGEN='1' AND imagen.ID_MOVIL=movil.ID_MOVIL GROUP BY movil.ID_MOVIL";
$ListaMoviles = mysql_query($query_ListaMoviles, $ConexionCotizador) or die(mysql_error());
$row_ListaMoviles = mysql_fetch_assoc($ListaMoviles);
$totalRows_ListaMoviles = mysql_num_rows($ListaMoviles);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CotizPhone-Administración</title>
<link rel="stylesheet" type="text/css" href="estilos/estiloadmin.css" />
<link rel="stylesheet" type="text/css" href="estilos/menu.css" />
<link rel="stylesheet" type="text/css" href="estilos/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="scripts/funciones.js"></script>
</head>

<body>
<div id="cabecera-admin">
<img src="imagenes/logo/logo.PNG" width="140" height="152" style="position:relative; left:45%;"  /></div>  
</div>
<div id="cabecera-admin2">
</div>
<div id="ZonaCentral">
<div class="sidenav">
<div id="menu" class="vertical-menu">
		<ul>
        <li class="admin"><a href="admin.php">Volver al Home</a></li>
    		<li class="admin"><a href="add_movil.php">Agregar nuevo móvil</a></li>
        	<li class="admin"><a href="lista_movil_edit.php">Modificar información de un móvil</a></li>
        	<li class="admin"><a href="add_marca.php">Agregar nueva marca</a></li>
        	<li class="admin">Eliminar marca</li>        	<li class="admin"><a href="add_tienda.php">Agregar nueva tienda</a> </li>
        	<li class="admin">Eliminar tienda </li>                                       
    	</ul>
    </div>
</div>
<div id="PanelAdmin">
	<div id="ListaMoviles">
 		<?php
			if($totalRows_ListaMoviles==0){
	print ("<h3 style='padding-left:10px; text-align:center;'>NO HAY RESULTADOS</h3>");
	}		

	else{
		do { 
	print ('<div id="Resultado">
<img src="'.$row_ListaMoviles['RUTA_IMAGEN'].'" width="60%" height="60%" />
<br /><span style="position:inherit; left:15%;">'.$row_ListaMoviles['MODELO'].'</span><br /> <span style="float:left; margin-left:20px; "><a href=edit_movil.php?IDMovil='.$row_ListaMoviles['ID_MOVIL'].' style="color:#000;">Editar</a></span> <span style="float:right; margin-right:20px; "><a onclick="return ConfirmarEliminacion();" href="delete_movil.php?IDMovil='.$row_ListaMoviles['ID_MOVIL'].'"style="color:#000;">Eliminar</a></span></div>');
	} while ($row_ListaMoviles = mysql_fetch_assoc($ListaMoviles));
}	

		?>
 
    </div>
</div>            
</div>
   <div id="footer">
  Proyecto de Fin de Grado <br />
  Universidad Europea de Madrid-Ingeniería Civil Informática <br />
  Alex Antonio Varas Lillo-2017
  </div> 
</body>
</html>
<?php
mysql_free_result($MostrarMarcas);

mysql_free_result($ListaMoviles);

mysql_free_result($MostrarMarcas);
?>
