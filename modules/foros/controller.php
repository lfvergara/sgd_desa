<?php
require_once "modules/foros/view.php";
require_once "modules/foros/model.php";


class ForosController {

	function __construct() {
		$this->model = new Foros();
		$this->view = new ForosView();
	}
  
	function m_agregar() {
    SessionHandling::check();
    
    $this->model->codigo = 'ACT';
    $temp_activos = $this->model->traer_foros_estados();
    $temp_activos = (is_array($temp_activos) AND !empty($temp_activos)) ? $temp_activos : array();
    $cantidad_activos = count($temp_activos);
    
    $activos = array();
    if ($cantidad_activos > 0) {
      $j = ($cantidad_activos > 5) ? 4 : $cantidad_activos;
      for($i = 0; $i < $j; $i++) {
        $activos[] = $temp_activos[$i]; 
      }
    }
    
		$this->view->m_agregar($activos);
	}	
  
  function guardar_nuevo_foro() {
    SessionHandling::check();
    $this->model->tema = filter_input(INPUT_POST, 'tema');
    $this->model->contenido = filter_input(INPUT_POST, 'contenido');
    $this->model->codigo = filter_input(INPUT_POST, 'denominacion');
    $this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
    $this->model->usuario_id = $_SESSION['sesion.usuario_id'];
    $this->model->fecha = date('Y-m-d');
    $this->model->guardar();
    header("Location: /" . APP_NAME . "/foros/m_panel");
  }
  
  function guardar_nueva_respuesta() {
    SessionHandling::check();
    $this->model->mensaje = filter_input(INPUT_POST, 'mensaje');
    $this->model->foro_id = filter_input(INPUT_POST, 'foro_id');
    $this->model->usuario_id = $_SESSION['sesion.usuario_id'];
    $this->model->fecha = date('Y-m-d');
    $this->model->activo = 0;
    $this->model->guardar_respuesta_foro();
    header("Location: /" . APP_NAME . "/foros/m_panel");
  }
  
  function administrar($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('99');
    
    $this->model->codigo = 'PEN';
    $pendientes = $this->model->traer_foros_estados();
    $pendientes = (is_array($pendientes) AND !empty($pendientes)) ? $pendientes : array();
    
    $this->model->codigo = 'ACT';
    $activos = $this->model->traer_foros_estados();
    $activos = (is_array($activos) AND !empty($activos)) ? $activos : array();
    
    $this->model->codigo = 'CER';
    $cerrados = $this->model->traer_foros_estados();
    $cerrados = (is_array($cerrados) AND !empty($cerrados)) ? $cerrados : array();
    
    $this->model->codigo = 'REC';
    $rechazados = $this->model->traer_foros_estados();
    $rechazados = (is_array($rechazados) AND !empty($rechazados)) ? $rechazados : array();
    
    $array_cantidades_estados = array('{cant_pendientes}'=>count($pendientes),
                                      '{cant_activos}'=>count($activos),
                                      '{cant_cerrados}'=>count($cerrados),
                                      '{cant_rechazados}'=>count($rechazados));
    
    $this->model->codigo = 'ACT';
    $this->model->activo = 0;
    $cant_respuestas_pendientes = $this->model->cantidad_total_respuestas_pendientes();
    $cant_respuestas_pendientes = (is_array($cant_respuestas_pendientes) AND !empty($cant_respuestas_pendientes)) ? $cant_respuestas_pendientes[0]['cantidad'] : 0;
    
    $mensaje_id = $argumentos[0];
    switch($mensaje_id) {
			case 1:
				$array_msj = array("{mensaje}"=>"", "{display}"=>"none");
				break;
			case 2:
				$array_msj = array("{mensaje}"=>"El foro ha sido ACTIVADO correctamente. Gracias.", "{display}"=>"show");
        break;
			case 3:
				$array_msj = array("{mensaje}"=>"El foro ha sido CERRADO correctamente. Gracias.", "{display}"=>"show");
				break;
			case 4:
				$array_msj = array("{mensaje}"=>"El foro ha sido RECHAZADO correctamente. Gracias.", "{display}"=>"show");
				break;
		}
    
    $this->view->administrar($pendientes, $activos, $array_msj, $array_cantidades_estados, $cant_respuestas_pendientes);
	}	
  
  function administrar_cerrados($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('99');
    
    $this->model->codigo = 'CER';
    $cerrados = $this->model->traer_foros_estados();
    $cerrados = (is_array($cerrados) AND !empty($cerrados)) ? $cerrados : array();
    
    $this->model->codigo = 'REC';
    $rechazados = $this->model->traer_foros_estados();
    $rechazados = (is_array($rechazados) AND !empty($rechazados)) ? $rechazados : array();
    
    $this->view->administrar_cerrados($cerrados, $rechazados);
	}	
  
  function administrar_foro_ajax($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('99');
    
    $foro_id = $argumentos[0];
    $this->model->foro_id = $foro_id;
    $foro = $this->model->get();
    $estado = $foro['codigo'];
    switch($estado) {
      case 'PEN':
        $html = 'administrar_pendiente';
        break;
      case 'ACT':
        $html = 'administrar_activo';
        break;
      case 'CER':
        $html = 'administrar_cerrado';
        break;
      case 'REC':
        $html = 'administrar_rechazado';
        break;
    }
    
    $this->view->administrar_foro_ajax($foro, $html);
  }
  
  function administrar_respuestas($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('99');
    
    $this->model->codigo = 'ACT';
    $this->model->activo = 0;
    $respuestas_pendientes = $this->model->lista_foros_respuestas_pendientes();    
    $respuestas_pendientes = (is_array($respuestas_pendientes) AND !empty($respuestas_pendientes)) ? $respuestas_pendientes : array();
    
    $mensaje_id = $argumentos[0];
    switch($mensaje_id) {
			case 1:
				$array_msj = array("{mensaje}"=>"", "{display}"=>"none");
				break;
			case 2:
				$array_msj = array("{mensaje}"=>"La respuesta ha sido ACTIVADA correctamente. Gracias.", "{display}"=>"show");
        break;
			case 3:
				$array_msj = array("{mensaje}"=>"La respuesta ha sido DESACTIVADA correctamente. Gracias.", "{display}"=>"show");
				break;
		}
    
    $this->view->administrar_respuestas($respuestas_pendientes, $array_msj);
	}
  
  function administrar_foro_respuestas_ajax($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('99');
    
    $foro_id = $argumentos[0];
    $this->model->foro_id = $foro_id;
    $foro = $this->model->get();
    
    $this->model->activo = 0;
    $respuestas_pendientes = $this->model->lista_respuestas_foro_estado();
    $this->model->activo = 1;
    $respuestas_activas = $this->model->lista_respuestas_foro_estado();
    $this->view->administrar_foro_respuestas_ajax($foro, $respuestas_activas, $respuestas_pendientes);
  }
  
  function guardar_estado_foro($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('99');
    
    $foro_id = $argumentos[0];
    $estado = $argumentos[1];
    $this->model->foro_id = $foro_id;
    $this->model->cargar_modelo_foro();
    
    
    switch($estado) {
      case 1:
        $this->model->codigo = 'PEN';
        $this->model->denominacion = 'PENDIENTE';
        break;
      case 2:
        $this->model->codigo = 'ACT';
        $this->model->denominacion = 'ACTIVO';
        $mensaje_id = 2;
        break;
      case 3:
        $this->model->codigo = 'CER';
        $this->model->denominacion = 'CERRADO';
        $mensaje_id = 3;
        break;
      case 4:
        $this->model->codigo = 'REC';
        $this->model->denominacion = 'RECHAZADO';
        $mensaje_id = 4;
        break;
    }
    
    $this->model->usuario_id = $_SESSION['sesion.usuario_id'];
    $this->model->guardar_estado_foro();
    header("Location: /" . APP_NAME . "/foros/administrar/{$mensaje_id}");
  }
  
  function cambiar_estado_respuesta($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('99');
    
    $fororespuesta_id = $argumentos[0];
    $activo = $argumentos[1];
    
    $this->model->fororespuesta_id = $fororespuesta_id;
    $this->model->activo = $activo;
    $this->model->cambiar_activo_respuesta();
    
    $mensaje_id = ($activo == 0) ? 3 : 2;
    header("Location: /" . APP_NAME . "/foros/administrar_respuestas/{$mensaje_id}");
  }
  
  function m_consultar($argumentos) {
    SessionHandling::check();
    
    $foro_id = $argumentos[0];
    $this->model->foro_id = $foro_id;
		$foro = $this->model->get();
    
    $this->model->activo = 1;
    $respuestas_activas = $this->model->lista_respuestas_foro_estado();
    
    $this->view->m_consultar($foro, $respuestas_activas);
  }
  
   function m_panel() {
    SessionHandling::check();
    
    $this->model->codigo = 'ACT';
    $this->model->activo = 1;
    $activos = $this->model->traer_foros_respuestas_matriculados();
    $activos = (is_array($activos) AND !empty($activos)) ? $activos : array();
    
    $this->view->m_panel($activos);
	}	
  
  
  
  
  
  
  
  /*************************************************************************************************************************************** */
  
  function editar($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $foro_id = $argumentos[0];
    $mensaje_id = $argumentos[1];
    
    switch($mensaje_id) {
			case 1:
				$array_msj = array("{mensaje}"=>"",
													 "{display}"=>"none",
                           "{btn_comprobante_display}"=>"none");
				break;
			case 2:
				$array_msj = array("{mensaje}"=>"La imagen se ha subido correctamente. Muchas gracias.",
													 "{display}"=>"show",
                           "{btn_comprobante_display}"=>"block");
        break;
			case 3:
				$array_msj = array("{mensaje}"=>"El archivo es demasiado grande. El límite de subida es 20MB.",
													 "{display}"=>"show",
                           "{btn_comprobante_display}"=>"none");
				break;
			case 4:
				$array_msj = array("{mensaje}"=>"Sólo se admiten archivos de tipo JPG o PNG.",
													 "{display}"=>"show",
                           "{btn_comprobante_display}"=>"none");
				break;
      case 5:
				$array_msj = array("{mensaje}"=>"Ha ocurrido un error, pruebe nuevamente por favor. Disculpe las molestias, muchas gracias.",
													 "{display}"=>"show",
                           "{btn_comprobante_display}"=>"none");
        break;
		}
    
    $this->model->foro_id = $foro_id;
		$foro = $this->model->get();    
    $this->view->editar($foro, $array_msj);
	}	
  
  function consultar($argumentos) {
    SessionHandling::check();
    $foro_id = $argumentos[0];
    
    $this->model->foro_id = $foro_id;
		$foro = $this->model->get();   
    
    $this->view->consultar($foro);
	}	
  
  function guardar() {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
    $this->model->contenido = filter_input(INPUT_POST, 'contenido');
    $this->model->activo = 0;
    $this->model->destacado = 0;
    $this->model->fecha = date('Y-m-d');
    $this->model->guardar();
    header("Location: /" . APP_NAME . "/foros/panel");
  }
  
  function actualizar() {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $foro_id = filter_input(INPUT_POST, 'foro_id');
    $this->model->foro_id = $foro_id;
    $this->model->cargar_modelo_foro();
    $this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
    $this->model->contenido = filter_input(INPUT_POST, 'contenido');
    $this->model->fecha = date('Y-m-d');
    $this->model->guardar();
    header("Location: /" . APP_NAME . "/foros/editar/{$foro_id}");
  }
  
  function guardar_archivo() {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $foro_id = filter_input(INPUT_POST, 'foro_id');
    $this->model->foro_id = $foro_id;
    
    $archivo = $_FILES['archivo'];
    $formato = $archivo['type'];
    $tamano = $archivo['size'];

    $limite_filesize = 20 * 1048576;
    
    $mimes_permitidos = array("image/jpeg", "image/png", "image/gif");
    if($_FILES['archivo']['error']==0) {
      if(in_array($formato, $mimes_permitidos)) {
        if ($tamano < $limite_filesize) {
          FileHandler::save_file($archivo, 'foros', $foro_id);
          header("Location: /" . APP_NAME . "/foros/editar/{$foro_id}/2");
        } else {
          header("Location: /" . APP_NAME . "/foros/editar/{$foro_id}/3");	
        }
      } else {
        header("Location: /" . APP_NAME . "/foros/editar/{$foro_id}/4");	
      }
    } else {
      header("Location: /" . APP_NAME . "/foros/editar/{$foro_id}/5");	
    }     
  }
  
  function destacar_foro($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $foro_id = $argumentos[0];
    $this->model->foro_id = $foro_id;
    $this->model->destacado = 1;
    $this->model->desactivar_destacado_foros();
    $this->model->destacar_foro();
    header("Location: /" . APP_NAME . "/foros/panel");
  }
  
  function activar_foro($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $foro_id = $argumentos[0];
    $this->model->foro_id = $foro_id;
    $this->model->activar_foro();
    header("Location: /" . APP_NAME . "/foros/panel");
  }
  
  function desactivar_foro($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $foro_id = $argumentos[0];
    $this->model->foro_id = $foro_id;
    $this->model->desactivar_foro();
    header("Location: /" . APP_NAME . "/foros/panel");
  }
  
  function ver_imagen($argumentos) {
     $carpeta = $argumentos[0];
     $archivo = $argumentos[1];
     FileHandler::get_file($carpeta."/".$archivo);
  }
  
  function eliminar($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $foro_id = $argumentos[0];
    $this->model->foro_id = $foro_id;
    $this->model->eliminar();
    FileHandler::delete_foro_files($foro_id);
    header("Location: /" . APP_NAME . "/foros/panel");
  }
  
}
?>