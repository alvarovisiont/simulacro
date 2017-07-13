<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conn_rep = "localhost";
$database_conn_rep = "rep_ar_sucre";
$username_conn_rep = "root";
$password_conn_rep = "";
//$username_conn_rep = "webserver";
//$password_conn_rep = "webserver";

$conn_rep = mysql_pconnect($hostname_conn_rep, $username_conn_rep, $password_conn_rep) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES 'utf8'");
?>