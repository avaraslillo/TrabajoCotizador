<?php require_once('Connections/ConexionCotizador.php');
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "ingresoadmin.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "ingresoadmin.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$IDM=0;
$Modelo="";
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "FormMovil")) {
  $insertSQL = sprintf("INSERT INTO movil (MARCA, MODELO, TAMANO_PANTALLA, SISTEMA_OPERATIVO, CAMARA_TRASERA, CAMARA_FRONTAL, PROCESADOR, MEMORIA_INTERNA, EXPANSION_DE_MEMORIA, PESO, CON_2G, CON_3G, CON_4G, BATERIA) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
                       GetSQLValueString($_POST['BATERIA'], "double"));
					   
					   

  mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);  
  $ResultMovil = mysqli_query($ConexionCotizador, $insertSQL) or die(mysqli_error($ResultMovil));
if(!$ResultMovil){  
echo '<script type="text/javascript" >
        alert("ERROR EN LA INSERCIÓN DE DATOS DEL MÓVIL"); //te mostrara el mensaje que quieras
    </script> ';
}
  if($ResultMovil){
	if (isset($_POST['MODELO'])) {
  		$Modelo = $_POST['MODELO'];
	}
	mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
	$query_AnadirImagenes = sprintf("SELECT movil.ID_MOVIL FROM movil WHERE movil.MODELO=%s", GetSQLValueString($Modelo, "text"));
$Consulta = mysqli_query($ConexionCotizador, $query_AnadirImagenes) or die(mysqli_error($ConexionCotizador));
$row_Consulta= mysqli_fetch_array($Consulta);
$IDM=$row_Consulta[0];
	  
	}
}
?>
                       <?php
mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
$query_MostrarMarcas = "SELECT * FROM marca";
$MostrarMarcas = mysqli_query($ConexionCotizador, $query_MostrarMarcas) or die(mysqli_error($ConexionCotizador));
$row_MostrarMarcas = mysqli_fetch_assoc($MostrarMarcas);
$totalRows_MostrarMarcas = mysqli_num_rows($MostrarMarcas);


mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
$query_MostrarTiendas = "SELECT * FROM tienda";
$MostrarTiendas = mysqli_query($ConexionCotizador, $query_MostrarTiendas) or die(mysqli_error($ConexionCotizador));
$row_MostrarTiendas = mysqli_fetch_assoc($MostrarTiendas);
$totalRows_MostrarTiendas = mysqli_num_rows($MostrarTiendas);
?>
<?php
$Activos=0;
$Insertados=0;
$carpeta = '../CotizadorOnline/imagenes/imagenes_moviles/'.$Modelo;
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "FormMovil")) {
	if(isset($_FILES['Imagen1']['name']) && isset($IDM) && $_FILES['Imagen1']['name']!="" && $IDM!=0){
		$Activos++;
		$foto = $_FILES['Imagen1']['name'];$ruta= $_FILES['Imagen1']['tmp_name'];
		$destino=$carpeta."/".$foto;
		copy($ruta,$destino); 	 		
 	 $insertSQL = sprintf("INSERT INTO imagen (ORDEN_IMAGEN, RUTA_IMAGEN, ID_MOVIL) VALUES ('1', %s, %s)", 
                       GetSQLValueString($destino, "text"),
                       GetSQLValueString($IDM, "int"));

  	mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
  $ResultImagen1 = mysqli_query($ConexionCotizador, $insertSQL) or die(mysqli_error($ConexionCotizador));
	if(!$ResultImagen1){  
		echo '<script type="text/javascript" >
        alert("ERROR EN LA INSERCIÓN DE LA IMAGEN FRONTAL"); //te mostrara el mensaje que quieras
    </script> ';
	}
	else{
		$Insertados++;
	}  
}
if(isset($_FILES['Imagen2']['name']) && isset($IDM) && $_FILES['Imagen2']['name']!="" && $IDM!=0){
	$Activos++;
	$foto = $_FILES['Imagen2']['name'];$ruta= $_FILES['Imagen2']['tmp_name'];
	$destino=$carpeta."/".$foto;
	copy($ruta,$destino); 	 		
  	$insertSQL = sprintf("INSERT INTO imagen (ORDEN_IMAGEN, RUTA_IMAGEN, ID_MOVIL) VALUES ('2', %s, %s)", 
                       GetSQLValueString($destino, "text"),
                       GetSQLValueString($IDM, "int"));

  	mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
  $ResultImagen2 = mysqli_query($ConexionCotizador, $insertSQL) or die(mysqli_error($ConexionCotizador));
	if(!$ResultImagen2){  
		echo '<script type="text/javascript" >
        alert("ERROR EN LA INSERCIÓN DE LA IMAGEN LATERAL IZQUIERDA"); //te mostrara el mensaje que quieras
    </script> ';
	}
	else{
		$Insertados++;
	} 	  
}
if(isset($_FILES['Imagen3']['name']) && isset($IDM) && $_FILES['Imagen3']['name']!="" && $IDM!=0){
	$Activos++;
	$foto = $_FILES['Imagen3']['name'];$ruta= $_FILES['Imagen3']['tmp_name'];
	$destino=$carpeta."/".$foto;
	copy($ruta,$destino); 	 		
  	$insertSQL = sprintf("INSERT INTO imagen (ORDEN_IMAGEN, RUTA_IMAGEN, ID_MOVIL) VALUES ('3', %s, %s)", 
                       GetSQLValueString($destino, "text"),
                       GetSQLValueString($IDM, "int"));

  	mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
  $ResultImagen3 = mysqli_query($ConexionCotizador, $insertSQL) or die(mysqli_error($ConexionCotizador));
	if(!$ResultImagen3){  
		echo '<script type="text/javascript" >
        alert("ERROR EN LA INSERCIÓN DE LA IMAGEN TRASERA"); //te mostrara el mensaje que quieras
    </script> ';
	}
	else{
		$Insertados++;
	}    
}
if(isset($_FILES['Imagen4']['name']) && isset($IDM) && $_FILES['Imagen4']['name']!="" && $IDM!=0){
	$Activos++;
	$foto = $_FILES['Imagen4']['name'];$ruta= $_FILES['Imagen4']['tmp_name'];
	$destino=$carpeta."/".$foto;
	copy($ruta,$destino); 	 		
  	$insertSQL = sprintf("INSERT INTO imagen (ORDEN_IMAGEN, RUTA_IMAGEN, ID_MOVIL) VALUES ('4', %s, %s)", 
                       GetSQLValueString($destino, "text"),
                       GetSQLValueString($IDM, "int"));

  	mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
  $ResultImagen4 = mysqli_query($ConexionCotizador, $insertSQL) or die(mysqli_error($ConexionCotizador));
	if(!$ResultImagen4){  
		echo '<script type="text/javascript" >
        alert("ERROR EN LA INSERCIÓN DE LA IMAGEN FRONTAL DERECHA"); //te mostrara el mensaje que quieras
    </script> ';
	}
	else{
		$Insertados++;
	} 	  
}
 

}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "FormMovil")) {
	if(isset($_POST['DisponibilidadTienda']) && isset($_POST['Enlace']) && isset($_POST['PrCLP'])){
	$Activos++;	
	$distienda = $_POST["DisponibilidadTienda"];	
	$enlace = $_POST["Enlace"];
	$prclp = $_POST["PrCLP"];
	$num=count($distienda);
	$error=0;	
	for($i=0;$i<$num;$i++){
		$insertSQL = sprintf("INSERT INTO relacion_tm (ID_MOVIL, ID_TIENDA, ENLACE_PT, PRECIO_CLP) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($IDM, "int"),
                       GetSQLValueString($distienda[$i], "int"),
                       GetSQLValueString($enlace[$i], "text"),
                       GetSQLValueString($prclp[$i], "int"));
  		mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
  		$ResultTiendas = mysqli_query($ConexionCotizador, $insertSQL) or die(mysqli_error());	
  		if(!$ResultTiendas){
			$error=1;
		}
	}
  	if($error==1){  
		echo '<script type="text/javascript" >
        alert("ERROR EN LA INSERCIÓN DE LAS RELACIONES ENTRE EL MOVIL Y LAS TIENDAS"); //te mostrara el mensaje que quieras
    </script> ';
	}
	else{
		$Insertados++;
	} 
}
if($Activos==$Insertados){
echo '<script type="text/javascript" >
        alert("INSERCIÓN EXITOSA DE TODOS LOS DATOS");
    </script> ';	
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
<span style="float:right; margin-right:15px; "><a href="<?php echo $logoutAction ?>" style="color:#FFF;">Cerrar Sesión</a></span>
<h3 style="position:relative; top:40%; color:#FFF; font:Arial, Helvetica, sans-serif; font-size:24px; text-align:center;">Administración</h3>
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
	<div id="FormAgregarMovil" class="FormAdmin">
      <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="FormMovil" id="FormMovil">
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Marca</td>
            <td><select name="MARCA">
              <?php
do {  
?>
              <option value="<?php echo $row_MostrarMarcas['ID_MARCA']?>"><?php echo $row_MostrarMarcas['ID_MARCA']?></option>
              <?php
} while ($row_MostrarMarcas = mysqli_fetch_assoc($MostrarMarcas));
  $rows = mysqli_num_rows($MostrarMarcas);
  if($rows > 0) {
      mysqli_data_seek($MostrarMarcas, 0);
	  $row_MostrarMarcas = mysqli_fetch_assoc($MostrarMarcas);
  }
?>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Modelo</td>
            <td><input type="text" name="MODELO" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Tamaño Pantalla</td>
            <td><input type="text" name="TAMANO_PANTALLA" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Sistema Operativo</td>
            <td><select name="SISTEMA_OPERATIVO">
              <option value="android" <?php if (!(strcmp("android", ""))) {echo "SELECTED";} ?>>Android</option>
              <option value="ios" <?php if (!(strcmp("ios", ""))) {echo "SELECTED";} ?>>iOS</option>
              <option value="winphone" <?php if (!(strcmp("winphone", ""))) {echo "SELECTED";} ?>>Windows Phone</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Camara Trasera</td>
            <td><input type="text" name="CAMARA_TRASERA" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Camara Frontal</td>
            <td><input type="text" name="CAMARA_FRONTAL" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Procesador</td>
            <td><input type="text" name="PROCESADOR" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Memoria Interna</td>
            <td><input type="text" name="MEMORIA_INTERNA" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Expansión de memoria</td>
            <td><select name="EXPANSION_DE_MEMORIA">
              <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>SI</option>
              <option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>NO</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Peso</td>
            <td><input type="text" name="PESO" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Conectividad</td>
            <td>
                <input name="CONECTIVIDAD" type="checkbox" value="2G" />
            2G</br>
                <input name="CONECTIVIDAD" type="checkbox" value="3G" />
                3G</br>
                <input name="CONECTIVIDAD" type="checkbox" value="4G" />
            4G</br>                        </td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Batería</td>
            <td><input type="text" name="BATERIA" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right" rowspan="1">Insertar Imagenes</td>
            <td><p>
              <input type="file" name="Imagen1" id="Imagen1" />
              <br />
              <small>
              Imagen Frontal del móvil</small> 
            </p>
              <p>                
                <label for="Imagen2"></label>
                <input type="file" name="Imagen2" id="Imagen2" />
              <br />
              <small>
              Imagen Lateral Izquierda del móvil</small>  
              </p>
              <p>               
                <label for="Imagen3"></label>
                <input type="file" name="Imagen3" id="Imagen3" /> 
              <br />
              <small>
              Imagen Trasera del móvil</small> 
              </p>              
                <label for="Imagen4"></label>
                <input type="file" name="Imagen4" id="Imagen4" /> 
              <br />
              <small>
              Imagen Lateral Derecha del móvil</small> 
              </p>
            </td>
          </tr>
          
  <tr valign="baseline">
    <td nowrap="nowrap" align="right">Disponible en</td>
    <td> <?php $num=0; do { echo '<input name="DisponibilidadTienda[]" type="checkbox" value='.$row_MostrarTiendas['ID_TIENDA'].' onclick="ActivarDatos('.$num.');" /> '.$row_MostrarTiendas['NOMBRE_TIENDA'].'<br />
    <input name="Enlace[]" type="text" value="Enlace del producto en la tienda" size="35" maxlength="250" disabled="true"/>
    <br />
    <input name="PrCLP[]" type="text" value="Precio Pesos CH" size="20" maxlength="15" disabled="true" />
    <br />';$num++;} while ($row_MostrarTiendas = mysqli_fetch_assoc($MostrarTiendas)); ?></td>
  </tr>

<tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Insertar registro" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
        <input type="hidden" name="MM_insert" value="FormMovil" />
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
mysqli_free_result($MostrarMarcas);

mysqli_free_result($AnadirImagenes);

mysqli_free_result($MostrarTiendas);

mysqli_free_result($MostrarMarcas);
?>
