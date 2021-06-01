<?php


class ForosView extends View{
  function administrar($pendientes, $activos, $array_msj, $array_cantidades_estados, $cant_respuestas_pendientes) {
		$gui = file_get_contents("static/modules/foros/administrar.html");
		$gui_tbl_foros = file_get_contents("static/modules/foros/tbl_foros.html");
		$menu = file_get_contents("static/menu.html");
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict = array("{titulo}"=>"Gestión de Foros");
    
    if ($cant_respuestas_pendientes == 0) {
      $gui_respuestas_pendientes = file_get_contents("static/modules/foros/sin_respuesta_pendiente.html");
    } else {
      $gui_respuestas_pendientes = file_get_contents("static/modules/foros/con_respuesta_pendiente.html");
      $gui_respuestas_pendientes = str_replace("{cant_respuestas_pendientes}", $cant_respuestas_pendientes, $gui_respuestas_pendientes);
    }
    
    if(!is_array($pendientes))$pendientes=array();
    if(!is_array($activos))$activos=array();
		$gui_tbl_pendientes = $this->render_regex("repetir", $gui_tbl_foros, $pendientes);
		$gui_tbl_activos = $this->render_regex("repetir", $gui_tbl_foros, $activos);
    
    $render = str_replace('{tbl_pendientes}', $gui_tbl_pendientes, $gui);
    $render = str_replace('{tbl_activos}', $gui_tbl_activos, $render);
    $render = str_replace('{alert_respuestas_pendientes}', $gui_respuestas_pendientes, $render);
		$render = $this->render($dict, $render);
    $render = $this->render($array_msj, $render);
    $render = $this->render($array_cantidades_estados, $render);
    $render = str_replace('{theme_path}', THEME_PATH, $render);
		print $this->render_template($menu, $render);
	}
  
  function administrar_cerrados($cerrados, $rechazados) {
		$gui = file_get_contents("static/modules/foros/administrar_listado_cerrados.html");
		$gui_tbl_foros = file_get_contents("static/modules/foros/tbl_foros.html");
		$menu = file_get_contents("static/menu.html");
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict = array("{titulo}"=>"Gestión de Foros");
    
    if(!is_array($cerrados))$cerrados=array();
    if(!is_array($rechazados))$rechazados=array();
		$gui_tbl_cerrados = $this->render_regex("repetir", $gui_tbl_foros, $cerrados);
		$gui_tbl_rechazados = $this->render_regex("repetir", $gui_tbl_foros, $rechazados);
    
    $render = str_replace('{tbl_cerrados}', $gui_tbl_cerrados, $gui);
    $render = str_replace('{tbl_rechazados}', $gui_tbl_rechazados, $render);
    $render = $this->render($dict, $render);
    $render = str_replace('{theme_path}', THEME_PATH, $render);
		print $this->render_template($menu, $render);
	}
  
  function administrar_respuestas($respuestas_pendientes, $array_msj) {
		$gui = file_get_contents("static/modules/foros/administrar_respuestas.html");
		$gui_tbl_foros_respuestas = file_get_contents("static/modules/foros/tbl_foros_respuestas.html");
		$menu = file_get_contents("static/menu.html");
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict = array("{titulo}"=>"Gestión de Foros");
    
    if(!is_array($respuestas_pendientes))$respuestas_pendientes=array();
		$gui_tbl_foros_respuestas = $this->render_regex("repetir", $gui_tbl_foros_respuestas, $respuestas_pendientes);
    $render = str_replace('{tbl_foros_respuestas}', $gui_tbl_foros_respuestas, $gui);
		$render = $this->render($dict, $render);
    $render = $this->render($array_msj, $render);
		print $this->render_template($menu, $render);
	}
  
  function administrar_foro_ajax($foro, $html) {
		$gui = file_get_contents("static/modules/foros/{$html}.html");
    $foro["contenido"] = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $foro["contenido"]);
    $foro = $this->set_dict($foro);
    $render = $this->render($foro, $gui);
    $render = str_replace('{app_name}', APP_NAME, $render);
    print $render;
  }
  
  function administrar_foro_respuestas_ajax($foro, $respuestas_activas, $respuestas_pendientes) {
		$gui = file_get_contents("static/modules/foros/administrar_foro_respuestas_ajax.html");
		$gui_lst_respuestas_pendientes = file_get_contents("static/modules/foros/lst_respuestas_pendientes.html");
		$gui_lst_respuestas_activas = file_get_contents("static/modules/foros/lst_respuestas_activas.html");
    
    $foro["contenido"] = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $foro["contenido"]);
    if(!is_array($respuestas_pendientes))$respuestas_pendientes=array();
    foreach($respuestas_pendientes as $clave=>$valor) $respuestas_pendientes[$clave]["mensaje"] = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $respuestas_pendientes[$clave]["mensaje"]);
		$gui_lst_respuestas_pendientes = $this->render_regex("repetir", $gui_lst_respuestas_pendientes, $respuestas_pendientes);
    
    if(!is_array($respuestas_activas))$respuestas_activas=array();
    foreach($respuestas_activas as $clave=>$valor) $respuestas_activas[$clave]["mensaje"] = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $respuestas_activas[$clave]["mensaje"]);
		$gui_lst_respuestas_activas = $this->render_regex("repetir", $gui_lst_respuestas_activas, $respuestas_activas);
    
    $foro = $this->set_dict($foro);
    $render = str_replace('{lst_respuestas_pendientes}', $gui_lst_respuestas_pendientes, $gui);
    $render = str_replace('{lst_respuestas_activas}', $gui_lst_respuestas_activas, $render);
    $render = $this->render($foro, $render);
    $render = str_replace('{app_name}', APP_NAME, $render);
    print $render;
  }
  
  function m_agregar($activos) {
		$gui = file_get_contents("static/modules/foros/m_agregar.html");
		$gui_lst_foros_respuestas = file_get_contents("static/modules/foros/lst_foros_cant_respuestas.html");
    $menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict = array("{titulo}"=>"Foros CPCE");
		
    $gui_lst_ultimos_cinco_activos = $this->render_regex("repetir", $gui_lst_foros_respuestas, $activos);
		$render = $this->render($dict, $gui);
		$render = str_replace('{lst_ultimos_cinco_activos}', $gui_lst_ultimos_cinco_activos, $render);
		print $this->render_template($menu, $render);
	}
  
  function m_consultar($foro, $respuestas_activas) {
		$gui = file_get_contents("static/modules/foros/m_consultar.html");
		$gui_lst_respuestas_activas = file_get_contents("static/modules/foros/lst_m_respuestas_activas.html");
		$menu = file_get_contents("static/menu.html");
  
    if ($foro['codigo'] == 'ACT') {
      $gui_form_respuesta = file_get_contents("static/modules/foros/m_form_respuesta.html");
    } else {
      $gui_form_respuesta = '';
    }
          
    $restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict = array("{titulo}"=>"Foros CPCE");
    
    if(!is_array($respuestas_activas))$respuestas_activas=array();
    foreach($respuestas_activas as $clave=>$valor) $respuestas_activas[$clave]["mensaje"] = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $respuestas_activas[$clave]["mensaje"]);
		$gui_lst_respuestas_activas = $this->render_regex("repetir", $gui_lst_respuestas_activas, $respuestas_activas);
		
    $foro["contenido"] = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $foro["contenido"]);
    $foro = $this->set_dict($foro);
    $render = $this->render($dict, $gui);
    $render = str_replace('{lst_respuestas_activas}', $gui_lst_respuestas_activas, $render);
    $render = str_replace('{form_respuesta}', $gui_form_respuesta, $render);
    $render = $this->render($foro, $render);
		print $this->render_template($menu, $render);
	}
  
  function m_panel($activos) {
		$gui = file_get_contents("static/modules/foros/m_panel.html");
		$gui_tbl_foros = file_get_contents("static/modules/foros/tbl_m_foros.html");
		$menu = file_get_contents("static/menu.html");
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict = array("{titulo}"=>"Foros CPCE");
    
    if(!is_array($activos))$activos=array();
    $gui_tbl_activos = $this->render_regex("repetir", $gui_tbl_foros, $activos);
		
    $render = str_replace('{tbl_activos}', $gui_tbl_activos, $gui);
    $render = $this->render($dict, $render);
    $render = str_replace('{theme_path}', THEME_PATH, $render);
		print $this->render_template($menu, $render);
	}
  
  
  
  /*
  function panel($novedades) {
		$gui = file_get_contents("static/modules/novedades/panel.html");
		$gui_tbl_novedades = file_get_contents("static/modules/novedades/tbl_novedades.html");
		$menu = file_get_contents("static/menu.html");
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict = array("{titulo}"=>"Gestión de Novedades");
    
    if(!is_array($novedades))$novedades=array();
		$gui_tbl_novedades = $this->render_regex("repetir", $gui_tbl_novedades, $novedades);
    $render = str_replace('{tbl_novedades}', $gui_tbl_novedades, $gui);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
	function agregar() {
		$gui = file_get_contents("static/modules/novedades/agregar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Agregar Novedad");
    
		$render = $this->render($dict, $gui);
		print $this->render_template($menu, $render);
	}
	
	function editar($novedad, $array_msj) {
		$gui = file_get_contents("static/modules/novedades/editar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Actualización de Novedad");
    
    $novedad = $this->set_dict($novedad);
		$render = $this->render($novedad, $gui);
    $render = $this->render($array_msj, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
  
  function consultar($novedad) {
		$gui = file_get_contents("static/modules/novedades/consultar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Actualización de Novedad");
    
    $novedad = $this->set_dict($novedad);
		$render = $this->render($novedad, $gui);
    $render = $this->render($array_msj, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
    
  function consultar($novedad) {
		$gui = file_get_contents("static/modules/novedades/consultar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Consultar Novedad");
    $novedad["contenido"] = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $novedad["contenido"]);
    $novedad = $this->set_dict($novedad);
		$render = $this->render($novedad, $gui);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  */
}
?>