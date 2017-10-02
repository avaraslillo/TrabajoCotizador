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
$query_MostrarMarcas = "SELECT * FROM marca";
$MostrarMarcas = mysqli_query($ConexionCotizador, $query_MostrarMarcas) or die(mysqli_error($ConexionCotizador));
$row_MostrarMarcas = mysqli_fetch_assoc($MostrarMarcas);
$totalRows_MostrarMarcas = mysqli_num_rows($MostrarMarcas);

$VARmovil_MostrarMovil = "0";
if (isset($_GET["IDmovil"])) {
  $VARmovil_MostrarMovil = $_GET["IDmovil"];
}
mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
$query_MostrarMovil = sprintf("SELECT * FROM movil WHERE movil.ID_MOVIL=%s", GetSQLValueString($VARmovil_MostrarMovil, "int"));
$MostrarMovil = mysqli_query($ConexionCotizador, $query_MostrarMovil) or die(mysqli_error($ConexionCotizador));
$row_MostrarMovil = mysqli_fetch_assoc($MostrarMovil);
$totalRows_MostrarMovil = mysqli_num_rows($MostrarMovil);

$VARmovil_BuscarImagenes = "0";
if (isset($_GET["IDmovil"])) {
  $VARmovil_BuscarImagenes = $_GET["IDmovil"];
}
mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
$query_BuscarImagenes = sprintf("SELECT * FROM imagen WHERE imagen.ID_MOVIL=%s ORDER BY imagen.ORDEN_IMAGEN", GetSQLValueString($VARmovil_BuscarImagenes, "int"));
$BuscarImagenes = mysqli_query($ConexionCotizador, $query_BuscarImagenes) or die(mysqli_error($ConexionCotizador));
$row_BuscarImagenes = mysqli_fetch_assoc($BuscarImagenes);
$totalRows_BuscarImagenes = mysqli_num_rows($BuscarImagenes);

$VARMovil2_MostrarTM = "0";
if (isset($_GET["IDmovil"])) {
  $VARMovil2_MostrarTM = $_GET["IDmovil"];
}
mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
$query_MostrarTM = sprintf("SELECT relacion_tm.ID_MOVIL, relacion_tm.ID_TIENDA, relacion_tm.ENLACE_PT, relacion_tm.PRECIO_CLP, relacion_tm.PRECIO_EUR, tienda.NOMBRE_TIENDA FROM tienda, relacion_tm WHERE relacion_tm.ID_MOVIL=%s  AND relacion_tm.ID_TIENDA=tienda.ID_TIENDA ORDER BY relacion_tm.PRECIO_CLP ASC", GetSQLValueString($VARMovil2_MostrarTM, "int", $ConexionCotizador));
$MostrarTM = mysqli_query($ConexionCotizador, $query_MostrarTM) or die(mysqli_error());
$row_MostrarTM = mysqli_fetch_assoc($MostrarTM);
$totalRows_MostrarTM = mysqli_num_rows($MostrarTM);

mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
$query_MostrarTiendas = "SELECT * FROM tienda";
$MostrarTiendas = mysqli_query($ConexionCotizador, $query_MostrarTiendas) or die(mysqli_error($ConexionCotizador));
$row_MostrarTiendas = mysqli_fetch_assoc($MostrarTiendas);
$totalRows_MostrarTiendas = mysqli_num_rows($MostrarTiendas);

$VARmovil_MostrarImagen1 = "0";
if (isset($_GET['IDmovil'])) {
  $VARmovil_MostrarImagen1 = $_GET['IDmovil'];
}
mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
$query_MostrarImagen1 = sprintf("SELECT * FROM imagen WHERE imagen.ID_MOVIL=%s AND imagen.ORDEN_IMAGEN=1", GetSQLValueString($VARmovil_MostrarImagen1, "int"));
$MostrarImagen1 = mysqli_query($ConexionCotizador, $query_MostrarImagen1) or die(mysqli_error($ConexionCotizador));
$row_MostrarImagen1 = mysqli_fetch_assoc($MostrarImagen1);
$totalRows_MostrarImagen1 = mysqli_num_rows($MostrarImagen1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CotizPhone</title>
<link rel="stylesheet" type="text/css" href="estilos/estilo.css" />
<link rel="stylesheet" type="text/css" href="estilos/menu.css" />
<link rel="stylesheet" type="text/css" href="estilos/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="estilos/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="scripts/buscar_ajax.js">
</script>
<script src="scripts/funciones.js"></script>
</head>

<body>
<div class="header" id="cabecera-titulo">
<img src="imagenes/logo/logo.PNG" width="140" height="152" style="position:relative; left:45%;"  />
    <span style="float:right; margin-right:10px;"><a href="index.php">Volver al home</a></span>    
    </div>  
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

  

	<div id="PanelPrincipal">
		<div id="PanelMoviles">

        	<div id="FichaMovil">
        	<div id="ImagenMovil">
            	<div id="ParteSuperior">
            	<a id="ImgEnlace" href="<?php echo $row_MostrarImagen1['RUTA_IMAGEN']; ?>" rel="prettyPhoto[portfolio_galeria]" ><img id="ImagenGrande" src="<?php echo $row_MostrarImagen1['RUTA_IMAGEN']; ?>" width="70%" height="70%" /></a>
             </div>   
            <div id="Galeria">
            	<?php do { ?>
            	  <div id="ImagenPequena"> <a onclick="<?php echo "cambiarImagen('".$row_BuscarImagenes['RUTA_IMAGEN']."');"?>" rel="prettyPhoto[portfolio_galeria]" ><img src="<?php echo $row_BuscarImagenes['RUTA_IMAGEN']; ?>" width="90%" height="90%" /></a> </div>
            	  <?php } while ($row_BuscarImagenes = mysqli_fetch_assoc($BuscarImagenes)); ?>
            </div>    
            </div>
            <div id="DatosMovil">
            	<table border="double">
            	<tr>
                <th scope="row" colspan="2"><h3><?php echo $row_MostrarMovil['MODELO']; ?></h3></th>
                
                </tr>
                <tr> 
                <th scope="row">Marca 
                </th>
                <td>
                <?php echo $row_MostrarMovil['MARCA']; ?>
                </td>                
                </tr>
                <tr> 
                <th scope="row">Sistema operativo   </th> 
                <td>
                <?php echo $row_MostrarMovil['SISTEMA_OPERATIVO']; ?>
                </td>
                </tr>
                <tr> 
                <th scope="row">Tamaño pantalla </th>
                <td>
				<?php echo $row_MostrarMovil['TAMANO_PANTALLA']; ?>                 
                </td>
                </tr>
                <tr> 
                <th scope="row">Cámara frontal
                <td><?php echo $row_MostrarMovil['CAMARA_TRASERA']; ?>
                </td>
                </tr>                <tr> 
                <th scope="row">Cámara trasera </th>
                <td><?php echo $row_MostrarMovil['CAMARA_FRONTAL']; ?>
                </td>
                </tr>                <tr> 
                <th scope="row"> Procesador</th>
                                <td><?php echo $row_MostrarMovil['PROCESADOR']; ?>
                  </td>
                </tr>                  <tr> 
                <th scope="row">Memoria Interna</th>
                                <td><?php echo $row_MostrarMovil['MEMORIA_INTERNA']; ?>
                  </td>
                </tr>                
                <tr> 
                <th scope="row">Expansión de memoria </th>
                                <td><?php if( $row_MostrarMovil['EXPANSION_DE_MEMORIA']==1){ echo "SI";} else{echo "NO";} ?></td>
                </tr>                           
                <tr> 
                <th scope="row">Peso </th>
                <td><?php echo $row_MostrarMovil['PESO']." gramos"; ?>
                </td> 
                </tr>
                                               
                <tr> 
                <th scope="row">Conectividad </th>
                                <td>
                                <?php
								if($row_MostrarMovil['CON_2G']==1) echo "2G  ";

								if($row_MostrarMovil['CON_3G']==1) echo "3G  ";																if($row_MostrarMovil['CON_4G']==1) echo "4G";  
								?>
                </td>
                </tr>                
                <tr> 
                <th scope="row">Batería </th>
                                <td><?php echo $row_MostrarMovil['BATERIA']." mAh"; ?>
                  </td>
                </tr>
            
                </table>
                                
          </div>

      </div>
 
  </div>
                      	
</div>
           <div class="sidenav" id="Disponibilidad">
           <table border="1">
           <tr>
           <th scope="row" colspan="2">
            Disponible en:
            </th>
            </tr> <br />          
			<?php do { ?>
  <?php
  				
				echo '<tr><th scope="row"<a href='.$row_MostrarTM['ENLACE_PT'].'>'.$row_MostrarTM['NOMBRE_TIENDA'].'</a> </th> <td><span style="color:#DFD015;"> CLP '.$row_MostrarTM['PRECIO_CLP'].'<span/></td></tr> ';
				?>
                
  <?php } while ($row_MostrarTM = mysqli_fetch_assoc($MostrarTM)); ?>
			</table>
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

mysqli_free_result($MostrarMovil);

mysqli_free_result($BuscarImagenes);

mysqli_free_result($MostrarTM);

mysqli_free_result($MostrarTiendas);

mysqli_free_result($MostrarImagen1);
?>
