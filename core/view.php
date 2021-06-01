<?php


abstract class View {

    function render_login($contenido=NULL) {
      if(is_null($contenido)) {
        $plantilla = file_get_contents("static/login.html");
      } else {
        $plantilla = $contenido;  
      }
      
      $dict = array("{app_nombre}"=>APP_TITTLE,
                    "{url_app}"=>URL_APP,
                    "{theme_path}"=>THEME_PATH,
                    "{url_static}"=>URL_STATIC,
                    "{app_name}"=>APP_NAME);
      return $this->render($dict, $plantilla);
    }

    function render_template($menu, $contenido) {
      $modulo = "{" . $GLOBALS['modulo'] . "}";

      $dict = array(
      	  "{$modulo}"=>"active",
      	  "{theme_path}"=>THEME_PATH,
		  		"{menu}"=>$menu,
          "{contenido}"=>$contenido
        );

      $plantilla = file_get_contents(TEMPLATE);
      $plantilla = $this->render($dict, $plantilla);
      $plantilla = str_replace('{app_name}', APP_NAME, $plantilla);
      return $plantilla;
    }

    function render($dict, $html) {
        $render = str_replace(array_keys($dict), array_values($dict), $html);
        return $render;
    }

    function get_regex($tag, $html, $limit=true) {
        if ($limit == true) {
            $pcre_limit = ini_set("pcre.recursion_limit", 10000);
        }
        $regex = "/<!--$tag-->(.|\n){1,}<!--$tag-->/";
        preg_match($regex, $html, $coincidencias);
        if ($limit == true) {
            ini_set("pcre.recursion_limit", $pcre_limit);
        }
        return $coincidencias[0];
    }

    function render_regex($tag, $base, $coleccion, $limit=true) {
			$render = '';
			$codigo = $this->get_regex($tag, $base, $limit);
			$coleccion = $this->set_collection_dict($coleccion);
			foreach($coleccion as $dict) {
				$render .= $this->render($dict, $codigo);
			}
			
			$render_final = str_replace($codigo, $render, $base);
			return $render_final;
    }

    function render_regex_dict($tag, $base, $coleccion) {
        $render = '';
        $codigo = $this->get_regex($tag, $base);
        foreach($coleccion as $dict) {
            $render .= $this->render($dict, $codigo);
        }
        $render_final = str_replace($codigo, $render, $base);
        return $render_final;
    }

    function set_dict($obj) {
        $new_dict = array();
        foreach($obj as $clave=>$valor) {
            if (is_object($valor)) {
                $new_dict = array_merge($new_dict, $this->set_dict($valor));
            } else {
                //$name_object = strtolower(get_class($obj));
                //$new_dict["{{$name_object}-{$clave}}"] = $valor;
				        $new_dict["{{$clave}}"] = $valor;
            }
        }
        return $new_dict;
    }

    function set_collection_dict($collection) {
        $new_array = array();
        foreach($collection as $obj) $new_array[] = $this->set_dict($obj);
        return $new_array;
    }

    function order_collection_dict($collection, $column, $criterion) {
        $array_temp = array();
        foreach ($collection as $array) {
            $array_temp[] = $array["{{$column}}"];
        }
        array_multisort($array_temp, $criterion, $collection);
        print_r($collection);
        return $collection;
    }

    function order_collection_array($collection, $column, $criterion) {
        $array_temp = array();
        foreach ($collection as $array) {
            $array_temp[] = $array["{$column}"];
        }
        array_multisort($array_temp, $criterion, $collection);
        return $collection;
    }

    function order_collection_objects($collection, $column, $criterion) {
        $array_temp = array();
        foreach ($collection as $array) {
            $array_temp[] = $array->$column;
        }
        array_multisort($array_temp, $criterion, $collection);
        return $collection;
    }

    function descomponer_fecha($fecha='') {
        $dia = date('d');
        $dias_semana = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
        $dia_semana = date('w');
        $dia_semana = $dias_semana[$dia_semana];
        $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre');
        $mes = date('m');
        $mes = $mes - 1;
        $mes = $meses[$mes];
        $anio = date('Y');

        $array_fecha = array(
            "{fecha_dia}" => $dia,
            "{fecha_dia_semana}" => $dia_semana,
            "{fecha_mes}" => $mes,
            "{fecha_anio}" => $anio);

        return $array_fecha;
    }
  
    function genera_menu() {
      switch ($_SESSION['sesion.grupo_id']) {
        case 1:
          $home = "none";
          $admin = "block";
          $administrativa = "block";
          $tecnica = "block";
          $matriculados = "block";
          $asistente = "block";
          $encuesta = "block";
          $curriculum = "block";
          $novedad = "block";
          $opinion = "block";
          $foro = "block";
          $desarrollador = "none";
          $adm_usuario = "block";
          $manual_usuario = "MUAdmin";
          break;
        case 2:
          $home = "none";
          $admin = "none";
          $administrativa = "none";
          $tecnica = "none";
          $matriculados = "block";
          $asistente = "none";
          $encuesta = "none";
          $curriculum = "block";
          $novedad = "none";
          $opinion = "block";
          $foro = "block";
          $desarrollador = "none";
          $adm_usuario = "none";
          $manual_usuario = "MUMatriculado";
          break;
        case 3:
          $home = "none";
          $admin = "none";
          $administrativa = "none";
          $tecnica = "block";
          $matriculados = "none";
          $asistente = "none";
          $encuesta = "none";
          $curriculum = "none";
          $novedad = "none";
          $opinion = "none";
          $foro = "none";
          $desarrollador = "none";
          $adm_usuario = "none";
          $manual_usuario = "MUAdmin";
          break;
        case 4:
          $home = "none";
          $admin = "none";
          $administrativa = "block";
          $tecnica = "none";
          $matriculados = "none";
          $asistente = "none";
          $encuesta = "none";
          $curriculum = "none";
          $novedad = "none";
          $opinion = "none";
          $foro = "none";
          $desarrollador = "none";
          $adm_usuario = "none";
          $manual_usuario = "MUAdministrativo";
          break;
       case 5:
          $home = "none";
          $admin = "none";
          $administrativa = "none";
          $tecnica = "none";
          $matriculados = "none";
          $asistente = "block";
          $encuesta = "none";
          $curriculum = "none";
          $novedad = "none";
          $opinion = "none";
          $foro = "none";
          $desarrollador = "none";
          $adm_usuario = "none";
          $mis_datos = "none";
          $manual_usuario = "MUAdministrativo";
          break;
       case 98:
          $home = "none";
          $admin = "block";
          $administrativa = "block";
          $tecnica = "block";
          $matriculados = "block";
          $asistente = "block";
          $encuesta = "block";
          $curriculum = "block";
          $novedad = "block";
          $opinion = "block";
          $foro = "block";
          $desarrollador = "none";
          $adm_usuario = "block";
          $manual_usuario = "MUAdmin";
          break;
        case 99:
          $home = "none";
          $admin = "block";
          $administrativa = "block";
          $tecnica = "block";
          $matriculados = "block";
          $asistente = "block";
          $encuesta = "block";
          $curriculum = "block";
          $novedad = "block";
          $opinion = "block";
          $foro = "block";
          $desarrollador = "block";
          $adm_usuario = "block";
          $manual_usuario = "MUAdmin";
          break;
        default:
          $home = "none";
          $admin = "none";
          $administrativa = "none";
          $tecnica = "none";
          $matriculados = "none";
          $asistente = "none";
          $encuesta = "none";
          $curriculum = "none";
          $novedad = "none";
          $opinion = "none";
          $foro = "none";
          $desarrollador = "none";
          $adm_usuario = "none";
          $manual_usuario = "MUAdmin";
          break;
      }

      $restricciones = array("{home}"=>$home, 
                             "{admin}"=>$admin, 
                             "{administrativa}"=>$administrativa, 
                             "{tecnica}"=>$tecnica, 
                             "{matriculados}"=>$matriculados, 
                             "{asistente}"=>$asistente, 
                             "{encuesta}"=>$encuesta, 
                             "{curriculum}"=>$curriculum, 
                             "{novedad}"=>$novedad, 
                             "{opinion}"=>$opinion, 
                             "{foro}"=>$foro, 
                             "{desarrollador}"=>$desarrollador, 
                             "{adm_usuario}"=>$adm_usuario, 
                             "{manual_usuario}"=>$manual_usuario,
                             "{app_name}"=>APP_NAME);
      return $restricciones;
    }
}
?>
