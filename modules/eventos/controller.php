<?php
require_once "modules/eventos/view.php";
require_once "modules/eventos/model.php";


class EventosController {

	function __construct() {
		$this->model = new Eventos();
		$this->view = new EventosView();
	}
  
	function panel() {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
		$eventos = $this->model->traer_eventos();
    $this->view->panel($eventos);
	}	
  
  function traer_form_editar_evento_ajax($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $evento_id = $argumentos[0];
    
    $this->model->evento_id = $evento_id;
		$evento = $this->model->get();
    $this->view->traer_form_editar_evento_ajax($evento);
  }
  
  function consultar_evento_ajax($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $evento_id = $argumentos[0];
    
    $this->model->evento_id = $evento_id;
		$evento = $this->model->get();
    $this->view->consultar_evento_ajax($evento);
  }
  
  function guardar() {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
    $this->model->ubicacion = filter_input(INPUT_POST, 'ubicacion');
    $this->model->fecha = filter_input(INPUT_POST, 'fecha');
    $this->model->guardar();
    header("Location: /" . APP_NAME . "/eventos/panel");
  }
  
  function actualizar() {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $evento_id = filter_input(INPUT_POST, 'evento_id');
    $this->model->evento_id = $evento_id;
    $this->model->cargar_modelo();
    $this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
    $this->model->ubicacion = filter_input(INPUT_POST, 'ubicacion');
    $this->model->fecha = filter_input(INPUT_POST, 'fecha');
    $this->model->guardar();
    header("Location: /" . APP_NAME . "/eventos/panel");
  }
  
  function eliminar($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $evento_id = $argumentos[0];
    $this->model->evento_id = $evento_id;
    $this->model->eliminar();
    header("Location: /" . APP_NAME . "/eventos/panel");
  }
  
  
  
  
  
  
  
  
  
  function editar($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,3,5,99');
    $evento_id = $argumentos[0];
    $mensaje_id = $argumentos[1];
    
    switch($mensaje_id) {
			case 1:
				$array_msj = array("{mensaje}"=>"",
													 "{display}"=>"none",
                           "{btn_comprobante_display}"=>"none");
				break;
			case 5:
				$array_msj = array("{mensaje}"=>"Ha ocurrido un error, pruebe nuevamente por favor. Disculpe las molestias, muchas gracias.",
													 "{display}"=>"show",
                           "{btn_comprobante_display}"=>"none");
        break;
		}
    
    $this->model->evento_id = $evento_id;
		$evento = $this->model->get();    
    $this->view->editar($evento, $array_msj);
	}	
  
  function consultar($argumentos) {
    SessionHandling::check();
    $evento_id = $argumentos[0];
    
    $this->model->evento_id = $evento_id;
		$evento = $this->model->get();   
    
    $this->view->consultar($evento);
	}	
  
  
  
  
  
  
  
}
?>