<?php


class MatriculadosView extends View{
  function panel($matriculados) {
		$gui = file_get_contents("static/modules/matriculados/panel.html");
		$gui_tbl_matriculados = file_get_contents("static/modules/matriculados/tbl_matriculados.html");
		$menu = file_get_contents("static/menu.html");
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict = array("{titulo}"=>"Sistema de Gestión de Documentación");
		
    if(!is_array($matriculados)){$matriculados=array();}
    
    $gui_tbl_matriculados = $this->render_regex("repetir", $gui_tbl_matriculados, $matriculados);
    $render = str_replace('{tbl_matriculados}', $gui_tbl_matriculados, $gui);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
	function agregar() {
		$gui = file_get_contents("static/modules/matriculados/agregar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Agregar Matriculados");
    
		$render = $this->render($dict, $gui);
		print $this->render_template($menu, $render);
	}
	
	function editar($matriculado, $actualizacion) {
		$gui = file_get_contents("static/modules/matriculados/editar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Actualización de Matriculados");
		
    $matriculado['correoelectronico_check_si'] = ($matriculado['correoelectronico_visible_web'] == 1) ? 'checked' : '';
    $matriculado['correoelectronico_check_no'] = ($matriculado['correoelectronico_visible_web'] == 1) ? '' : 'checked';
    $matriculado['telefono_check_si'] = ($matriculado['telefono_visible_web'] == 1) ? 'checked' : '';
    $matriculado['telefono_check_no'] = ($matriculado['telefono_visible_web'] == 1) ? '' : 'checked';
    $matriculado['celular_check_si'] = ($matriculado['celular_visible_web'] == 1) ? 'checked' : '';
    $matriculado['celular_check_no'] = ($matriculado['celular_visible_web'] == 1) ? '' : 'checked';
    $matriculado['direccion_check_si'] = ($matriculado['direccion_visible_web'] == 1) ? 'checked' : '';
    $matriculado['direccion_check_no'] = ($matriculado['direccion_visible_web'] == 1) ? '' : 'checked';
    
    switch($actualizacion) {
      case 1:
        $matriculado['txt_actualizacion'] = 'Pendiente de Actualización';
        break;
      case 2:
        $matriculado['txt_actualizacion'] = 'Actualizado por el Matriculado';
        break;
      default:
        $matriculado['txt_actualizacion'] = 'Sin actualización pendiente';
        break;
    }
    
		$matriculado = $this->set_dict($matriculado);
		$render = $this->render($matriculado, $gui);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}

	function ver($array_modal) {
		$gui = file_get_contents("static/modules/usuarios/ver.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$dict = array("{titulo}"=>"Sistema de Gestión de Documentación");
		$dict = array_merge($dict, $this->set_dict($_SESSION));
		$dict = array_merge($dict, $array_modal);
		$render = $this->render($dict, $gui);
		print $this->render_template($menu, $render);
	}
  
  function curriculums($matriculados_curriculums, $provincias, $idiomas) {
		$gui = file_get_contents("static/modules/matriculados/curriculums.html");
		$gui_tbl_matriculados = file_get_contents("static/modules/matriculados/tbl_matriculados_curriculums.html");
    $slt_provincias = file_get_contents("static/common/slt_provincias.html");
    $slt_provincias = $this->render_regex("repetir", $slt_provincias, $provincias);
    $slt_idiomas = file_get_contents("static/modules/matriculados/slt_idioma.html");
    $slt_idiomas = $this->render_regex("repetir", $slt_idiomas, $idiomas);
		$menu = file_get_contents("static/menu.html");
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict = array("{titulo}"=>"Sistema de Gestión de Documentación");
		
    if(!is_array($matriculados_curriculums)){$matriculados_curriculums=array();}
    
    $gui_tbl_matriculados = $this->render_regex("repetir", $gui_tbl_matriculados, $matriculados_curriculums);
    $render = str_replace('{tbl_matriculados_cirriculums}', $gui_tbl_matriculados, $gui);
    $render = str_replace('{slt_provincias}', $slt_provincias, $render);
    $render = str_replace('{slt_idiomas}', $slt_idiomas, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
  function listar_busqueda($matriculados_curriculums) {
		$gui = file_get_contents("static/modules/matriculados/listar_busqueda.html");
		$gui_tbl_matriculados = file_get_contents("static/modules/matriculados/tbl_matriculados_curriculums_busqueda.html");
    $menu = file_get_contents("static/menu.html");
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict = array("{titulo}"=>"Sistema de Gestión de Documentación");
		
    if(!is_array($matriculados_curriculums)){$matriculados_curriculums=array();}
    
    $gui_tbl_matriculados = $this->render_regex("repetir", $gui_tbl_matriculados, $matriculados_curriculums);
    $render = str_replace('{tbl_matriculados_cirriculums}', $gui_tbl_matriculados, $gui);
    $render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
  function mi_curriculum($matriculado, $mat_experiencia, $mat_estudios, $mat_cursos, $mat_idiomas, $mat_detalle, $provincias) {
		$gui = file_get_contents("static/modules/matriculados/mi_curriculum.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
    if(!is_array($mat_experiencia)) {
      $gui = str_replace('{lst_experiencia}', 'No se ha cargado experiencia.', $gui);    
    } else {
      $lst_experiencia = file_get_contents("static/modules/matriculados/lst_experiencia.html");
      $lst_experiencia = $this->render_regex("repetir", $lst_experiencia, $mat_experiencia);
      $gui = str_replace('{lst_experiencia}', $lst_experiencia, $gui);
    }
    
    if(!is_array($mat_estudios)) {
      $gui = str_replace('{lst_estudios}', 'No se han definido estudios.', $gui);    
    } else {
      $lst_estudios = file_get_contents("static/modules/matriculados/lst_estudio.html");
      $lst_estudios = $this->render_regex("repetir", $lst_estudios, $mat_estudios);
      $gui = str_replace('{lst_estudios}', $lst_estudios, $gui);
    }
    
    if(!is_array($mat_cursos)) {
      $gui = str_replace('{lst_cursos}', 'No se han definido cursos.', $gui);    
    } else {
      $lst_cursos = file_get_contents("static/modules/matriculados/lst_curso.html");
      $lst_cursos = $this->render_regex("repetir", $lst_cursos, $mat_cursos);
      $gui = str_replace('{lst_cursos}', $lst_cursos, $gui);
    }
    
    if(!is_array($mat_idiomas)) {
      $gui = str_replace('{lst_idiomas}', 'No se han definido niveles de idioma.', $gui);    
    } else {
      $lst_idiomas = file_get_contents("static/modules/matriculados/lst_idioma.html");
      $lst_idiomas = $this->render_regex("repetir", $lst_idiomas, $mat_idiomas);
      $gui = str_replace('{lst_idiomas}', $lst_idiomas, $gui);
    }
    
    $slt_provincias = file_get_contents("static/common/slt_provincias.html");
    $slt_provincias = $this->render_regex("repetir", $slt_provincias, $provincias);
    
		$dict = array("{titulo}"=>"Mi Currículum");
		$dict = array_merge($dict, $this->set_dict($matriculado));
		$mat_detalle = $this->set_dict($mat_detalle);
		$render = $this->render($dict, $gui);
		$render = $this->render($mat_detalle, $render);
		$render = str_replace('{slt_provincias}', $slt_provincias, $render);
		print $this->render_template($menu, $render);
	}
  
  function ver_curriculum($matriculado, $mat_experiencia, $mat_estudios, $mat_cursos, $mat_idiomas, $mat_detalle, $provincias) {
		$gui = file_get_contents("static/modules/matriculados/ver_curriculum.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
    if(!is_array($mat_experiencia)) {
      $gui = str_replace('{lst_experiencia}', 'No se ha cargado experiencia.', $gui);    
    } else {
      $lst_experiencia = file_get_contents("static/modules/matriculados/lst_experiencia.html");
      $lst_experiencia = $this->render_regex("repetir", $lst_experiencia, $mat_experiencia);
      $gui = str_replace('{lst_experiencia}', $lst_experiencia, $gui);
    }
    
    if(!is_array($mat_estudios)) {
      $gui = str_replace('{lst_estudios}', 'No se han definido estudios.', $gui);    
    } else {
      $lst_estudios = file_get_contents("static/modules/matriculados/lst_estudio.html");
      $lst_estudios = $this->render_regex("repetir", $lst_estudios, $mat_estudios);
      $gui = str_replace('{lst_estudios}', $lst_estudios, $gui);
    }
    
    if(!is_array($mat_cursos)) {
      $gui = str_replace('{lst_cursos}', 'No se han definido cursos.', $gui);    
    } else {
      $lst_cursos = file_get_contents("static/modules/matriculados/lst_curso.html");
      $lst_cursos = $this->render_regex("repetir", $lst_cursos, $mat_cursos);
      $gui = str_replace('{lst_cursos}', $lst_cursos, $gui);
    }
    
    if(!is_array($mat_idiomas)) {
      $gui = str_replace('{lst_idiomas}', 'No se han definido niveles de idioma.', $gui);    
    } else {
      $lst_idiomas = file_get_contents("static/modules/matriculados/lst_idioma.html");
      $lst_idiomas = $this->render_regex("repetir", $lst_idiomas, $mat_idiomas);
      $gui = str_replace('{lst_idiomas}', $lst_idiomas, $gui);
    }
    
    $slt_provincias = file_get_contents("static/common/slt_provincias.html");
    $slt_provincias = $this->render_regex("repetir", $slt_provincias, $provincias);
    
		$dict = array("{titulo}"=>"Ver Currículum");
		$dict = array_merge($dict, $this->set_dict($matriculado));
		$mat_detalle = $this->set_dict($mat_detalle);
		$render = $this->render($dict, $gui);
		$render = $this->render($mat_detalle, $render);
		$render = str_replace('{slt_provincias}', $slt_provincias, $render);
		print $this->render_template($menu, $render);
	}
  
  function agregar_experiencia_ajax($matriculado_id) {
    $gui = file_get_contents("static/modules/matriculados/agregar_experiencia_ajax.html");
		$gui = str_replace('{matriculado_id}', $matriculado_id, $gui);    
    print $gui;
  }
  
  function agregar_estudio_ajax($matriculado_id) {
    $gui = file_get_contents("static/modules/matriculados/agregar_estudio_ajax.html");
		$gui = str_replace('{matriculado_id}', $matriculado_id, $gui);    
    print $gui;
  }
  
  function agregar_idioma_ajax($idiomas, $experiencianivel, $matriculado_id) {
    $gui = file_get_contents("static/modules/matriculados/agregar_idioma_ajax.html");
		$slt_idioma = file_get_contents("static/modules/matriculados/slt_idioma.html");
		$slt_experiencianivel = file_get_contents("static/modules/matriculados/slt_experiencianivel.html");
    $slt_idioma = $this->render_regex("repetir", $slt_idioma, $idiomas);
    $slt_experiencianivel = $this->render_regex("repetir", $slt_experiencianivel, $experiencianivel);
    
    $gui = str_replace('{slt_idioma}', $slt_idioma, $gui);
    $gui = str_replace('{slt_experiencianivel}', $slt_experiencianivel, $gui);
    $gui = str_replace('{matriculado_id}', $matriculado_id, $gui);    
    print $gui;
  }
  
  function agregar_curso_ajax($matriculado_id) {
    $gui = file_get_contents("static/modules/matriculados/agregar_curso_ajax.html");
		$gui = str_replace('{matriculado_id}', $matriculado_id, $gui);    
    print $gui;
  }
  
	function mostrar_error($mensaje) {
		$gui = file_get_contents("static/modules/usuarios/login.html");

		$dict = array("{titulo}"=>"Error", "{mostrar}"=>"show", "{mensaje}"=>$mensaje);

		print $this->render($dict, $gui);
	}
}
?>