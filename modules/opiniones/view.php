<?php


class OpinionesView extends View{
  function panel($opiniones, $tipos) {
		$gui = file_get_contents("static/modules/opiniones/panel.html");
		$gui_tbl_opiniones = file_get_contents("static/modules/opiniones/tbl_opiniones.html");
		$menu = file_get_contents("static/menu.html");
    
    $gui_slt_opinionestipos = file_get_contents("static/common/slt_opinionestipos.html");
		$gui_slt_opinionestipos = $this->render_regex('repetir', $gui_slt_opinionestipos, $tipos);
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict = array("{titulo}"=>"Gestión de Opiniones");
    
    if(!is_array($opiniones))$opiniones=array();
    if(!is_array($tipos))$tipos=array();
		$gui_tbl_opiniones = $this->render_regex("repetir", $gui_tbl_opiniones, $opiniones);
    $render = str_replace('{tbl_opiniones}', $gui_tbl_opiniones, $gui);
    $render = str_replace('{slt_opinionestipos}', $gui_slt_opinionestipos, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
	function agregar($matriculado, $tipos, $array_msj) {
		$gui = file_get_contents("static/modules/opiniones/agregar.html");
		$menu = file_get_contents("static/menu.html");
    
    $gui_slt_opinionestipos = file_get_contents("static/common/slt_opinionestipos.html");
		$gui_slt_opinionestipos = $this->render_regex('repetir', $gui_slt_opinionestipos, $tipos);
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Agregar Opinión");
    
    $matriculado = $this->set_dict($matriculado);
		$render = $this->render($matriculado, $gui);
    $render = str_replace('{slt_opinionestipos}', $gui_slt_opinionestipos, $render);
    $render = $this->render($array_msj, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
  function dgip($matriculado, $array_msj) {
		$gui = file_get_contents("static/modules/opiniones/dgip.html");
		$menu = file_get_contents("static/menu.html");
    
    $restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Agregar Opinión");
    
    $matriculado = $this->set_dict($matriculado);
		$render = $this->render($matriculado, $gui);
    $render = $this->render($array_msj, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
  function consultar($opinion) {
		$gui = file_get_contents("static/modules/opiniones/consultar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Consultar Opinión");
    
    $opinion = $this->set_dict($opinion);
		$render = $this->render($opinion, $gui);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
}
?>