<?php


class MaletinView extends View{

	function panel($maletines) {
		$gui = file_get_contents("static/modules/maletin/panel.html");
		$lst_maletin = file_get_contents("static/modules/maletin/lst_maletin.html");
		$menu = file_get_contents("static/menu.html");
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$dict = array("{titulo}"=>"Sistema de Gestión de Documentación");
		$lst_maletin = $this->render_regex("repetir", $lst_maletin, $maletines);
    $render = str_replace('{lst_maletin}', $lst_maletin, $gui);
    $render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
}
?>