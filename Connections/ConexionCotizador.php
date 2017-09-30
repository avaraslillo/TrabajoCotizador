<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_ConexionCotizador = "localhost";
$database_ConexionCotizador = "cotizadorbd";
$username_ConexionCotizador = "root";
$password_ConexionCotizador = "";
$ConexionCotizador = mysql_pconnect($hostname_ConexionCotizador, $username_ConexionCotizador, $password_ConexionCotizador) or trigger_error(mysql_error(),E_USER_ERROR); 
?>