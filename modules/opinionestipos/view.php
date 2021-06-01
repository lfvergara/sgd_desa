<?php


class OpinionesTiposView extends View{
  function panel($tipos) {
		$gui = file_get_contents("static/modules/opinionestipos/panel.html");
		$gui_tbl_opinionestipos = file_get_contents("static/modules/opinionestipos/tbl_opinionestipos.html");
		$menu = file_get_contents("static/menu.html");
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict = array("{titulo}"=>"Gestión de Tipos de Opiniones");
    
    if(!is_array($tipos))$tipos=array();
		$gui_tbl_opinionestipos = $this->render_regex("repetir", $gui_tbl_opinionestipos, $tipos);
    $render = str_replace('{tbl_opinionestipos}', $gui_tbl_opinionestipos, $gui);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
	function editar($tipo, $array_msj) {
		$gui = file_get_contents("static/modules/opinionestipos/editar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Actualización de Tipo de Opinión");
    
    $tipo = $this->set_dict($tipo);
		$render = $this->render($tipo, $gui);
    $render = $this->render($array_msj, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
}
?>