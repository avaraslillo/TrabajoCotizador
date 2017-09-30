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
?>

                       <?php
mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
$query_MostrarMarcas = "SELECT * FROM marca";
$MostrarMarcas = mysql_query($query_MostrarMarcas, $ConexionCotizador) or die(mysql_error());
$row_MostrarMarcas = mysql_fetch_assoc($MostrarMarcas);
$totalRows_MostrarMarcas = mysql_num_rows($MostrarMarcas);

$VARMovil_MostrarMovil = "0";
if (isset($_GET["IDMovil"])) {
  $VARMovil_MostrarMovil = $_GET["IDMovil"];
}
mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
$query_MostrarMovil = sprintf("SELECT * FROM movil WHERE movil.ID_MOVIL=%s", GetSQLValueString($VARMovil_MostrarMovil, "int"));
$MostrarMovil = mysql_query($query_MostrarMovil, $ConexionCotizador) or die(mysql_error());
$row_MostrarMovil = mysql_fetch_assoc($MostrarMovil);
$totalRows_MostrarMovil = mysql_num_rows($MostrarMovil);
?>
                       <?php

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "FormMovil")) {
  $updateSQL = sprintf("UPDATE movil SET MARCA=%s, MODELO=%s, TAMANO_PANTALLA=%s, SISTEMA_OPERATIVO=%s, CAMARA_TRASERA=%s, CAMARA_FRONTAL=%s, PROCESADOR=%s, MEMORIA_INTERNA=%s, EXPANSION_DE_MEMORIA=%s, PESO=%s, CON_2G=%s, CON_3G=%s, CON_4G=%s, BATERIA=%s WHERE ID_MOVIL=%s",
                       GetSQLValueString($_POST['MARCA'], "text"),
                       GetSQLValueString($_POST['MODELO'], "text"),
                       GetSQLValueString($_POST['TAMANO_PANTALLA'], "text"),
                       GetSQLValueString($_POST['SISTEMA_OPERATIVO'], "text"),
                       GetSQLValueString($_POST['CAMARA_TRASERA'], "text"),
                       GetSQLValueString($_POST['CAMARA_FRONTAL'], "text"),
                       GetSQLValueString($_POST['PROCESADOR'], "text"),
                       GetSQLValueString($_POST['MEMORIA_INTERNA'], "text"),
                       GetSQLValueString($_POST['EXPANSION_DE_MEMORIA'], "int"),
                       GetSQLValueString($_POST['PESO'], "double"),
                       GetSQLValueString(isset($_POST['CONECTIVIDAD']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['CONECTIVIDAD']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['CONECTIVIDAD']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['BATERIA'], "double"),
                       GetSQLValueString($_POST['ID'], "int"));

  mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
  $Result1 = mysql_query($updateSQL, $ConexionCotizador) or die(mysql_error());
}
$IDM_AnadirImagenes = "0";
if (isset($_POST['MODELO'])) {
  $IDM_AnadirImagenes = $_POST['MODELO'];
}
mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
$query_AnadirImagenes = sprintf("SELECT movil.ID_MOVIL FROM movil WHERE movil.MODELO=%s", GetSQLValueString($IDM_AnadirImagenes, "text"));
$AnadirImagenes = mysql_query($query_AnadirImagenes, $ConexionCotizador) or die(mysql_error());
$row_AnadirImagenes = mysql_fetch_assoc($AnadirImagenes);
$totalRows_AnadirImagenes = mysql_num_rows($AnadirImagenes);

$VAR_MostrarTiendasActivas = "0";
if (isset($_GET['IDMovil'])) {
  $VAR_MostrarTiendasActivas = $_GET['IDMovil'];
}
mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
$query_MostrarTiendasActivas = sprintf("SELECT relacion_tm.ID_MOVIL, relacion_tm.ID_TIENDA, relacion_tm.ENLACE_PT, relacion_tm.PRECIO_CLP, tienda.NOMBRE_TIENDA  FROM relacion_tm, tienda WHERE relacion_tm.ID_MOVIL=%s AND tienda.ID_TIENDA=relacion_tm.ID_TIENDA", GetSQLValueString($VAR_MostrarTiendasActivas, "int"));
$MostrarTiendasActivas = mysql_query($query_MostrarTiendasActivas, $ConexionCotizador) or die(mysql_error());
$row_MostrarTiendasActivas = mysql_fetch_assoc($MostrarTiendasActivas);
$totalRows_MostrarTiendasActivas = mysql_num_rows($MostrarTiendasActivas);

$VAR_MostrarTiendasInactivas = "0";
if (isset($_GET['IDMovil'])) {
  $VAR_MostrarTiendasInactivas = $_GET['IDMovil'];
}
mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
$query_MostrarTiendasInactivas = sprintf("SELECT tienda.ID_TIENDA, tienda.NOMBRE_TIENDA FROM tienda WHERE tienda.ID_TIENDA NOT IN (SELECT tienda.ID_TIENDA FROM relacion_tm, tienda WHERE relacion_tm.ID_MOVIL=%s AND tienda.ID_TIENDA = relacion_tm.ID_TIENDA)", GetSQLValueString($VAR_MostrarTiendasInactivas, "int"));
$MostrarTiendasInactivas = mysql_query($query_MostrarTiendasInactivas, $ConexionCotizador) or die(mysql_error());
$row_MostrarTiendasInactivas = mysql_fetch_assoc($MostrarTiendasInactivas);
$totalRows_MostrarTiendasInactivas = mysql_num_rows($MostrarTiendasInactivas);

$VAR_MostrarImagen1 = "0";
if (isset($_GET['IDMovil'])) {
  $VAR_MostrarImagen1 = $_GET['IDMovil'];
}
mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
$query_MostrarImagen1 = sprintf("SELECT movil.ID_MOVIL, imagen.ID_IMAGEN, imagen.ORDEN_IMAGEN, imagen.RUTA_IMAGEN FROM movil, imagen WHERE movil.ID_MOVIL=%s  AND imagen.ID_MOVIL=movil.ID_MOVIL AND imagen.ID_IMAGEN=1", GetSQLValueString($VAR_MostrarImagen1, "int"));
$MostrarImagen1 = mysql_query($query_MostrarImagen1, $ConexionCotizador) or die(mysql_error());
$row_MostrarImagen1 = mysql_fetch_assoc($MostrarImagen1);
$totalRows_MostrarImagen1 = mysql_num_rows($MostrarImagen1);

$VAR_MostrarImagen2 = "0";
if (isset($_GET['IDMovil'])) {
  $VAR_MostrarImagen2 = $_GET['IDMovil'];
}
mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
$query_MostrarImagen2 = sprintf("SELECT movil.ID_MOVIL, imagen.ID_IMAGEN, imagen.ORDEN_IMAGEN, imagen.RUTA_IMAGEN FROM movil, imagen WHERE movil.ID_MOVIL=%s  AND imagen.ID_MOVIL=movil.ID_MOVIL AND imagen.ID_IMAGEN=2", GetSQLValueString($VAR_MostrarImagen2, "int"));
$MostrarImagen2 = mysql_query($query_MostrarImagen2, $ConexionCotizador) or die(mysql_error());
$row_MostrarImagen2 = mysql_fetch_assoc($MostrarImagen2);
$totalRows_MostrarImagen2 = mysql_num_rows($MostrarImagen2);

$VAR_MostrarImagen3 = "0";
if (isset($_GET['IDMovil'])) {
  $VAR_MostrarImagen3 = $_GET['IDMovil'];
}
mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
$query_MostrarImagen3 = sprintf("SELECT movil.ID_MOVIL, imagen.ID_IMAGEN, imagen.ORDEN_IMAGEN, imagen.RUTA_IMAGEN FROM movil, imagen WHERE movil.ID_MOVIL=%s  AND imagen.ID_MOVIL=movil.ID_MOVIL AND imagen.ID_IMAGEN=3", GetSQLValueString($VAR_MostrarImagen3, "int"));
$MostrarImagen3 = mysql_query($query_MostrarImagen3, $ConexionCotizador) or die(mysql_error());
$row_MostrarImagen3 = mysql_fetch_assoc($MostrarImagen3);
$totalRows_MostrarImagen3 = mysql_num_rows($MostrarImagen3);

$VAR_MostrarImagen4 = "0";
if (isset($_GET['IDMovil'])) {
  $VAR_MostrarImagen4 = $_GET['IDMovil'];
}
mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
$query_MostrarImagen4 = sprintf("SELECT movil.ID_MOVIL, imagen.ID_IMAGEN, imagen.ORDEN_IMAGEN, imagen.RUTA_IMAGEN FROM movil, imagen WHERE movil.ID_MOVIL=%s  AND imagen.ID_MOVIL=movil.ID_MOVIL AND imagen.ID_IMAGEN=4", GetSQLValueString($VAR_MostrarImagen4, "int"));
$MostrarImagen4 = mysql_query($query_MostrarImagen4, $ConexionCotizador) or die(mysql_error());
$row_MostrarImagen4 = mysql_fetch_assoc($MostrarImagen4);
$totalRows_MostrarImagen4 = mysql_num_rows($MostrarImagen4);
?>
<?php
/*$row_Buscar= mysql_fetch_array($AnadirImagenes);
$IDM=$row_Buscar[0];
if(isset($_FILES['Imagen1']['name']) && isset($IDM) && $IDM!=0){
	$foto = $_FILES['Imagen1']['name'];$ruta= $_FILES['Imagen1']['tmp_name'];
	$destino="../CotizadorOnline/imagenes/imagenes_moviles/".$foto;
	copy($ruta,$destino); 	 		
  $insertSQL = sprintf("INSERT INTO imagen (RUTA_IMAGEN, ID_MOVIL) VALUES (%s, %s)",
                       GetSQLValueString($destino, "text"),
                       GetSQLValueString($IDM, "int"));

  mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
  $Result1 = mysql_query($insertSQL, $ConexionCotizador) or die(mysql_error());
}*/
?>
<?php

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "FormMovil")) {	
	if(isset($_POST['TiendaActiva']) && isset($_POST['EnlaceActivo']) && isset($_POST['PrCLPActivo'])){
		
	$distienda = $_POST["TiendaActiva"];	
	$enlace = $_POST["EnlaceActivo"];
	$prclp = $_POST["PrCLPActivo"];
	$num=count($distienda);
	$error=0;	
	for($i=0;$i<$num;$i++){
		$insertSQL = sprintf("UPDATE  relacion_tm SET ENLACE_PT=%s, PRECIO_CLP=%s WHERE ID_MOVIL=%s AND ID_TIENDA=%s",
                       GetSQLValueString($enlace[$i], "text"),
                       GetSQLValueString($prclp[$i], "int"),
                       GetSQLValueString($_POST['ID'], "int"),
                       GetSQLValueString($distienda[$i], "int"));
  		mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
  		$ResultTiendas = mysql_query($insertSQL, $ConexionCotizador) or die(mysql_error());	
  		if(!$ResultTiendas){
			$error=1;
		}
	}
  	if($error==1){  
		echo '<script type="text/javascript" >
        alert("ERROR EN LA INSERCIÓN DE LAS RELACIONES ENTRE EL MOVIL Y LAS TIENDAS"); //te mostrara el mensaje que quieras
    </script> ';
	}
	/*else{
		$Insertados++;
	} */
	}
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "FormMovil")) {	
	if(isset($_POST['TiendaNueva']) && isset($_POST['EnlaceNuevo']) && isset($_POST['PrCLPNuevo'])){
		
	$distienda = $_POST["TiendaNueva"];	
	$enlace = $_POST["EnlaceNuevo"];
	$prclp = $_POST["PrCLPNuevo"];
	$num=count($distienda);
	$error=0;	
	for($i=0;$i<$num;$i++){
		$insertSQL = sprintf("INSERT INTO relacion_tm (ID_MOVIL, ID_TIENDA, ENLACE_PT, PRECIO_CLP) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID'], "int"),
                       GetSQLValueString($distienda[$i], "int"),
                       GetSQLValueString($enlace[$i], "text"),
                       GetSQLValueString($prclp[$i], "int"));
  		mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
  		$ResultTiendas = mysql_query($insertSQL, $ConexionCotizador) or die(mysql_error());	
  		if(!$ResultTiendas){
			$error=1;
		}
	}
  	if($error==1){  
		echo '<script type="text/javascript" >
        alert("ERROR EN LA INSERCIÓN DE LAS RELACIONES ENTRE EL MOVIL Y LAS TIENDAS"); //te mostrara el mensaje que quieras
    </script> ';
	}
	/*else{
		$Insertados++;
	} */
	}
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
<script type="text/javascript" src="scripts/funciones.js"></script>
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
	<div id="FormEditarMovil" class="FormAdmin">
      <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="FormMovil" id="FormMovil">
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Marca</td>
            <td><select name="MARCA" title="<?php echo $row_MostrarMovil['MARCA']; ?>">
              <?php
do {  
?>
              <option value="<?php echo $row_MostrarMarcas['ID_MARCA']?>" <?php if($row_MostrarMarcas['ID_MARCA']==$row_MostrarMovil['MARCA']){echo "selected";}?>><?php echo $row_MostrarMarcas['ID_MARCA']?></option>
              <?php
} while ($row_MostrarMarcas = mysql_fetch_assoc($MostrarMarcas));
  $rows = mysql_num_rows($MostrarMarcas);
  if($rows > 0) {
      mysql_data_seek($MostrarMarcas, 0);
	  $row_MostrarMarcas = mysql_fetch_assoc($MostrarMarcas);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Modelo</td>
            <td><input type="text" name="MODELO" value="<?php echo $row_MostrarMovil['MODELO']; ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Tamaño Pantalla</td>
            <td><input type="text" name="TAMANO_PANTALLA" value="<?php echo $row_MostrarMovil['TAMANO_PANTALLA']; ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Sistema Operativo</td>
            <td><select name="SISTEMA_OPERATIVO" title="<?php echo $row_MostrarMovil['SISTEMA_OPERATIVO']; ?>">
              <option value="android" <?php if (!(strcmp("android", ""))) {echo "SELECTED";} ?>>Android</option>
              <option value="ios" <?php if (!(strcmp("ios", ""))) {echo "SELECTED";} ?>>iOS</option>
              <option value="winphone" <?php if (!(strcmp("winphone", ""))) {echo "SELECTED";} ?>>Windows Phone</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Camara Trasera</td>
            <td><input type="text" name="CAMARA_TRASERA" value="<?php echo $row_MostrarMovil['CAMARA_TRASERA']; ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Camara Frontal</td>
            <td><input type="text" name="CAMARA_FRONTAL" value="<?php echo $row_MostrarMovil['CAMARA_FRONTAL']; ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Procesador</td>
            <td><input type="text" name="PROCESADOR" value="<?php echo $row_MostrarMovil['PROCESADOR']; ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Memoria Interna</td>
            <td><input type="text" name="MEMORIA_INTERNA" value="<?php echo $row_MostrarMovil['MEMORIA_INTERNA']; ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Expansión de memoria</td>
            <td><select name="EXPANSION_DE_MEMORIA" title="<?php echo $row_MostrarMovil['EXPANSION_DE_MEMORIA']; ?>">
              <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>SI</option>
              <option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>NO</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Peso</td>
            <td><input type="text" name="PESO" value="<?php echo $row_MostrarMovil['PESO']; ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Conectividad</td>
            <td>
                <input name="CONECTIVIDAD" type="checkbox" value="2G" <?php if( $row_MostrarMovil['CON_2G']==1) echo "checked" ?> />
            2G</br>
                <input name="CONECTIVIDAD" type="checkbox" value="3G" <?php if( $row_MostrarMovil['CON_3G']==1) echo "checked" ?> />
                3G</br>
                <input name="CONECTIVIDAD" type="checkbox" value="4G" <?php if( $row_MostrarMovil['CON_4G']==1) echo "checked" ?> />
            4G</br>                        </td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Batería</td>
            <td><input type="text" name="BATERIA" value="<?php echo $row_MostrarMovil['BATERIA']; ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right" >Insertar Imagenes</td>
            <td>
<p>
              <input type="file" name="Imagen1" id="Imagen1" value="<?php echo $row_MostrarImagen1['RUTA_IMAGEN']; ?>"/>
              <br />
              <small>
              Imagen Frontal del móvil</small> 
            </p>
              <p>                
                <label for="Imagen2"></label>
                <input type="file" name="Imagen2" id="Imagen2" value="<?php echo $row_MostrarImagen2['RUTA_IMAGEN']; ?>" />
              <br />
              <small>
              Imagen Lateral Izquierda del móvil</small>  
              </p>
              <p>               
                <label for="Imagen3"></label>
                <input type="file" name="Imagen3" id="Imagen3" value="<?php echo $row_MostrarImagen3['RUTA_IMAGEN']; ?>"/> 
              <br />
              <small>
              Imagen Trasera del móvil</small> 
              </p>              
                <label for="Imagen4"></label>
                <input type="file" name="Imagen4" id="Imagen4" value="<?php echo $row_MostrarImagen4['RUTA_IMAGEN']; ?>"/> 
              <br />
              <small>
              Imagen Lateral Derecha del móvil</small> 
              </p>            
            </td>
          </tr>
          <tr>
          <th scope="row">
          Disponible en:
          </th>
          <td>
          <?php
		  $num=0;
		   do { echo '<input name="TiendaActiva[]" type="checkbox" value='.$row_MostrarTiendasActivas['ID_TIENDA'].' onclick="ActivarDatosACT('.$num.');" /> '.$row_MostrarTiendasActivas['NOMBRE_TIENDA'].'<br />
    <input name="EnlaceActivo[]" type="text" value='.$row_MostrarTiendasActivas['ENLACE_PT'].' size="35" maxlength="250" disabled="true"/>
    <br />
    <input name="PrCLPActivo[]" type="text" value="'.$row_MostrarTiendasActivas['PRECIO_CLP'].'" size="20" maxlength="15" disabled="true" />
    <br />'; $num++;} while ($row_MostrarTiendasActivas = mysql_fetch_assoc($MostrarTiendasActivas));
	echo '<br><a onclick="mostrarTiendas();" ><span style="color:#FADB03; background-color:#666; padding:5px 5px 5px 5px; text-decoration:under-line";>Clic aquí para agregar nuevas tiendas que vendan el móvil</span></a></br>';
			echo '<div id="NuevasTiendas">
          <br />';
		  $num=0; 
		   do { echo '<input name="TiendaNueva[]" type="checkbox" value='.$row_MostrarTiendasInactivas['ID_TIENDA'].' onclick="ActivarDatosINACT('.$num.');" /> '.$row_MostrarTiendasInactivas['NOMBRE_TIENDA'].'<br />
    <input name="EnlaceNuevo[]" type="text" value="Enlace del producto en la tienda" size="35" maxlength="250" disabled="true"/>
    <br />
    <input name="PrCLPNuevo[]" type="text" value="Precio Pesos CH" size="20" maxlength="15" disabled="true" />
    <br />'; $num++;} while ($row_MostrarTiendasInactivas = mysql_fetch_assoc($MostrarTiendasInactivas)); 	  
	echo '</div>';
		  ?>
			<br />
          </td>
          </tr>          
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Actualizar registro" /></td>
          </tr>
        </table>

        <input type="hidden" name="MM_insert" value="FormMovil" />
        <input type="hidden" name="MM_update" value="FormMovil" />
        <input type="hidden" name="ID" value="<?php echo $row_MostrarMovil['ID_MOVIL']; ?>" />        
      </form>
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

mysql_free_result($MostrarMovil);

mysql_free_result($MostrarTiendasActivas);

mysql_free_result($MostrarTiendasInactivas);

mysql_free_result($MostrarImagen1);

mysql_free_result($MostrarImagen2);

mysql_free_result($MostrarImagen3);

mysql_free_result($MostrarImagen4);

?>
