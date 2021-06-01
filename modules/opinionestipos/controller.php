<?php
require_once "modules/opinionestipos/view.php";
require_once "modules/opinionestipos/model.php";


class OpinionesTiposController {

	function __construct() {
		$this->model = new OpinionesTipos();
		$this->view = new OpinionesTiposView();
	}
  
	function panel() {
    SessionHandling::check();
    SessionHandling::checkGrupo('99');
		$tipos = $this->model->traer_opinionestipos();
    $this->view->panel($tipos);
	}	
  
  function editar($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('99');
    $opiniontipo_id = $argumentos[0];
    $mensaje_id = $argumentos[1];
    
    switch($mensaje_id) {
			case 1:
				$array_msj = array("{mensaje}"=>"",
													 "{display}"=>"none");
				break;
			case 2:
				$array_msj = array("{mensaje}"=>"El tipo de opinión se ha editado correctamente. Muchas gracias.",
													 "{display}"=>"show",
                           "{btn_comprobante_display}"=>"block");
        break;
		}
    
    $this->model->opiniontipo_id = $opiniontipo_id;
		$tipo = $this->model->get();    
    $this->view->editar($tipo, $array_msj);
	}
  
  function guardar() {
    SessionHandling::check();
    SessionHandling::checkGrupo('99');
    $this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
    $this->model->guardar();
    header("Location: /" . APP_NAME . "/opinionestipos/panel");
  }
  
  function actualizar() {
    SessionHandling::check();
    SessionHandling::checkGrupo('99');
    $opiniontipo_id = filter_input(INPUT_POST, 'opiniontipo_id');
    $this->model->opiniontipo_id = $opiniontipo_id;
    $this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
    $this->model->guardar();
    header("Location: /" . APP_NAME . "/opinionestipos/editar/{$opiniontipo_id}/2");
  }
  
  function eliminar($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('99');
    $opiniontipo_id = $argumentos[0];
    $this->model->opiniontipo_id = $opiniontipo_id;
    $this->model->eliminar();
    header("Location: /" . APP_NAME . "/opinionestipos/panel");
  }
}
?>