<?php
require_once "modules/auditor/view.php";
require_once "modules/auditor/model.php";
require_once "tools/PHPExcel/array2excel.php";


class AuditorController {

	function __construct() {
		$this->model = new Auditor();
		$this->view = new AuditorView();
	}
  
	function listar() {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,4,99');
		$auditorias = $this->model->listar();
		$this->view->listar($auditorias);
	}
  
  function buscar() {
		SessionHandling::check();
    SessionHandling::actualizar();
		$busqueda = filter_input(INPUT_POST, 'busqueda');
    $subtitulo = "Reporte de Auditor - Búsqueda: {$busqueda}";
		$busqueda = "%{$busqueda}%";
		$datos = $this->model->descargar_informe($busqueda);
    if(!is_array($datos)) $datos = array();
		
    $array_encabezados = array('ID', 'USUARIO', 'FECHA', 'HORA', 'MÓDULO', 'ACCIÓN', 'SO', 'NAVEGADOR', 'IP', 'DETALLE');
		$array_exportacion = array();
		$array_exportacion[] = $array_encabezados;
		foreach ($datos as $clave=>$valor) {
			$array_temp = array();
			$array_temp = array(
						  $valor["auditor_id"]
						, $valor["usuario"]
						, $valor["fecha"]
						, $valor["hora"]
						, $valor["objeto"]
						, $valor["recurso"]
						, $valor["sistemaoperativo"]
						, $valor["navegador"]
						, $valor["ip"]
						, $valor["detalle"]);
			$array_exportacion[] = $array_temp;
		}
    
    ExcelReport()->extraer_informe($array_exportacion, $subtitulo);
	}
}
?>
