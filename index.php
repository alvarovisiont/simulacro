<?php require_once('Connections/conn_registro.php'); ?>
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

if (isset($_POST['user'])) {
  $loginUsername=$_POST['user'];
  $password=$_POST['pass'];
  $MM_fldUserAuthorization = "nivel_usu";
  $MM_redirectLoginSuccess = "personas.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conn_registro, $conn_registro);
  	
  $LoginRS__query=sprintf("SELECT * FROM sim_users WHERE log_usu=%s AND cla_usu=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conn_registro) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'nivel_usu');
    $loginMun = mysql_result($LoginRS,0,'id_mun_user');
    $loginid = mysql_result($LoginRS,0,'id_usu');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	
    $_SESSION['MM_UserMun'] = $loginMun; 
    $_SESSION['MM_UserId'] = $loginid; 


    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }

    if($_SESSION['MM_UserGroup'] == 'adm')
    {
      header("Location: " . 'ver_registros.php' );  
    }
    else
    {
      header("Location: " . 'personas.php' );   
    }
    
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ingreso al Sistema</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css">

    <style>
    body {
      background-color: #eee;
    }

    .jumbotron {
      text-align: center;
      width: 30rem;
      border-radius: 0.5rem;
      margin: 4rem auto;
      background-color: #fff;
      padding: 2rem;
    }

    .container .glyphicon-list-alt {
      font-size: 10rem;
      margin-top: 3rem;
      color: #f96145;
    }

    input {
      width: 100%;
      margin-bottom: 1.4rem;
      padding: 1rem;
      background-color: #ecf2f4;
      border-radius: 0.2rem;
      border: none;
    }
    h2 {
      margin-bottom: 3rem;
      font-weight: bold;
      color: #ababab;
    }
    .btn {
      border-radius: 0.2rem;
    }
    .btn .glyphicon {
      font-size: 3rem;
      color: #fff;
    }
    .full-width {
      background-color: #8eb5e2;
      width: 100%;
      -webkit-border-top-right-radius: 0;
      -webkit-border-bottom-right-radius: 0;
      -moz-border-radius-topright: 0;
      -moz-border-radius-bottomright: 0;
      border-top-right-radius: 0;
      border-bottom-right-radius: 0;
    }

    .box {
      margin-bottom: 3rem;
      margin-left: 3rem;
      margin-right: 3rem;
    }
    </style>

</head>
<body>
<div class="col-md-12">
    <img src="imagenes/logo_militante.png"  alt="" class="img-responsive"/>
</div>
<div class="col-md-4 col-md-offset-4">
  <div class="jumbotron">
    <div class="container">
      <span class="fa fa-star-o" style="font-size: 7em; color:#e12b31;"></span>
      <h2>Bienvenido</h2>
      <div class="box">
        <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" role="form">
          <input type="text" name="user" placeholder="Usuario">
          <input type="password" name="pass" placeholder="Contraseña">
          <button class="btn full-width" name="Submit" value="Login" type="Submit">
            <span class="glyphicon glyphicon-ok"></span>
          </button>
        </form>
      </div>
    </div>
  </div>
</div> 

</body>
</html>