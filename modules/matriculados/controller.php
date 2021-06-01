<?php
require_once "modules/matriculados/view.php";
require_once "modules/matriculados/model.php";
require_once "tools/PHPExcel/array2excel.php";


class MatriculadosController {

	function __construct() {
		$this->model = new Matriculados();
		$this->view = new MatriculadosView();
	}
  
  function panel() {
		SessionHandling::check();
    SessionHandling::checkGrupo('1,4,99');
		$matriculados = $this->model->listar();
		$this->view->panel($matriculados);
	}
  
  function agregar() {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,4,99');
    $this->view->agregar();
  }
  
  function editar($argumentos) {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,4,99');
    $matriculado_id = $argumentos[0];
    $this->model->matriculado_id = $matriculado_id;
    $matriculado = $this->model->get();
    $actualizacion = $this->model->verifica_actualizacion();
    $this->view->editar($matriculado, $actualizacion);
  }
  
   function guardar() {
		SessionHandling::check();
    $this->model->matricula = filter_input(INPUT_POST, 'matricula');
    $this->model->documento = filter_input(INPUT_POST, 'documento');
    $this->model->apellido = filter_input(INPUT_POST, 'apellido');
    $this->model->nombre = filter_input(INPUT_POST, 'nombre');
		$this->model->telefono = filter_input(INPUT_POST, 'telefono');
		$this->model->telefono_visible_web = filter_input(INPUT_POST, 'telefono_visible_web');
		$this->model->celular = filter_input(INPUT_POST, 'celular');
		$this->model->celular_visible_web = filter_input(INPUT_POST, 'celular_visible_web');
		$this->model->correoelectronico = filter_input(INPUT_POST, 'correoelectronico');
		$this->model->correoelectronico_visible_web = filter_input(INPUT_POST, 'correoelectronico_visible_web');
		$this->model->direccion = filter_input(INPUT_POST, 'direccion');
		$this->model->direccion_visible_web = filter_input(INPUT_POST, 'direccion_visible_web');
		$this->model->save();
    header("Location: /" . APP_NAME . "/matriculados/panel");
  }
  
  function actualizar() {
		SessionHandling::check();
    $this->model->matricula = filter_input(INPUT_POST, 'matricula');
    $this->model->documento = filter_input(INPUT_POST, 'documento');
    $this->model->apellido = filter_input(INPUT_POST, 'apellido');
    $this->model->nombre = filter_input(INPUT_POST, 'nombre');
		$this->model->telefono = filter_input(INPUT_POST, 'telefono');
		$this->model->telefono_visible_web = filter_input(INPUT_POST, 'telefono_visible_web');
		$this->model->celular = filter_input(INPUT_POST, 'celular');
		$this->model->celular_visible_web = filter_input(INPUT_POST, 'celular_visible_web');
		$this->model->correoelectronico = filter_input(INPUT_POST, 'correoelectronico');
		$this->model->correoelectronico_visible_web = filter_input(INPUT_POST, 'correoelectronico_visible_web');
		$this->model->direccion = filter_input(INPUT_POST, 'direccion');
		$this->model->direccion_visible_web = filter_input(INPUT_POST, 'direccion_visible_web');
		$this->model->matriculado_id = filter_input(INPUT_POST, 'matriculado_id');
		$this->model->save();
		header("Location: /" . APP_NAME . "/matriculados/panel");
  }
  
  function eliminar($argumentos) {
		SessionHandling::check();
    SessionHandling::checkGrupo(1);
    $this->model->matriculado_id = $argumentos[0];
		$this->model->delete();
		header("Location: /" . APP_NAME . "/matriculados/panel");
  }
  
  function ver($argumentos) {
		SessionHandling::check();
    SessionHandling::actualizar();
		switch($argumentos[0]) {
			case 1:
				$array_msj = array("{mensaje}"=>"Su contraseña ha sido modificada.",
													 "{display}"=>"show");
				break;
			default:
				$array_msj = array("{mensaje}"=>"",
													 "{display}"=>"none");
				break;
		}
		
		$this->view->ver($array_msj);
	}
	
	function verificar_matricula($argumentos) {
		SessionHandling::check();
		$this->model->matricula = $argumentos[0];
		$rst = $this->model->verificar_matricula();		
		print $rst;
	}
  
  function mi_curriculum() {
    SessionHandling::check();
		
    $matricula_id = $_SESSION['sesion.matricula_id'];
    $this->model->matricula_id = $matricula_id;
    $matriculado = $this->model->traer_matricula_matriculado();
    $this->model->matriculado_id = $matriculado['matriculado_id'];
    
    $mat_experiencia = $this->model->get_matriculado_experiencia();
    $mat_estudios = $this->model->get_matriculado_estudios();
    $mat_cursos = $this->model->get_matriculado_cursos();
    $mat_idiomas = $this->model->get_matriculado_idiomas();
    $mat_detalle = $this->model->get_matriculado_detalle();
    $provincias = $this->model->get_provincias();
    
    if (!is_array($mat_detalle)) {
      $mat_detalle = array("fecha_nacimiento"=>'Sin datos cargados',
                           "localidad"=>'Sin datos cargados',
                           "provincia"=>'Sin datos cargados');
    } else {
      $mat_detalle = $mat_detalle[0];
    }
    
		$this->view->mi_curriculum($matriculado, $mat_experiencia, $mat_estudios, $mat_cursos, $mat_idiomas, $mat_detalle, $provincias);
  }
  
  function ver_curriculum($argumentos) {
		SessionHandling::check();
    SessionHandling::checkGrupo('1,99');
    
    $matriculado_id = $argumentos[0];
    $this->model->matriculado_id = $matriculado_id;
    $matriculado = $this->model->get();
    $mat_experiencia = $this->model->get_matriculado_experiencia();
    $mat_estudios = $this->model->get_matriculado_estudios();
    $mat_cursos = $this->model->get_matriculado_cursos();
    $mat_idiomas = $this->model->get_matriculado_idiomas();
    $mat_detalle = $this->model->get_matriculado_detalle();
    $provincias = $this->model->get_provincias();
    
    if (!is_array($mat_detalle)) {
      $mat_detalle = array("fecha_nacimiento"=>'',
                           "edad"=>'Sin datos cargados',
                           "localidad"=>'Sin datos cargados',
                           "provincia"=>'Sin datos cargados');
    } else {
      $edad = $this->calcula_edad($mat_detalle[0]['fecha_nacimiento']);
      $mat_detalle[0]['edad'] = "{$edad} años.";
      $mat_detalle[0]['fecha_nacimiento'] = "(" . $mat_detalle[0]['fecha_ordenada'] .")";
      $mat_detalle = $mat_detalle[0];
    }
    
		$this->view->ver_curriculum($matriculado, $mat_experiencia, $mat_estudios, $mat_cursos, $mat_idiomas, $mat_detalle, $provincias);
  }
  
  function curriculums() {
		SessionHandling::check();
    SessionHandling::checkGrupo('1,99');
    
    $mat_curso = $this->model->traer_matriculadocurso();
    $mat_experiencia = $this->model->traer_matriculadoexperiencia();
    $mat_idioma = $this->model->traer_matriculadoidioma();
    $mat_estudio = $this->model->traer_matriculadoestudio();
    $provincias = $this->model->get_provincias();
    $idiomas = $this->model->get_idiomas();
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
    $matriculados_curriculums = $this->model->traer_matriculados_curriculums($matriculado_ids);
    if (!is_array($matriculados_curriculums)) $matriculados_curriculums = array();
    $this->view->curriculums($matriculados_curriculums, $provincias, $idiomas);
  }
  
  function buscar_curriculum() {
    SessionHandling::check();
    SessionHandling::checkGrupo('1,99');
    
    $edad = filter_input(INPUT_POST, 'edad');
    $provincia_id = filter_input(INPUT_POST, 'provincia_id');
    $localidad = filter_input(INPUT_POST, 'localidad');
    $universidad = filter_input(INPUT_POST, 'universidad');
    $titulacion = filter_input(INPUT_POST, 'titulacion');
    $curso = filter_input(INPUT_POST, 'curso');
    $idioma_id = filter_input(INPUT_POST, 'idioma_id');
      
    $flag = 0;
    $where_array = array();
    if ($provincia_id != 99) {
      $where_provincia = "md.provincia_id = {$provincia_id}";
      $where_array[] = $where_provincia;
      $flag = 1;
    }
    
    if ($idioma_id != 99) {
      $where_idioma = "mi.idioma_id = {$idioma_id}";
      $where_array[] = $where_idioma;
      $flag = 1;
    }
    
    if ($localidad != '' AND !empty($localidad)) {
      $where_localidad = "md.localidad LIKE '%{$localidad}%'";
      $where_array[] = $where_localidad;
      $flag = 1;
    }
    
    if ($universidad != '' AND !empty($universidad)) {
      $where_universidad = "me.universidad LIKE '%{$universidad}%'";
      $where_array[] = $where_universidad;
      $flag = 1;
    }
    
    if ($titulacion != '' AND !empty($titulacion)) {
      $where_titulacion = "me.titulacion LIKE '%{$titulacion}%'";
      $where_array[] = $where_titulacion;
      $flag = 1;
    }
    
    if ($curso != '' AND !empty($curso)) {
      $where_curso = "mc.denominacion LIKE '%{$curso}%'";
      $where_array[] = $where_curso;
      $flag = 1;
    }
    
    if ($edad != 99) {
      $edad_array = explode('-', $edad);
      $inicio = $edad_array[0];
      $fin = $edad_array[1];
      $where_edad = "(YEAR(CURDATE())-YEAR(md.fecha_nacimiento)) BETWEEN {$inicio} AND {$fin}";
      $where_array[] = $where_edad;
      $flag = 1;
    }
    
    if (!empty($where_array)) {
      $where_sql = implode(' AND ', $where_array);
      $where_sql = "WHERE {$where_sql} GROUP BY m.matriculado_id";
    } else {
      $where_sql = '';
    }
    
    $rst = $this->model->buscar_curriculum($where_sql);
    $this->view->listar_busqueda($rst);
  }
  
  function agregar_experiencia_ajax($argumentos) {
		$matriculado_id = $argumentos[0];
		$this->view->agregar_experiencia_ajax($matriculado_id);
  }
  
  function guardar_detalle_matriculado() {
    $this->model->matriculado_id = filter_input(INPUT_POST, 'matriculado_id');
    $this->model->provincia_id = filter_input(INPUT_POST, 'provincia_id');
    $this->model->fecha_nacimiento = filter_input(INPUT_POST, 'fecha_nacimiento');
    $this->model->localidad = filter_input(INPUT_POST, 'localidad');
    $this->model->guardar_detalle_matriculado();
		header("Location: /" . APP_NAME . "/matriculados/mi_curriculum");
  }
  
  function guardar_experiencia_matriculado() {
    $actual = filter_input(INPUT_POST, 'actual');
    $this->model->matriculado_id = filter_input(INPUT_POST, 'matriculado_id');
    $this->model->cargo = filter_input(INPUT_POST, 'cargo');
    $this->model->empresa = filter_input(INPUT_POST, 'empresa');
    $this->model->ubicacion = filter_input(INPUT_POST, 'ubicacion');
    $this->model->desde = filter_input(INPUT_POST, 'desde');
    $this->model->descripcion = filter_input(INPUT_POST, 'descripcion');
    if (is_null($actual)) {
      $this->model->hasta = filter_input(INPUT_POST, 'hasta');
      $this->model->actual = 0;
    } else {
      $this->model->hasta = filter_input(INPUT_POST, 'hasta');
      $this->model->actual = 1;
    }
    
    $this->model->guardar_experiencia_matriculado();
		header("Location: /" . APP_NAME . "/matriculados/mi_curriculum");
  }
  
  function eliminar_experiencia_matriculado($argumentos) {
    $this->model->matriculadoexperiencia_id = $argumentos[0];
		$this->model->eliminar_experiencia_matriculado();
		header("Location: /" . APP_NAME . "/matriculados/mi_curriculum");
  }
  
  function agregar_estudio_ajax($argumentos) {
		$matriculado_id = $argumentos[0];
		$this->view->agregar_estudio_ajax($matriculado_id);
  }
  
  function guardar_estudio_matriculado() {
    $this->model->matriculado_id = filter_input(INPUT_POST, 'matriculado_id');
    $this->model->titulacion = filter_input(INPUT_POST, 'titulacion');
    $this->model->universidad = filter_input(INPUT_POST, 'universidad');
    $this->model->nota = filter_input(INPUT_POST, 'nota');
    $this->model->actividades = filter_input(INPUT_POST, 'actividades');
    $this->model->desde = filter_input(INPUT_POST, 'desde');
    $this->model->hasta = filter_input(INPUT_POST, 'hasta');
    $this->model->descripcion = filter_input(INPUT_POST, 'descripcion');
		$this->model->guardar_estudio_matriculado();
		header("Location: /" . APP_NAME . "/matriculados/mi_curriculum");
  }
  
  function eliminar_estudio_matriculado($argumentos) {
    $this->model->matriculadoestudio_id = $argumentos[0];
		$this->model->eliminar_estudio_matriculado();
		header("Location: /" . APP_NAME . "/matriculados/mi_curriculum");
  }
  
  function agregar_curso_ajax($argumentos) {
		SessionHandling::check();
    $matriculado_id = $argumentos[0];
		$this->view->agregar_curso_ajax($matriculado_id);
  }
  
  function guardar_curso_matriculado() {
    $this->model->matriculado_id = filter_input(INPUT_POST, 'matriculado_id');
    $this->model->denominacion = filter_input(INPUT_POST, 'denominacion');
    $this->model->numero = filter_input(INPUT_POST, 'numero');
    $this->model->fecha = filter_input(INPUT_POST, 'fecha');
		$this->model->guardar_curso_matriculado();
		header("Location: /" . APP_NAME . "/matriculados/mi_curriculum");
  }
  
  function eliminar_curso_matriculado($argumentos) {
    $this->model->matriculadocurso_id = $argumentos[0];
		$this->model->eliminar_curso_matriculado();
		header("Location: /" . APP_NAME . "/matriculados/mi_curriculum");
  }
  
  function agregar_idioma_ajax($argumentos) {
		$matriculado_id = $argumentos[0];
		$idiomas = $this->model->get_idiomas();
    $experiencianivel = $this->model->get_experienciasnivel();
    $this->view->agregar_idioma_ajax($idiomas, $experiencianivel, $matriculado_id);
  }
  
  function guardar_idioma_matriculado() {
    $this->model->matriculado_id = filter_input(INPUT_POST, 'matriculado_id');
    $this->model->idioma_id = filter_input(INPUT_POST, 'idioma_id');
    $this->model->experiencianivel_id = filter_input(INPUT_POST, 'experiencianivel_id');
		$this->model->guardar_idioma_matriculado();
		header("Location: /" . APP_NAME . "/matriculados/mi_curriculum");
  }
  
  function eliminar_idioma_matriculado($argumentos) {
    $this->model->matriculadoidioma_id = $argumentos[0];
		$this->model->eliminar_idioma_matriculado();
		header("Location: /" . APP_NAME . "/matriculados/mi_curriculum");
  }
  
  function calcula_edad($fecha_nacimiento){
    list($ano,$mes,$dia) = explode("-",$fecha_nacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0)
      $ano_diferencia--;
    return $ano_diferencia;
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
    
    ExcelReport()->extraer_informe($array_exportacion, "Reporte de Matriculados");
  }
}
?>