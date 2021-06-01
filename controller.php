<?php
error_reporting(1);
header('Content-Type: text/html; charset=utf8');
require_once 'settings.php';
require_once 'core/database.php';
require_once 'core/view.php';
require_once 'helpers/arraytools.php';
require_once 'helpers/filehandler.php';
require_once 'helpers/sessionhandling.php';
require_once 'tools/array2auditor.php';

$peticion = $_SERVER['REQUEST_URI'];
$peticiones = explode('/', $peticion);

$n = (SO_UNIX == true) ? 1 : 2;

@$modulo = $peticiones[$n];
@$recurso = $peticiones[$n+1];
$argumentos = array();
for($i=0; $i<=$n+1; $i++) unset($peticiones[$i]);
foreach($peticiones as $argumento) $argumentos[] = $argumento;

if(empty($modulo)) { $modulo = DEFAULT_MODULE; }
if(empty($recurso)) { $recurso = DEFAULT_ACTION; }

if(!file_exists("modules/{$modulo}/controller.php")) {
    $modulo = DEFAULT_MODULE;
}

$GLOBALS['modulo'] = $modulo;

$archivo = "modules/{$modulo}/controller.php";
require_once $archivo;
$controller_name = ucwords($modulo) . 'Controller';
$controller = new $controller_name;

$recurso = (method_exists($controller, $recurso)) ? $recurso : DEFAULT_ACTION;
$controller->$recurso($argumentos);
?>
