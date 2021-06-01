<?php


class EventosView extends View{
  function panel($eventos) {
		$gui = file_get_contents("static/modules/eventos/panel.html");
		$gui_tbl_eventos = file_get_contents("static/modules/eventos/tbl_eventos.html");
		$menu = file_get_contents("static/menu.html");
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict = array("{titulo}"=>"Gestión de Agenda");
    
    if(!is_array($eventos))$eventos=array();
		$gui_tbl_eventos = $this->render_regex("repetir", $gui_tbl_eventos, $eventos);
    $render = str_replace('{tbl_eventos}', $gui_tbl_eventos, $gui);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
  function traer_form_editar_evento_ajax($evento) {
		$gui = file_get_contents("static/modules/eventos/form_editar_evento_ajax.html");
    
    $evento = $this->set_dict($evento);
		$gui = $this->render($evento, $gui);
		$gui = str_replace('{app_name}', APP_NAME, $gui);
    print $gui;
	}
  
  function consultar_evento_ajax($evento) {
		$gui = file_get_contents("static/modules/eventos/consultar_evento_ajax.html");
    
    $evento = $this->set_dict($evento);
		$gui = $this->render($evento, $gui);
		$gui = str_replace('{app_name}', APP_NAME, $gui);
    print $gui;
	}
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
	function agregar() {
		$gui = file_get_contents("static/modules/eventos/agregar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Agregar Evento a Agenda");
    
		$render = $this->render($dict, $gui);
		print $this->render_template($menu, $render);
	}
	
	function editar($evento, $array_msj) {
		$gui = file_get_contents("static/modules/eventos/editar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Actualización de Evento");
    
    $evento = $this->set_dict($evento);
		$render = $this->render($evento, $gui);
    $render = $this->render($array_msj, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
  function consultar($evento) {
		$gui = file_get_contents("static/modules/eventos/consultar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Consultar Evento");
    $evento = $this->set_dict($evento);
		$render = $this->render($evento, $gui);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
}
?>