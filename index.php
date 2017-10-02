<?php require_once('Connections/ConexionCotizador.php'); ?>
<?php
if($ConexionCotizador){
	echo "Funciona";
	}
else{
	echo "No funciona";
	}	
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

mysqli_select_db($ConexionCotizador,$database_ConexionCotizador);
$query_MostrarMarcas = "SELECT * FROM marca";
$MostrarMarcas = mysqli_query($ConexionCotizador, $query_MostrarMarcas) or die(mysqli_error());
$row_MostrarMarcas = mysqli_fetch_assoc($MostrarMarcas);
$totalRows_MostrarMarcas = mysqli_num_rows($MostrarMarcas);
var_dump($ConexionCotizador);
mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
$query_MostrarTiendas = "SELECT * FROM tienda";
$MostrarTiendas = mysqli_query($ConexionCotizador, $query_MostrarTiendas) or die(mysqli_error());
$row_MostrarTiendas = mysqli_fetch_assoc($MostrarTiendas);
$totalRows_MostrarTiendas = mysqli_num_rows($MostrarTiendas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CotizPhone</title>
<link rel="stylesheet" type="text/css" href="estilos/estilo.css" />
<link rel="stylesheet" type="text/css" href="estilos/menu.css" />
<link rel="stylesheet" type="text/css" href="estilos/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="scripts/buscar_ajax.js"></script>
<script src="scripts/funciones.js"></script>

</head>

<body>
<div class="header" id="cabecera-titulo"><img src="imagenes/logo/logo.PNG" width="140" height="152" style="position:relative; left:45%;"  /></div>  
    <div class="header" id="cabecera-busqueda">
    <div id="Contenido">
    	Buscar tu móvil al mejor precio
    <br />    
     <form id="BusqText" name="BusqText" method="post" >   
      <input type="text" id="celular" name="celular" size="50" onKeyUp="recuperardatosPalabra()"/>
      <input id="busqueda" value="Buscar" name="busqueda" type="button"  />
      </form>
 	</div>
    </div>
    <div id="ResultadosAJAX">
    	
    </div>
<div id="ZonaCentral">    

<div class="sidenav" id="BusqAvanzada">
  <h4>Búsqueda Avanzada</h4>
  <form action="" id="BusAvan" name="BusAvan" method="post">
  	<div id="menu" class="vertical-menu">
    	<ul>
        	<li class="nivel1"><div id="opcion"  class="nivel1">Sistema Operativo</div>
            	<ul>
                	<li>
                    	<div id="opcion">
                    		 <input name="so" type="checkbox" value="'android'" /> Android
                    	</div>
                    </li>
                	<li>
                    	<div id="opcion">
                    		 <input name="so" type="checkbox" value="'ios'" /> iOS
                    	</div>
                    </li>
                	<li>
                    	<div id="opcion">
                    		 <input name="so" type="checkbox" value="'winphone'" /> Windows Phone
                    	</div>
                    </li>                                        
                </ul>
            </li>
            <li class="nivel1">
            	<div id="opcion" class="nivel1"> Marca </div>
                <ul>
                	<?php do { ?>
                	  <li>
                	    <div class="opcion"> 
                	      <input name="marca"  type="checkbox" value="<?php echo "'".$row_MostrarMarcas['ID_MARCA']."'"  ?>" /> <?php echo $row_MostrarMarcas['ID_MARCA'];  ?>
              	      </div>
              	    </li>
                	  <?php } while ($row_MostrarMarcas = mysqli_fetch_assoc($MostrarMarcas)); ?>
                </ul>
            </li>
            <li class="nivel1">
            	<div id="opcion" class="nivel1">
                Disponibilidad en
              </div>
                <ul>
  <?php do { ?>
    <li>
      <div class="opcion"> 
        <input name="tienda"  type="checkbox" value="<?php echo "'".$row_MostrarTiendas['NOMBRE_TIENDA']."'"; ?>" /> <?php echo $row_MostrarTiendas['NOMBRE_TIENDA']; ?>
        </div>
    </li>
                    <?php } while ($row_MostrarTiendas = mysqli_fetch_assoc($MostrarTiendas)); ?>
              </ul>
                    
          </li>                        
        </ul>
    </div>
    <div id="ContenerBoton">
<input  id="BotonBusqAvan" name="BotonBusqAvan" value="Buscar" type="button" />
</div>    
  </form>
</div>
	<div id="PanelPrincipal">
		<div id="PanelMoviles">
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
mysqli_free_result($MostrarMarcas);

mysqli_free_result($MostrarTiendas);
?>
