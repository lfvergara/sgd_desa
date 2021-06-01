<?php
require_once "modules/auditor/model.php";

class Array2Auditor {
  function saveAuditor($objeto, $recurso, $detalle='') {
    $am = new Auditor();
    $am->recurso;
    $am->recurso = $recurso;
    $am->objeto = $objeto;
    $am->usuario = $_SESSION["sesion.denominacion"];
    $am->navegador = $this->getBrowser($_SERVER['HTTP_USER_AGENT']);
    $am->sistemaoperativo = $this->getSO($_SERVER['HTTP_USER_AGENT']);
    $am->ip = $_SERVER["REMOTE_ADDR"];
    $am->fecha = date('Y-m-d');
    $am->hora = date('H:i:s');
    $am->detalle = $detalle;
    $am->save();
    return $am->auditor_id;
	}
  
  function getBrowser($user_agent){
    if(strpos($user_agent, 'MSIE') !== FALSE)
      return 'Internet explorer';
    elseif(strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
      return 'Microsoft Edge';
    elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
      return 'Internet explorer';
    elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
      return "Opera Mini";
    elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
      return "Opera";
    elseif(strpos($user_agent, 'Firefox') !== FALSE)
      return 'Mozilla Firefox';
    elseif(strpos($user_agent, 'Chrome') !== FALSE)
      return 'Google Chrome';
    elseif(strpos($user_agent, 'Safari') !== FALSE)
      return "Safari";
    else
      return 'No hemos podido detectar su navegador';
  }
  
  function getSO($user_agent) {
    $os_array =  array('/windows nt 10/i'      =>  'Windows 10',
                       '/windows nt 6.3/i'     =>  'Windows 8.1',
                       '/windows nt 6.2/i'     =>  'Windows 8',
                       '/windows nt 6.1/i'     =>  'Windows 7',
                       '/windows nt 6.0/i'     =>  'Windows Vista',
                       '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                       '/windows nt 5.1/i'     =>  'Windows XP',
                       '/windows xp/i'         =>  'Windows XP',
                       '/windows nt 5.0/i'     =>  'Windows 2000',
                       '/windows me/i'         =>  'Windows ME',
                       '/win98/i'              =>  'Windows 98',
                       '/win95/i'              =>  'Windows 95',
                       '/win16/i'              =>  'Windows 3.11',
                       '/macintosh|mac os x/i' =>  'Mac OS X',
                       '/mac_powerpc/i'        =>  'Mac OS 9',
                       '/linux/i'              =>  'Linux',
                       '/ubuntu/i'             =>  'Ubuntu',
                       '/iphone/i'             =>  'iPhone',
                       '/ipod/i'               =>  'iPod',
                       '/ipad/i'               =>  'iPad',
                       '/android/i'            =>  'Android',
                       '/blackberry/i'         =>  'BlackBerry',
                       '/webos/i'              =>  'Mobile');

    $os_platform = "SO Desconocido";
    foreach ($os_array as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    return $os_platform;
  }
  
}

function Array2Auditor() {return new Array2Auditor();} 
?>
