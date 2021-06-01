<?php
require_once "modules/encuestas/view.php";
require_once "modules/encuestas/model.php";
require_once "tools/PHPExcel/array2excel.php";


class EncuestasController {

	function __construct() {
		$this->model = new Encuestas();
		$this->view = new EncuestasView();
	}
  
  function panel() {
		SessionHandling::check();
    SessionHandling::checkGrupo('1,99');
		$encuestas = $this->model->listar();
		$this->view->panel($encuestas);
	}
  
  function agregar() {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,99');
    $this->view->agregar();
  }
  
  function editar($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,99');
    $encuesta_id = $argumentos[0];
    $this->model->encuesta_id = $encuesta_id;
    $encuesta = $this->model->get();
    $preguntas = $this->model->traer_preguntas_encuesta();
    $this->view->editar($encuesta, $preguntas);
  }
  
  function consultar($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,99');
    $encuesta_id = $argumentos[0];
    $this->model->encuesta_id = $encuesta_id;
    $encuesta = $this->model->get();
    $preguntas = $this->model->traer_preguntas_encuesta();
    $respuestas = array();
    foreach ($preguntas as $clave=>$valor) {
      $pregunta_id = $valor['pregunta_id'];
      $this->model->pregunta_id = $pregunta_id;
      $respuestas = $this->model->traer_respuestas_pregunta();
      $respuestas = (!is_array($respuestas)) ? array() : $respuestas;
      $preguntas[$clave]['respuestas'] = $respuestas;
    }
      
    $this->view->consultar($encuesta, $preguntas);
  }
  
  function resultados($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,99');
    $encuesta_id = $argumentos[0];
    $this->model->encuesta_id = $encuesta_id;
    $encuesta = $this->model->get();
    $encuestaresultados = $this->model->traer_resultados_encuesta();
    
    $cantidad_respuestas_encuestas = $this->model->cantidad_respuestas_encuesta();
    $array_temp = array();
    foreach ($cantidad_respuestas_encuestas as $clave=>$valor) {
      if (!in_array($valor['PREGUNTA'], $array_temp)) $array_temp[] = $valor['PREGUNTA'];        
    }
    
    $array_pregunta_respuesta = array();
    $i = 1;
    foreach ($array_temp as $clave=>$valor) {
      $array = array('i'=>$i,
                     'pregunta'=>$valor,
                     'respuestas'=>array());
      $array_pregunta_respuesta[] = $array;
      $i = $i + 1;
    }
    
    $array_colores = array('#e3e860','#eb5d82','#5ae85a','#e965db','#6b9dfa','#e9e225','#faab12');
    foreach ($array_pregunta_respuesta as $clave=>$valor) {
      $pregunta = $valor['pregunta'];
      $j = 0;
      foreach ($cantidad_respuestas_encuestas as $cl=>$vl) {
        $pregunta_temp = $vl['PREGUNTA'];
        if ($pregunta_temp == $pregunta) {
          $array = array('color'=>$array_colores[$j],
                         'respuesta'=>$vl['RESPUESTA'],
                         'cantidad'=>$vl['CANT']);
          $array_pregunta_respuesta[$clave]['respuestas'][] = $array;
          $j = $j + 1;
        }
      }
    }
    
    $this->view->resultados($encuesta, $encuestaresultados, $array_pregunta_respuesta);
  }
  
  function consultar_resultado($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,99');
    $encuesta_id = $argumentos[0];
    $encuestaresultado_id = $argumentos[1];
    $this->model->encuesta_id = $encuesta_id;
    $this->model->encuestaresultado_id = $encuestaresultado_id;
    $encuesta = $this->model->get();
    $resultado_encuesta = $this->model->traer_resultado_encuesta();
    $resultado_pregunta_respuesta = $this->model->traer_resultados_pregunta_encuesta();
    $this->view->consultar_resultado($encuesta, $resultado_encuesta, $resultado_pregunta_respuesta);
  }
  
  function guardar() {
		SessionHandling::check();
    $this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
    $this->model->fecha = date('Y-m-d');
    $this->model->activa = 0;
		$this->model->guardar();
    header("Location: /" . APP_NAME . "/encuestas/panel");
  }
  
  function actualizar() {
		SessionHandling::check();
    $encuesta_id = filter_input(INPUT_POST, 'encuesta_id');
    $this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
    $this->model->fecha = filter_input(INPUT_POST, 'fecha');
    $this->model->activa = filter_input(INPUT_POST, 'activa');    
    $this->model->encuesta_id = $encuesta_id;
    $this->model->guardar();
		header("Location: /" . APP_NAME . "/encuestas/editar/{$encuesta_id}");
  }
  
  function activar_encuesta($argumentos) {
		SessionHandling::check();
    $encuesta_id = $argumentos[0];
    $this->model->encuesta_id = $encuesta_id;
    $this->model->desactivar_encuestas();
    $this->model->activar_encuesta();
		header("Location: /" . APP_NAME . "/encuestas/panel");
  }
  
  function guardar_pregunta() {
		SessionHandling::check();
    $encuesta_id = filter_input(INPUT_POST, 'encuesta_id');
    $this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
    $this->model->encuesta_id = $encuesta_id;
		$this->model->guardar_pregunta();
    header("Location: /" . APP_NAME . "/encuestas/editar/{$encuesta_id}");
  }
  
  function editar_pregunta($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,99');
    $encuesta_id = $argumentos[0];
    $pregunta_id = $argumentos[1];
    $this->model->encuesta_id = $encuesta_id;
    $this->model->pregunta_id = $pregunta_id;
    $encuesta = $this->model->get();
    $pregunta = $this->model->get_pregunta();
    $respuestas = $this->model->traer_respuestas_pregunta();
    $this->view->editar_pregunta($encuesta, $pregunta, $respuestas);
  }
  
  function actualizar_pregunta() {
		SessionHandling::check();
    $encuesta_id = filter_input(INPUT_POST, 'encuesta_id');
    $pregunta_id = filter_input(INPUT_POST, 'pregunta_id');
    $this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
    $this->model->pregunta_id = $pregunta_id;
    $this->model->encuesta_id = $encuesta_id;
		$this->model->actualizar_pregunta();
    header("Location: /" . APP_NAME . "/encuestas/editar_pregunta/{$encuesta_id}/{$pregunta_id}");
  }
  
  function eliminar_pregunta($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,99');
    $encuesta_id = $argumentos[0];
    $pregunta_id = $argumentos[1];
    $this->model->pregunta_id = $pregunta_id;
    $this->model->eliminar_respuestas_pregunta();
    $this->model->eliminar_pregunta();
    header("Location: /" . APP_NAME . "/encuestas/editar/{$encuesta_id}");
  }
  
  function guardar_respuesta() {
		SessionHandling::check();
    $encuesta_id = filter_input(INPUT_POST, 'encuesta_id');
    $pregunta_id = filter_input(INPUT_POST, 'pregunta_id');
    $this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
    $this->model->pregunta_id = $pregunta_id;
		$this->model->guardar_respuesta();
    header("Location: /" . APP_NAME . "/encuestas/editar_pregunta/{$encuesta_id}/{$pregunta_id}");
  }
  
  function eliminar_respuesta($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,99');
    $encuesta_id = $argumentos[0];
    $pregunta_id = $argumentos[1];
    $respuesta_id = $argumentos[2];
    $this->model->respuesta_id = $respuesta_id;
    $this->model->eliminar_respuesta();
    header("Location: /" . APP_NAME . "/encuestas/editar_pregunta/{$encuesta_id}/{$pregunta_id}");
  }
  
  function guardar_resultado_encuesta() {
    SessionHandling::check();
    
    $this->model->fecha = date('Y-m-d');
    $this->model->matricula_id = $_SESSION["sesion.matricula_id"];
    $this->model->encuesta_id = filter_input(INPUT_POST, 'encuesta_id');
    $this->model->guardar_resultado_encuesta();
    $encuestaresultado_id = $this->model->encuestaresultado_id;
    
    $pregunta_respuesta = $_POST['pregunta'];
    foreach ($pregunta_respuesta as $pregunta=>$respuesta) {
      $this->model->pregunta = $pregunta;
      $this->model->respuesta = $respuesta;
      $this->model->encuestaresultado_id = $encuestaresultado_id;
      $this->model->guardar_resultado_pregunta_respuesta();
    }
    
    header("Location: /" . APP_NAME . "/usuarios/panel");
  }
  
  function exportar() {
    SessionHandling::check();
    SessionHandling::checkGrupo(1);
		$datos = $this->model->listar();
    $array_encabezados = array('MATRICULADO', 'MATRICULA', 'DOCUMENTO', 'EMAIL', 'TELEFONO', 'CELULAR', 'DIRECCIÓN');
		$array_exportacion = array();
		$array_exportacion[] = $array_encabezados;
    foreach ($datos as $clave=>$valor) {
			$array_temp = array();
			$array_temp = array(
						  $valor["apellido"] . ' ' . $valor["nombre"]
						, $valor["matricula"]
						, $valor["documento"]
						, $valor["correoelectronico"]
						, $valor["telefono"]
						, $valor["celular"]
						, $valor["direccion"]);
			$array_exportacion[] = $array_temp;
		}
    
    ExcelReport()->extraer_informe($array_exportacion, "Reporte de Encuestas");
  }
}
?>