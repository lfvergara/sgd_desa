<?php

/**
 * Herramientas para manipular sesiones.
 */
class SessionHandling {

  static function create($datos) {
    $navegador = $_SERVER['HTTP_USER_AGENT'];
    if(strpos($navegador, 'Maxthon') !== FALSE) {
			$navegador = "Maxthon";
      $flag_exit = 1;
    } elseif(strpos($navegador, 'Chromium') !== FALSE) {
			$navegador = 'Chromium';
      $flag_exit = 1;
    }	elseif(strpos($navegador, 'Iceweasel') !== FALSE) {
			$navegador = 'Iceweasel';
      $flag_exit = 1;
    }	elseif(strpos($navegador, 'Edge') !== FALSE) {
      $navegador = 'Microsoft Edge';
      $flag_exit = 1;
    } elseif(strpos($navegador, 'Trident') !== FALSE) {
			$navegador = 'Internet Explorer';
      $flag_exit = 1;
    } elseif(strpos($navegador, 'MSIE') !== FALSE) {
			$navegador = 'Internet Explorer';
      $flag_exit = 1;
    } elseif(strpos($navegador, 'Opera Mini') !== FALSE) {
			$navegador = "Opera Mini";
      $flag_exit = 1;
    } elseif(strpos($navegador, 'Opera') || strpos($navegador, 'OPR') !== FALSE) {
			$navegador = "Opera";
      $flag_exit = 1;
    } elseif(strpos($navegador, 'Firefox') !== FALSE) {
			$navegador = 'Mozilla Firefox';
      $flag_exit = 1;
    } elseif(strpos($navegador, 'Chrome') !== FALSE) {
			$navegador = 'Google Chrome';
      $flag_exit = 0;
    } elseif(strpos($navegador, 'Safari') !== FALSE) {
			$navegador = "Safari";
      $flag_exit = 1;
    } elseif(strpos($navegador, 'iTunes') !== FALSE) {
			$navegador = 'iTunes';
      $flag_exit = 1;
    } elseif(strpos($navegador, 'Netscape') !== FALSE) {
			$navegador = 'Netscape';
      $flag_exit = 1;
    } elseif(strpos($navegador, 'Links') !== FALSE) {
			$navegador = 'Links';
      $flag_exit = 1;
    } elseif(strpos($navegador, 'Lynx') !== FALSE) {
			$navegador = 'Lynx';
      $flag_exit = 1;
    } elseif(strpos($navegador, 'w3m') !== FALSE) {
			$navegador = 'w3m';
      $flag_exit = 1;
    } else{
      $navegador = 'No hemos podido detectar su navegador';
      $flag_exit = 1;
    }
    
    foreach ($datos as $clave => $valor) $_SESSION["sesion.{$clave}"] = $valor;
    $_SESSION["sesion.comprobante_ingreso"] = 0;
    $_SESSION["sesion.navegador"] = $navegador;
    $_SESSION["sesion.navegador_flag"] = $flag_exit;
    $_SESSION[md5(APP_NAME)] = true;
  }

  static function check() {
    if($_SESSION[md5(APP_NAME)]===false) {
      SessionHandling::destroy();
    }
    
    //if(!$_SERVER['HTTP_REFERER']) SessionHandling::destroy();
  }
  
  static function checkGrupo($grupo_id) {
    $session_grupo_id = $_SESSION['sesion.grupo_id'];
    $grupo_id = explode(',', $grupo_id);
    if ($session_grupo_id == 2) {
        SessionHandling::destroy();
    } else {
      if(in_array(0, $grupo_id)) return false;
      
      if(1 == $session_grupo_id || 99 == $session_grupo_id) {
        return false;
      } else {
        if(in_array($session_grupo_id, $grupo_id)) {
          return false;
        } else {
          SessionHandling::destroy();
        }
      }
    }
  }
  
  static function actualizar() {
    $session_grupo_id = $_SESSION['sesion.grupo_id'];
    $flag = $_SESSION["sesion.actualizacion"];
    $terminos_condiciones = $_SESSION["sesion.terminos_condiciones"];
    if ($session_grupo_id == 2) {
      if ($terminos_condiciones != 2) {
        header("Location: /" . APP_NAME . "/usuarios/actualizar_terminos_condiciones");
      } else {
        if($flag == 0 OR $flag == 2) {
          return false; 
        } else {
          header("Location: /" . APP_NAME . "/usuarios/actualizar_informacion");
        }
      }
    } else {
      return false;
    }
  }

  static function destroy() {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
     $params = session_get_cookie_params();
     setcookie(session_name(), '',
             time() - 42000,
             $params["path"],
             $params["domain"],
             $params["secure"],
             $params["httponly"]);
    }
    session_destroy();
    $_SESSION[md5(APP_NAME)] = false;
    header("Location: http://www.cpcelr.org.ar");
  }
  
  static function destroy_sin_redirect() {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
     $params = session_get_cookie_params();
     setcookie(session_name(), '',
             time() - 42000,
             $params["path"],
             $params["domain"],
             $params["secure"],
             $params["httponly"]);
    }
    session_destroy();
    $_SESSION[md5(APP_NAME)] = false;
  }
}
?>