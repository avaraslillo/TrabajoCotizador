<?php require_once('Connections/ConexionCotizador.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
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
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['UsuarioAdmin'])) {
  $loginUsername=$_POST['UsuarioAdmin'];
  $password=$_POST['Contrasena'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "admin.php";
  $MM_redirectLoginFailed = "ingresoadmin.php";
  $MM_redirecttoReferrer = false;
  mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
  
  $LoginRS__query=sprintf("SELECT USER, PASS FROM usuario WHERE USER=%s AND PASS=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysqli_query($ConexionCotizador, $LoginRS__query) or die(mysqli_error($ConexionCotizador));
  $loginFoundUser = mysqli_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}

/*$usuario = $_POST['UsuarioAdmin'];
$pass = $_POST['Contrasena'];
 
if(empty($usuario) || empty($pass)){
	header("Location: ingresoadmin.php");
exit();
}
 
mysqli_select_db($ConexionCotizador, $database_ConexionCotizador);
 
$result = mysqli_query($ConexionCotizador, "SELECT * from usuario where USER='" . $usuario . "'");
 
if($row = mysqli_fetch_array($ConexionCotizador,$result)){
	if($row['PASS'] == $pass){
		session_start();
		$_SESSION['UsuarioAdmin'] = $usuario;
		header("Location: admin.php");
	}
	else{
		header("Location: ingresoadmin.php");
		exit();
	}
}*/


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
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

		<div id="PanelIngreso">
			<div id="IngresoAdmin">
            	<h4 style="margin-left:10px;">Ingreso administrativo</h4><br />
                <form name="AccesoAdmin" action="<?php echo $loginFormAction; ?>" method="POST" enctype="multipart/form-data">
                <span style="margin-left:10px;">                
            	<tr><th scope="row">Nombre de usuario</th> <td><input name="UsuarioAdmin" type="text" size="30" maxlength="30" /></td></tr>
                </span>
                <br />
              	<span style="margin-left:10px;">  
                <tr><th scope="row">Contraseña</th> <td><input name="Contrasena" type="text" size="30" maxlength="30" /></td></tr>
                </span>
                <br />
                <span style="position:relative; left:50%;">
                <input name="botonAcceso" type="submit" value="Acceder" /></span>
                </form>
			</div>  
		</div>
	</div> 
     
</body>
</html>