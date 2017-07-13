<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conn_registro = "localhost";
$database_conn_registro = #"sucrepot_registro";
$username_conn_registro = #"sucrepot_mario";
$password_conn_registro = #"mario2021";

$database_conn_registro = "simulacro";
$username_conn_registro = "root";
$password_conn_registro = "";

$conn_registro = mysql_pconnect($hostname_conn_registro, $username_conn_registro, $password_conn_registro) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES 'utf8'");
?>