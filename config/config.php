<?php
/*
* config.php
* Contem as definicoes padrao do sistema
*/
header('Content-type: text/html; charset=utf-8');
session_name('f1eab0a18e58e4702476283e44486c800fc');


session_start();
ob_start();
set_time_limit(2000);
date_default_timezone_set('America/Recife');
ini_set('display_errors', 1);// 0 for production

$request_uri = explode('/', $_SERVER['REQUEST_URI']);

define('DS', DIRECTORY_SEPARATOR);

$DOCUMENT_ROOT = dirname(__FILE__);
$DOCUMENT_ROOT = substr($DOCUMENT_ROOT, 0, strpos($DOCUMENT_ROOT, DS."config"));

// configuracao de servidor
define('DIR', '/unp');
define('SYSTEM_NAME', 'Projeto Teste - UNP');

// configuracao do banco de dados
define('HOST', 'localhost');
define('DATABASE', 'unp_oo');
define('USERNAME', 'hsw');
define('PASSWORD', 'hsw');


define('DOCROOT', $DOCUMENT_ROOT);
define('WWWROOT', "http://".$_SERVER['SERVER_NAME'].DIR);
define('WEBROOT', WWWROOT."/webroot");

// include stuff
$helpers_dir     = DOCROOT."/core/helpers/";
$inc_dir         = DOCROOT."/core/libs/controllers/";
$core_dir        = DOCROOT."/core/libs/models/";
$class_dir       = DOCROOT."/app/models/";
$controllers_dir = DOCROOT."/app/controllers/";

// inc core models
if ($files = scandir($core_dir))
{
	foreach ($files as $f)
	{
		if (strstr($f, ".class.php"))
		{
			include_once $core_dir.$f;
		}
	}
}
else
{
	die("Houve um problema ao incluir as classes do sistema. Procure o administrador do sistema.");
}

// inc helpers
if ($files = scandir($helpers_dir))
{
    include_once $helpers_dir."PHPMailer.class.php";
	include_once $helpers_dir."SimpleImage.class.php";
	include_once $helpers_dir."SMTP.class.php";
}

// inc core controllers
if ($files = scandir($inc_dir))
{
    include_once $inc_dir."app_controller.php";
	include_once $inc_dir."util_layout.php";
	include_once $inc_dir."util_general.php";
	include_once $inc_dir."util_time_date.php";
}
else
{
	die("<h1>Houve um problema ao incluir os arquivos do sistema. Procure o administrador do sistema.</h1>");
}

// inc app models
if ($files = scandir($class_dir))
{
	foreach ($files as $f)
	{
		if (substr($f, -10) == ".class.php")
		{
			include_once $class_dir.$f;
		}
	}
}
else
{
	die("<h1>Houve um problema ao incluir as classes do usu&aacute;rio. Procure o administrador do sistema.</h1>");
}

// inc app controllers
if ($files = scandir($controllers_dir))
{
	foreach ($files as $f)
	{
		if (substr($f, -4) == ".php")
		{
			include_once $controllers_dir.$f;
		}
	}
}
else
{
	die("<h1>Houve um problema ao incluir as fun&ccedil;&otilde;es do usu&aacute;rio. Procure o administrador do sistema.</h1>");
}

include ('globals.php');

?>
