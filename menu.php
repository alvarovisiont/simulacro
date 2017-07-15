<?php require_once('Connections/conn_registro.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
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
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "adm,ope";
$MM_donotCheckaccess = "false";

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
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "denegado.php";
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
?>
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

mysql_select_db($database_conn_registro, $conn_registro);
$query_rsNuevos = "SELECT sim_users.nivel_usu FROM sim_users WHERE sim_users.nivel_usu = ' '";
$rsNuevos = mysql_query($query_rsNuevos, $conn_registro) or die(mysql_error());
$row_rsNuevos = mysql_fetch_assoc($rsNuevos);
$totalRows_rsNuevos = mysql_num_rows($rsNuevos);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
	<script src="js/bootstrap.js"></script>
	<script src="js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/personal.css">



<style>
.bell {
	animation: ring 8s 1s ease-in-out infinite;
	transform-origin: 50% 4px;
}

@keyframes ring {
	0% { transform: rotate(0); }
	1% { transform: rotate(30deg); }
	3% { transform: rotate(-28deg); }
	5% { transform: rotate(34deg); }
	7% { transform: rotate(-32deg); }
	9% { transform: rotate(30deg); }
	11% { transform: rotate(-28deg); }
	13% { transform: rotate(26deg); }
	15% { transform: rotate(-24deg); }
	17% { transform: rotate(22deg); }
	19% { transform: rotate(-20deg); }
	21% { transform: rotate(18deg); }
	23% { transform: rotate(-16deg); }
	25% { transform: rotate(14deg); }
	27% { transform: rotate(-12deg); }
	29% { transform: rotate(10deg); }
	31% { transform: rotate(-8deg); }
	33% { transform: rotate(6deg); }
	35% { transform: rotate(-4deg); }
	37% { transform: rotate(2deg); }
	39% { transform: rotate(-1deg); }
	41% { transform: rotate(1deg); }
	43% { transform: rotate(0); }
	100% { transform: rotate(0); }
}
</style>

</head>
<body>
<header>
<div class="bs-registro">
<div class="logo"><!-- Banner -->  
    <div class="bs-registro">
        <picture>
            <source media="(min-width: 650px)" srcset="imagenes/banner_ppal.jpg">
            <source media="(min-width: 250px)" srcset="imagenes/banner_movil.png">
            <!-- img tag for browsers that do not support picture element -->
            <img src="imagenes/banner_ppal.jpg"  width="100%">
        </picture>
    </div>
</div>
  <!-- <div class="intro">Some dumbass tagline goes here</div> -->
<div class="menu" id"menu"><!-- Menu -->
    <nav id="myNavbar" class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-registro-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" style="text-shadow:0 2px 2px rgba(0,0,0, .7); text-decoration:blink">SCVM</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-registro-navbar-collapse-1">
                <ul class="nav navbar-nav">
                </ul>
                <?php if ($_SESSION['MM_UserGroup']=="adm") {?>
                <ul class="nav navbar-nav">
                  <li><a href="operativos.php" style="text-shadow:0 2px 2px rgba(0,0,0, .7);">Operativos &nbsp;&nbsp;<span style="float:right" class="glyphicon glyphicon-flag"></span></a></li>
                  <li><a href="ver_registros.php" style="text-shadow:0 2px 2px rgba(0,0,0, .7);">Ver Registros &nbsp;&nbsp;<span style="float:right" class="glyphicon glyphicon-edit"></span></a></li>
                  <li><a href="vista_reporte.php" style="text-shadow:0 2px 2px rgba(0,0,0, .7);">Reportes &nbsp;&nbsp;<span style="float:right" class="glyphicon glyphicon-file"></span></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                	<?php if ($totalRows_rsNuevos > 0) { ?>
  					<li><a href="usuarios.php" style="text-shadow:0 2px 2px rgba(0,0,0, .7);">Nuevos Usuarios &nbsp;&nbsp;<span style="float:right" class="glyphicon glyphicon-bell bell"></span></a></li>
  					<?php } ?>
					<li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle" style="text-shadow:0 2px 2px rgba(0,0,0, .7);">Administrar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="float:right" class="glyphicon glyphicon-cog"><b class="caret"></b></span></a>
                        <ul class="dropdown-menu" style="width:150px">
	                        <li><a href="usuarios.php">Usuarios<span style="float:right" class="glyphicon glyphicon-user"></span></a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo $logoutAction ?>">Salir<span style="float:right" class="glyphicon glyphicon-log-out"></span></a></li>
                        </ul>
                    </li>
                </ul>
                <?php } else {?>
                <ul class="nav navbar-nav">
                  <li><a href="personas.php" style="text-shadow:0 2px 2px rgba(0,0,0, .7);">Carga de Votantes &nbsp;&nbsp;<span style="float:right" class="glyphicon glyphicon-import"></span></a></li>
                  <li><a href="formato_simulacro.pdf" target="_blank" style="text-shadow:0 2px 2px rgba(0,0,0, .7);">Descarga de Formato de Censo &nbsp;&nbsp;<span style="float:right" class="glyphicon glyphicon-file"></span></a></li>
                  <li><a href="ver_registros.php" style="text-shadow:0 2px 2px rgba(0,0,0, .7);">Ver Registros &nbsp;&nbsp;<span style="float:right" class="glyphicon glyphicon-edit"></span></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
					<li><a href="<?php echo $logoutAction ?>" style="text-shadow:0 2px 2px rgba(0,0,0, .7);">Salir &nbsp;&nbsp;<span style="float:right" class="glyphicon glyphicon-log-out"></span></a></li>
				</ul>
                <?php }?>                
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>
</div>
</div>
</header>
<p>
  <script>
// Create a clone of the menu, right next to original.
$('.menu').addClass('original').clone().insertAfter('.menu').addClass('cloned').css('position','fixed').css('top','0').css('margin-top','0').css('z-index','500').removeClass('original').hide();

scrollIntervalID = setInterval(stickIt, 10);


function stickIt() {

  var orgElementPos = $('.original').offset();
  orgElementTop = orgElementPos.top;               

  if ($(window).scrollTop() >= (orgElementTop)) {
    // scrolled past the original position; now only show the cloned, sticky element.

    // Cloned element should always have same left position and width as original element.     
    orgElement = $('.original');
    coordsOrgElement = orgElement.offset();
    leftOrgElement = coordsOrgElement.left;  
    widthOrgElement = orgElement.css('width');
    $('.cloned').css('left',leftOrgElement+'px').css('top',0).css('width',widthOrgElement).show();
    $('.original').css('visibility','hidden');
  } else {
    // not scrolled past the menu; only show the original menu.
    $('.cloned').hide();
    $('.original').css('visibility','visible');
  }
}
//@ sourceURL=pen.js
</script>
</body>
</html>
<?php
mysql_free_result($rsNuevos);
?>
