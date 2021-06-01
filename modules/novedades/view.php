<?php


class NovedadesView extends View{
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
    $dict = array("{titulo}"=>"Consultar Novedad");
    $novedad["contenido"] = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br />", $novedad["contenido"]);
    $novedad = $this->set_dict($novedad);
		$render = $this->render($novedad, $gui);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
}
?>