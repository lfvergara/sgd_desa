<?php
require_once "modules/opiniones/view.php";
require_once "modules/opiniones/model.php";
require_once "modules/opinionestipos/model.php";
require_once "modules/matriculados/model.php";
require_once "tools/PHPExcel/array2excel.php";


class OpinionesController {

	function __construct() {
		$this->model = new Opiniones();
		$this->view = new OpinionesView();
	}
  
	function panel() {
    SessionHandling::check();
    SessionHandling::checkGrupo('98,99');
		$opiniones = $this->model->traer_opiniones();
    $otm = new OpinionesTipos();
		$tipos = $otm->traer_opinionestipos();
    $this->view->panel($opiniones, $tipos);
  }
  
  function agregar($argumentos) {
    SessionHandling::check();
    $mensaje_id = $argumentos[0];
    
    switch($mensaje_id) {
			case 1:
				$array_msj = array("{mensaje}"=>"",
													 "{display}"=>"none");
				break;
			case 2:
				$array_msj = array("{mensaje}"=>"Su opinión se ha enviado correctamente. Muchas gracias.",
													 "{display}"=>"show");
        break;
		}
    
    $matricula_id = $_SESSION['sesion.matricula_id'];
    $mm = new Matriculados();
    $mm->matricula_id = $matricula_id;
    $matriculado = $mm->traer_matricula_matriculado();
    
    $otm = new OpinionesTipos();
		$tipos = $otm->traer_opinionestipos();
    
    $this->view->agregar($matriculado, $tipos, $array_msj);
  }
  
  function dgip($argumentos) {
    SessionHandling::check();
    $mensaje_id = $argumentos[0];
    
    switch($mensaje_id) {
			case 1:
				$array_msj = array("{mensaje}"=>"",
													 "{display}"=>"none");
				break;
			case 2:
				$array_msj = array("{mensaje}"=>"Su opinión se ha enviado correctamente. Muchas gracias.",
													 "{display}"=>"show");
        break;
		}
    
    $matricula_id = $_SESSION['sesion.matricula_id'];
    $mm = new Matriculados();
    $mm->matricula_id = $matricula_id;
    $matriculado = $mm->traer_matricula_matriculado();
    
    $this->view->dgip($matriculado, $array_msj);
  }
  
  function guardar() {
    SessionHandling::check();
    SessionHandling::checkGrupo('98,99');    
    $this->model->opinion = filter_input(INPUT_POST, 'opinion');
    $this->model->fecha = date('Y-m-d');
    $this->model->hora = date('H:i:s');
    $this->model->opiniontipo_id = filter_input(INPUT_POST, 'opiniontipo_id');
    $this->model->matriculado_id = filter_input(INPUT_POST, 'matriculado_id');
    $this->model->guardar();
    header("Location: /" . APP_NAME . "/opiniones/agregar/2");
  }
  
  function guardar_dgip() {
    SessionHandling::check();
    $this->model->opinion = filter_input(INPUT_POST, 'opinion');
    $this->model->fecha = date('Y-m-d');
    $this->model->hora = date('H:i:s');
    $this->model->opiniontipo_id = filter_input(INPUT_POST, 'opiniontipo_id');
    $this->model->matriculado_id = filter_input(INPUT_POST, 'matriculado_id');
    $this->model->guardar();
    header("Location: /" . APP_NAME . "/opiniones/dgip/2");
  }
  
  function consultar($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('98,99');
    $opinion_id = $argumentos[0];
    
    $this->model->opinion_id = $opinion_id;
		$opinion = $this->model->get();    
    $this->view->consultar($opinion);
	}
  
  function eliminar($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('98,99');
    $opinion_id = $argumentos[0];
    $this->model->opinion_id = $opinion_id;
    $this->model->eliminar();
    header("Location: /" . APP_NAME . "/opiniones/panel");
  }
  
  function exportar() {
		$this->model->opiniontipo_id = filter_input(INPUT_POST, 'opiniontipo_id');
    $datos = $this->model->listar_tipo_opinion();
    $array_encabezados = array('FECHA', 'HORA', 'TEMA', 'OPINIÓN', 'MATRICULADO', 'EMAIL', 'CELULAR');
		$array_exportacion = array();
		$array_exportacion[] = $array_encabezados;
		foreach ($datos as $clave=>$valor) {
			$array_temp = array();
			$array_temp = array(
						  $valor["fecha"]
						, $valor["hora"]
						, $valor["tipo"]
						, $valor["opinion"]
						, $valor["matriculado"]
						, $valor["correoelectronico"]
						, $valor["celular"]);
			$array_exportacion[] = $array_temp;
		}
    
    ExcelReport()->extraer_informe($array_exportacion, "Reporte de opiniones");
  }
  
  function exportar_dgip() {
    SessionHandling::checkGrupo('1');
		$this->model->opiniontipo_id = 2;
    $datos = $this->model->listar_tipo_opinion();
    $array_encabezados = array('FECHA', 'HORA', 'TEMA', 'OPINIÓN', 'MATRICULADO', 'EMAIL', 'CELULAR');
		$array_exportacion = array();
		$array_exportacion[] = $array_encabezados;
		foreach ($datos as $clave=>$valor) {
			$array_temp = array();
			$array_temp = array(
						  $valor["fecha"]
						, $valor["hora"]
						, $valor["tipo"]
						, $valor["opinion"]
						, $valor["matriculado"]
						, $valor["correoelectronico"]
						, $valor["celular"]);
			$array_exportacion[] = $array_temp;
		}
    
    ExcelReport()->extraer_informe($array_exportacion, "Reporte de opiniones");
  }
}
?>