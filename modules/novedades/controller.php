<?php
require_once "modules/novedades/view.php";
require_once "modules/novedades/model.php";


class NovedadesController {

	function __construct() {
		$this->model = new Novedades();
		$this->view = new NovedadesView();
	}
  
	function panel() {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
		$novedades = $this->model->traer_novedades();
    $this->view->panel($novedades);
	}	
  
  function editar($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $novedad_id = $argumentos[0];
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
    
    $this->model->novedad_id = $novedad_id;
		$novedad = $this->model->get();    
    $this->view->editar($novedad, $array_msj);
	}	
  
  function consultar($argumentos) {
    SessionHandling::check();
    $novedad_id = $argumentos[0];
    
    $this->model->novedad_id = $novedad_id;
		$novedad = $this->model->get();   
    
    $this->view->consultar($novedad);
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
    header("Location: /" . APP_NAME . "/novedades/panel");
  }
  
  function actualizar() {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $novedad_id = filter_input(INPUT_POST, 'novedad_id');
    $this->model->novedad_id = $novedad_id;
    $this->model->cargar_modelo_novedad();
    $this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
    $this->model->contenido = filter_input(INPUT_POST, 'contenido');
    $this->model->fecha = date('Y-m-d');
    $this->model->guardar();
    header("Location: /" . APP_NAME . "/novedades/editar/{$novedad_id}");
  }
  
  function guardar_archivo() {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $novedad_id = filter_input(INPUT_POST, 'novedad_id');
    $this->model->novedad_id = $novedad_id;
    
    $archivo = $_FILES['archivo'];
    $formato = $archivo['type'];
    $tamano = $archivo['size'];

    $limite_filesize = 20 * 1048576;
    
    $mimes_permitidos = array("image/jpeg", "image/png", "image/gif");
    if($_FILES['archivo']['error']==0) {
      if(in_array($formato, $mimes_permitidos)) {
        if ($tamano < $limite_filesize) {
          FileHandler::save_file($archivo, 'novedades', $novedad_id);
          header("Location: /" . APP_NAME . "/novedades/editar/{$novedad_id}/2");
        } else {
          header("Location: /" . APP_NAME . "/novedades/editar/{$novedad_id}/3");	
        }
      } else {
        header("Location: /" . APP_NAME . "/novedades/editar/{$novedad_id}/4");	
      }
    } else {
      header("Location: /" . APP_NAME . "/novedades/editar/{$novedad_id}/5");	
    }     
  }
  
  function destacar_novedad($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $novedad_id = $argumentos[0];
    $this->model->novedad_id = $novedad_id;
    $this->model->destacado = 1;
    $this->model->desactivar_destacado_novedades();
    $this->model->destacar_novedad();
    header("Location: /" . APP_NAME . "/novedades/panel");
  }
  
  function activar_novedad($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $novedad_id = $argumentos[0];
    $this->model->novedad_id = $novedad_id;
    $this->model->activar_novedad();
    header("Location: /" . APP_NAME . "/novedades/panel");
  }
  
  function desactivar_novedad($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $novedad_id = $argumentos[0];
    $this->model->novedad_id = $novedad_id;
    $this->model->desactivar_novedad();
    header("Location: /" . APP_NAME . "/novedades/panel");
  }
  
  function ver_imagen($argumentos) {
     $carpeta = $argumentos[0];
     $archivo = $argumentos[1];
     FileHandler::get_file($carpeta."/".$archivo);
  }
  
  function eliminar($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $novedad_id = $argumentos[0];
    $this->model->novedad_id = $novedad_id;
    $this->model->eliminar();
    FileHandler::delete_novedad_files($novedad_id);
    header("Location: /" . APP_NAME . "/novedades/panel");
  }
  
}
?>