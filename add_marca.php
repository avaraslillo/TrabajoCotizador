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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO marca (ID_MARCA) VALUES (%s)",
                       GetSQLValueString($_POST['ID_MARCA'], "text"));

  mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
  $Result1 = mysql_query($insertSQL, $ConexionCotizador) or die(mysql_error());
}
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
	<div id="FormAgregarMarca" class="FormAdmin">
      <form action="<?php echo $editFormAction; ?>" method="post" name="FormMarca" id="FormMarca">
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">ID_MARCA:</td>
            <td><input type="text" name="ID_MARCA" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Insertar registro" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
      <p>&nbsp;</p>
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