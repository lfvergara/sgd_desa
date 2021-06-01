<?php


class AuditorView extends View{

	function listar($auditorias) {
		$gui = file_get_contents("static/modules/auditor/listar.html");
		$menu = file_get_contents("static/menu.html");
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$dict = array("{titulo}"=>"Sistema de Gestión de Documentación");
		$render = $this->render_regex("repetir", $gui, $auditorias);
    $render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
}
?>
