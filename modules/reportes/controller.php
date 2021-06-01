<?php
require_once "modules/reportes/view.php";
require_once "modules/archivos/model.php";
require_once "modules/encuestas/model.php";
require_once "modules/matriculados/model.php";
require_once "modules/auditor/model.php";
require_once "tools/PHPExcel/array2excel.php";


class ReportesController {

	function __construct() {
		$this->view = new ReportesView();
	}

	function panel() {
		SessionHandling::check();
    SessionHandling::checkGrupo('1,99');
    
    $am = new Archivos();
    $estados_archivos = $am->listar_estados_seguimiento();
    
    $em = new Encuestas();
    $encuesta_activa = $em->traer_encuesta_activa();
    if(is_array($encuesta_activa) && !empty($encuesta_activa)) {
      $encuesta_activa = $encuesta_activa[0];
      
      $em->encuesta_id = $encuesta_activa['encuesta_id'];
      $encuesta = $em->get();
      
      $cantidad_respuestas_encuestas = $em->cantidad_respuestas_encuesta();
      $array_temp = array();
      foreach ($cantidad_respuestas_encuestas as $clave=>$valor) {
        if (!in_array($valor['PREGUNTA'], $array_temp)) $array_temp[] = $valor['PREGUNTA'];        
      }
    
      $encuesta_pregunta_respuesta = array();
      $i = 1;
      foreach ($array_temp as $clave=>$valor) {
        $array = array('i'=>$i,
                       'pregunta'=>$valor,
                       'respuestas'=>array());
        $encuesta_pregunta_respuesta[] = $array;
        $i = $i + 1;
      }
    
      $array_colores = array('#e3e860','#eb5d82','#5ae85a','#e965db','#6b9dfa','#e9e225','#faab12');
      foreach ($encuesta_pregunta_respuesta as $clave=>$valor) {
        $pregunta = $valor['pregunta'];
        $j = 0;
        foreach ($cantidad_respuestas_encuestas as $cl=>$vl) {
          $pregunta_temp = $vl['PREGUNTA'];
          if ($pregunta_temp == $pregunta) {
            $array = array('color'=>$array_colores[$j],
                           'respuesta'=>$vl['RESPUESTA'],
                           'cantidad'=>$vl['CANT']);
            $encuesta_pregunta_respuesta[$clave]['respuestas'][] = $array;
            $j = $j + 1;
          }
        }
      }
      
      if (count($encuesta_pregunta_respuesta) > 1) {
        $encuesta_activa['col_grafico_encuesta'] = 6;
        $encuesta_activa['margin_grafico_encuesta'] = -50;        
      } else {
        $encuesta_activa['col_grafico_encuesta'] = 12;
        $encuesta_activa['margin_grafico_encuesta'] = 75;
      }
      $encuesta_activa['panel_encuesta_display'] = 'block';
      $encuesta_activa['alert_encuesta_display'] = 'none';
    } else {
      $encuesta_activa = array();
      $encuesta_activa['panel_encuesta_display'] = 'none';
      $encuesta_activa['alert_encuesta_display'] = 'block';
      $encuesta_pregunta_respuesta = array();
    }
    
    $mm = new Matriculados();
    $provincias = $mm->get_provincias();
    $idiomas = $mm->get_idiomas();    
    $cantidad_matriculados_actualizados = $mm->get_cantidad_actualizados();
    $cantidad_matriculados_actualizados = $cantidad_matriculados_actualizados[0]['cantidad'];
    
    $mm->actualizacion = 0;
    $datos1 = $mm->listar_estado_actualizado();
    if (!is_array($datos1)) $datos1 = array();
    $mm->actualizacion = 1;
    $datos2 = $mm->listar_estado_actualizado();
    if (!is_array($datos2)) $datos2 = array();
    $array_datos = array_merge($datos1, $datos2);
    $cantidad_matriculados_desactualizados = count($array_datos);
    
    $mat_curso = $mm->traer_matriculadocurso();
    $mat_experiencia = $mm->traer_matriculadoexperiencia();
    $mat_idioma = $mm->traer_matriculadoidioma();
    $mat_estudio = $mm->traer_matriculadoestudio();
    $provincias = $mm->get_provincias();
    $idiomas = $mm->get_idiomas();
    $mat_curso = (!is_array($mat_curso)) ? array() : $mat_curso;
    $mat_experiencia = (!is_array($mat_experiencia)) ? array() : $mat_experiencia;
    $mat_idioma = (!is_array($mat_idioma)) ? array() : $mat_idioma;
    $mat_estudio = (!is_array($mat_estudio)) ? array() : $mat_estudio;
    $array_temp = array_merge($mat_estudio, $mat_curso, $mat_experiencia, $mat_idioma);
    
    $matriculado_ids = array();
    if (!empty($array_temp)) {
      foreach ($array_temp as $matriculados) {
        foreach ($matriculados as $matriculado_id) {
          if (!in_array($matriculado_id, $matriculado_ids)) $matriculado_ids[] = $matriculado_id;
        }
      }
    }
    
    $matriculado_ids = implode(',', $matriculado_ids);
    $matriculados_curriculums = $mm->traer_matriculados_curriculums($matriculado_ids);
    if (!is_array($matriculados_curriculums)) $matriculados_curriculums = array();
    $cantidad_curriculums_matriculados = count($matriculados_curriculums);
    $datos_matriculados = array();
    $datos_matriculados['{cantidad_curriculums_matriculados}'] = $cantidad_curriculums_matriculados;
    $datos_matriculados['{cantidad_matriculados_actualizados}'] = $cantidad_matriculados_actualizados;
    $datos_matriculados['{cantidad_matriculados_desactualizados}'] = $cantidad_matriculados_desactualizados;
    
    $aum = new Auditor();
    $ultimas_cinco_auditor = $aum->listar_ultimos_cinco();
    
    $this->view->panel($estados_archivos, $encuesta_activa, $encuesta_pregunta_respuesta, $provincias, $idiomas, $datos_matriculados, $ultimas_cinco_auditor);
	}
  
  function descargar_estado_archivo() {
    SessionHandling::check();
    SessionHandling::checkGrupo(99);
    
    $am = new Archivos();
		$am->estado_id = filter_input(INPUT_POST, 'estado_id');
    $datos = $am->listar_estado_reporte();
    if (!is_array($datos)) $datos = array();
    
    $array_encabezados = array('DENOMINACIÓN', 'DOCUMENTO', 'MATRÍCULA', 'USUARIO', 'FECHA', 'AUTORIZADOR', 'COMENTARIO');
		$array_exportacion = array();
		$array_exportacion[] = $array_encabezados;
		foreach ($datos as $clave=>$valor) {
			$array_temp = array();
			$array_temp = array(
						  $valor["nombre"]
						, $valor["documento"]
						, $valor["matricula"]
						, $valor["denominacion"]
						, $valor["fecha"]
						, $valor["autorizador"]
						, $valor["comentario"]);
			$array_exportacion[] = $array_temp;
		}
    
    ExcelReport()->extraer_informe($array_exportacion, "Reporte por estado");
  }
  
  function descargar_matriculado_estado_actualizacion() {
    SessionHandling::check();
    SessionHandling::checkGrupo(99);
    
    $mm = new Matriculados();
    $actualizacion = filter_input(INPUT_POST, 'actualizado');
    if ($actualizacion != 'all') {
      $mm->actualizacion = $actualizacion;
      $datos1 = $mm->listar_estado_actualizado();
      if (!is_array($datos1)) $datos1 = array();
      if ($actualizacion == 0) {
        $mm->actualizacion = 1;
        $datos2 = $mm->listar_estado_actualizado();
        if (!is_array($datos2)) $datos2 = array();
        $array_datos = array_merge($datos1, $datos2);
      } 
    } else {
      $array_datos = $mm->listar();
    }
    
    if (!is_array($array_datos)) $array_datos = array();
    $array_encabezados = array('MATRICULADO', 'MATRICULA', 'DOCUMENTO', 'EMAIL', 'TELEFONO', 'CELULAR', 'DIRECCIÓN');
		$array_exportacion = array();
		$array_exportacion[] = $array_encabezados;
    foreach ($array_datos as $clave=>$valor) {
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
    
    ExcelReport()->extraer_informe($array_exportacion, "Reporte de Matriculados");
  }
  
  function descargar_matriculados_actualizados() {
    SessionHandling::check();
    SessionHandling::checkGrupo(99);
    
    $mm = new Matriculados();
    $mm->actualizacion = 2;
    $datos = $mm->listar_estado_actualizado();
    if (!is_array($datos)) $datos = array();
    
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
    
    ExcelReport()->extraer_informe($array_exportacion, "Reporte de Matriculados");
  }
  
  function descargar_matriculados_con_cv() {
		SessionHandling::check();
    SessionHandling::checkGrupo('99');
    
    $mm = new Matriculados();
    $mat_curso = $mm->traer_matriculadocurso();
    $mat_experiencia = $mm->traer_matriculadoexperiencia();
    $mat_idioma = $mm->traer_matriculadoidioma();
    $mat_estudio = $mm->traer_matriculadoestudio();
    
    $mat_curso = (!is_array($mat_curso)) ? array() : $mat_curso;
    $mat_experiencia = (!is_array($mat_experiencia)) ? array() : $mat_experiencia;
    $mat_idioma = (!is_array($mat_idioma)) ? array() : $mat_idioma;
    $mat_estudio = (!is_array($mat_estudio)) ? array() : $mat_estudio;
    $array_temp = array_merge($mat_estudio, $mat_curso, $mat_experiencia, $mat_idioma);
    
    $matriculado_ids = array();
    if (!empty($array_temp)) {
      foreach ($array_temp as $matriculados) {
        foreach ($matriculados as $matriculado_id) {
          if (!in_array($matriculado_id, $matriculado_ids)) $matriculado_ids[] = $matriculado_id;
        }
      }
    }
        
    $matriculado_ids = implode(',', $matriculado_ids);
    $datos = $mm->exportar_matriculados_curriculums($matriculado_ids);
    if (!is_array($datos)) $datos = array();
      
    $array_encabezados = array('MATRICULADO', 'MATRICULA', 'EMAIL', 'TELEFONO', 'CELULAR', 'DIRECCIÓN');
		$array_exportacion = array();
		$array_exportacion[] = $array_encabezados;
    foreach ($datos as $clave=>$valor) {
			$array_temp = array();
			$array_temp = array(
						  $valor["matriculado"]
						, $valor["matricula"]
						, $valor["correoelectronico"]
						, $valor["telefono"]
						, $valor["celular"]
						, $valor["direccion"]);
			$array_exportacion[] = $array_temp;
		}
    
    ExcelReport()->extraer_informe($array_exportacion, "Reporte de Matriculados con CV cargado");
  }
  
  function descargar_resultado_encuesta($arg) {
		SessionHandling::check();
    SessionHandling::checkGrupo('99');
    
    $encuesta_id = $arg[0];
    $em = new Encuestas();
    $em->encuesta_id = $encuesta_id;
    $encuesta = $em->get();
    $encuesta = $encuesta['encuesta'];
    $datos = $em->cantidad_respuestas_encuesta();
      
    $array_encabezados = array('PREGUNTA', 'RESPUESTAS', 'VOTOS');
		$array_exportacion = array();
		$array_exportacion[] = $array_encabezados;
    foreach ($datos as $clave=>$valor) {
			$array_temp = array();
			$array_temp = array(
						  $valor["PREGUNTA"]
						, $valor["RESPUESTA"]
						, $valor["CANT"]);
			$array_exportacion[] = $array_temp;
		}
    
    ExcelReport()->extraer_informe($array_exportacion, "Reporte de Encuesta: {$encuesta}");
  }
}
?>