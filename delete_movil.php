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

if ((isset($_GET['IDMovil'])) && ($_GET['IDMovil'] != "")) {
  $deleteSQL = sprintf("DELETE FROM movil WHERE ID_MOVIL=%s",
                       GetSQLValueString($_GET['IDMovil'], "int"));

  mysql_select_db($database_ConexionCotizador, $ConexionCotizador);
  $Result1 = mysql_query($deleteSQL, $ConexionCotizador) or die(mysql_error());
}

if($Result1){
	echo '<script type="text/javascript">
		alert("ELIMINACIÓN EXITOSA");
	</script>
   ';
  $deleteGoTo = "lista_movil_edit.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));		

	}
else{
	echo '<script type="text/javascript">
		alert("Error en la eliminación");
	</script>';
	}
		
?>
